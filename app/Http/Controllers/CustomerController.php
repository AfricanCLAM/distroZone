<?php

namespace App\Http\Controllers;

use App\Models\Kaos;
use App\Models\Transaksi;
use App\Models\ItemTransaksi;
use App\Models\TransaksiItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CustomerController extends Controller
{
    /**
     * Show kaos catalog
     */
    public function index()
    {
        // Get all available kaos (in stock)
        $kaos = Kaos::where('stok_kaos', '>', 0)
            ->orderBy('merek')
            ->paginate(12);

        return view('customer.catalog', compact('kaos'));
    }

    /**
     * Show kaos detail
     */
    public function show($id)
    {
        $kaos = Kaos::findOrFail($id);

        return view('customer.detail', compact('kaos'));
    }

    /**
     * Show cart
     */
    public function cart()
    {
        $cart = Session::get('cart', []);

        // Calculate totals
        $subtotal = 0;
        $cartItems = [];

        foreach ($cart as $id => $item) {
            $kaos = Kaos::find($id);
            if ($kaos) {
                $cartItems[] = [
                    'kaos' => $kaos,
                    'quantity' => $item['quantity'],
                    'subtotal' => $kaos->harga_jual * $item['quantity'],
                ];
                $subtotal += $kaos->harga_jual * $item['quantity'];
            }
        }

        return view('customer.cart', compact('cartItems', 'subtotal'));
    }

    /**
     * Add to cart
     */
    public function addToCart(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $kaos = Kaos::findOrFail($id);

        // Check stock
        if (!$kaos->hasStock($request->quantity)) {
            return redirect()->back()->with('error', 'Stok tidak mencukupi.');
        }

        // Get cart from session
        $cart = Session::get('cart', []);

        // Add or update item
        if (isset($cart[$id])) {
            $cart[$id]['quantity'] += $request->quantity;
        } else {
            $cart[$id] = [
                'quantity' => $request->quantity,
            ];
        }

        Session::put('cart', $cart);

        return redirect()->route('customer.cart')->with('success', 'Item berhasil ditambahkan ke keranjang!');
    }

    /**
     * Update cart item quantity
     */
    public function updateCart(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = Session::get('cart', []);

        if (isset($cart[$id])) {
            $kaos = Kaos::find($id);

            // Check stock
            if (!$kaos->hasStock($request->quantity)) {
                return redirect()->back()->with('error', 'Stok tidak mencukupi.');
            }

            $cart[$id]['quantity'] = $request->quantity;
            Session::put('cart', $cart);

            return redirect()->back()->with('success', 'Keranjang berhasil diupdate!');
        }

        return redirect()->back()->with('error', 'Item tidak ditemukan di keranjang.');
    }

    /**
     * Remove from cart
     */
    public function removeFromCart($id)
    {
        $cart = Session::get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            Session::put('cart', $cart);
            return redirect()->back()->with('success', 'Item berhasil dihapus dari keranjang.');
        }

        return redirect()->back()->with('error', 'Item tidak ditemukan.');
    }

    /**
     * Show checkout form
     */
    public function checkout()
    {
        $cart = Session::get('cart', []);

        if (empty($cart)) {
            return redirect()->route('customer.catalog')->with('error', 'Keranjang kosong!');
        }

        // Prepare cart items with details
        $cartItems = [];
        $subtotal = 0;
        $totalItems = 0;

        foreach ($cart as $id => $item) {
            $kaos = Kaos::find($id);
            if ($kaos) {
                $cartItems[] = [
                    'kaos' => $kaos,
                    'quantity' => $item['quantity'],
                    'subtotal' => $kaos->harga_jual * $item['quantity'],
                ];
                $subtotal += $kaos->harga_jual * $item['quantity'];
                $totalItems += $item['quantity'];
            }
        }

        // Calculate weight (3 items = 1 kg)
        $totalWeight = ceil($totalItems / 3);

        return view('customer.checkout', compact('cartItems', 'subtotal', 'totalWeight'));
    }

    /**
     * Calculate shipping cost (AJAX)
     */
    public function calculateShipping(Request $request)
    {
        $request->validate([
            'alamat' => 'required|string',
        ]);

        $alamat = strtolower($request->alamat);
        $cart = Session::get('cart', []);

        // Calculate total items
        $totalItems = array_sum(array_column($cart, 'quantity'));
        $totalWeight = ceil($totalItems / 3);

        // Shipping rates
        $rates = [
            'jakarta' => 24000,
            'depok' => 24000,
            'bekasi' => 25000,
            'tangerang' => 25000,
            'bogor' => 27000,
            'jawa barat' => 31000,
            'jawa tengah' => 39000,
            'jawa timur' => 47000,
        ];

        $ongkir = 0;
        $region = 'Unknown';

        foreach ($rates as $key => $rate) {
            if (strpos($alamat, $key) !== false) {
                $ongkir = $rate * $totalWeight;
                $region = ucwords($key);
                break;
            }
        }

        // Default to Jawa Barat if no match
        if ($ongkir == 0) {
            $ongkir = $rates['jawa barat'] * $totalWeight;
            $region = 'Jawa Barat (Default)';
        }

        return response()->json([
            'success' => true,
            'ongkir' => $ongkir,
            'formatted_ongkir' => 'Rp ' . number_format($ongkir, 0, ',', '.'),
            'region' => $region,
            'weight' => $totalWeight,
        ]);
    }

    /**
     * Process order (create pending transaction)
     */
    public function placeOrder(Request $request)
    {
        $request->validate([
            'nama_pembeli' => 'required|string|max:255',
            'alamat' => 'required|string',
            'no_telp_pembeli' => 'required|string|max:20',
        ]);

        $cart = Session::get('cart', []);

        if (empty($cart)) {
            return redirect()->route('customer.catalog')
                ->with('error', 'Keranjang kosong!');
        }

        DB::beginTransaction();

        try {
            // 1. Generate transaction number
            $lastTransaksi = Transaksi::orderBy('id', 'desc')->first();
            $noTransaksi = $lastTransaksi ? $lastTransaksi->no_transaksi + 1 : 1;

            // 2. Determine wilayah from address
            $alamat = strtolower($request->alamat);
            $wilayah = $this->determineWilayah($alamat);

            // 3. Create transaction (status: pending)
            $transaksi = Transaksi::create([
                'no_transaksi' => $noTransaksi,
                'id_kasir' => null, // Will be set when kasir validates
                'nama_pembeli' => $request->nama_pembeli,
                'alamat' => $request->alamat,
                'no_telp_pembeli' => $request->no_telp_pembeli,
                'wilayah' => $wilayah,
                'status' => 'pending',
                'metode_pembayaran' => null, // Will be set during validation
                'total_harga' => 0, // Will be calculated
                'ongkir' => 0, // Will be calculated
                'pemasukan' => 0, // Will be calculated
            ]);

            // 4. Create transaction items
            foreach ($cart as $id => $item) {
                TransaksiItem::create([
                    'transaksi_id' => $transaksi->id,
                    'id_kaos' => $id,
                    'qty' => $item['quantity'],
                ]);
            }

            // 5. Calculate and save totals
            $transaksi->load('items.kaos'); // Eager load for calculation
            $transaksi->calculateTotals();
            $transaksi->save();

            // 6. Clear cart
            Session::forget('cart');

            DB::commit();

            return redirect()->route('customer.order.success', $transaksi->id)
                ->with('success', 'Pesanan berhasil dibuat! Mohon tunggu konfirmasi dari kasir.');

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->with('error', 'Gagal membuat pesanan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Helper: Determine region from address
     */
    private function determineWilayah($alamat)
    {
        $alamat = strtolower($alamat);

        $regions = [
            'jakarta' => 'Jakarta',
            'depok' => 'Depok',
            'bekasi' => 'Bekasi',
            'tangerang' => 'Tangerang',
            'bogor' => 'Bogor',
            'jawa barat' => 'Jawa Barat',
            'jawa tengah' => 'Jawa Tengah',
            'jawa timur' => 'Jawa Timur',
        ];

        foreach ($regions as $key => $value) {
            if (strpos($alamat, $key) !== false) {
                return $value;
            }
        }

        return 'Jawa Barat'; // Default
    }

    /**
     * Show order success page
     */
    public function orderSuccess($id)
    {
        $transaksi = Transaksi::with('items.kaos')->findOrFail($id);

        return view('customer.order-success', compact('transaksi'));
    }
}
