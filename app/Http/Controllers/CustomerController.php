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
            'wilayah' => 'required|in:Jakarta,Depok,Bekasi,Tangerang,Bogor,Jawa Barat,Jawa Tengah,Jawa Timur',
        ]);

        $cart = Session::get('cart', []);

        // Calculate total items
        $totalItems = array_sum(array_column($cart, 'quantity'));
        $totalWeight = ceil($totalItems / 3);

        // Shipping rates per kg
        $rates = [
            'Jakarta' => 24000,
            'Depok' => 24000,
            'Bekasi' => 25000,
            'Tangerang' => 25000,
            'Bogor' => 27000,
            'Jawa Barat' => 31000,
            'Jawa Tengah' => 39000,
            'Jawa Timur' => 47000,
        ];

        $ongkir = $rates[$request->wilayah] * $totalWeight;

        return response()->json([
            'success' => true,
            'ongkir' => $ongkir,
            'formatted_ongkir' => 'Rp ' . number_format($ongkir, 0, ',', '.'),
            'region' => $request->wilayah,
            'weight' => $totalWeight,
        ]);
    }

    /**
     * Process order (create pending transaction)
     */
    public function placeOrder(Request $request)
    {
        // Validate all required fields
        $validated = $request->validate([
            'nama_pembeli' => 'required|string|max:255',
            'no_telp_pembeli' => 'required|string|max:20',
            'wilayah' => 'required|in:Jakarta,Depok,Bekasi,Tangerang,Bogor,Jawa Barat,Jawa Tengah,Jawa Timur',
            'alamat' => 'required|string',
            'ongkir' => 'required|numeric|min:0',
        ]);

        $cart = Session::get('cart', []);

        if (empty($cart)) {
            return redirect()->route('customer.catalog')->with('error', 'Keranjang kosong!');
        }

        DB::beginTransaction();

        try {
            // Generate unique transaction number
            $noTransaksi = 'TRX' . date('Ymd') . str_pad(Transaksi::whereDate('created_at', today())->count() + 1, 4, '0', STR_PAD_LEFT);

            // Calculate total harga from cart
            $totalHarga = 0;
            foreach ($cart as $id => $item) {
                $kaos = Kaos::find($id);
                if ($kaos) {
                    $totalHarga += $kaos->harga_jual * $item['quantity'];
                }
            }

            // Create transaction (status: pending)
            $transaksi = Transaksi::create([
                'no_transaksi' => $noTransaksi,
                'nama_pembeli' => $validated['nama_pembeli'],
                'alamat' => $validated['alamat'],
                'no_telp_pembeli' => $validated['no_telp_pembeli'],
                'wilayah' => $validated['wilayah'],
                'total_harga' => $totalHarga,
                'ongkir' => $validated['ongkir'],
                'pemasukan' => $totalHarga + $validated['ongkir'], // Grand total
                'status' => 'pending',
                'metode_pembayaran' => 'Bank Transfer',
            ]);

            // Create item entries
            foreach ($cart as $id => $item) {
                $kaos = Kaos::find($id);
                if ($kaos) {
                    TransaksiItem::create([
                        'transaksi_id' => $transaksi->id,
                        'id_kaos' => $id,
                        'qty' => $item['quantity'],
                        'harga' => $kaos->harga_jual,
                        'subtotal' => $kaos->harga_jual * $item['quantity'],
                    ]);
                }
            }

            // Clear cart
            Session::forget('cart');

            DB::commit();

            return redirect()->route('customer.order.success', $transaksi->id)
                ->with('success', 'Pesanan berhasil dibuat! Mohon tunggu konfirmasi dari kasir.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal membuat pesanan: ' . $e->getMessage());
        }
    }

    /**
     * Show order success page
     */
    public function orderSuccess($id)
    {
        $transaksi = Transaksi::with('transaksiItems.kaos')->findOrFail($id);

        return view('customer.order-success', compact('transaksi'));
    }
}
