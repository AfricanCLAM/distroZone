<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\ItemTransaksi;
use App\Models\Kaos;
use App\Models\Laporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class TransaksiController extends Controller
{
    /**
     * Display all pending transactions (for kasir online)
     */
    public function index()
    {
        // Get all pending transactions with items
        $transaksis = Transaksi::with(['items.kaos', 'kasir'])
            ->where('status', 'pending')
            ->orderBy('waktu_transaksi', 'desc')
            ->get();

        return view('kasir.transaksi.index', compact('transaksis'));
    }

    /**
     * Show detail of a specific transaction
     */
    public function show($id)
    {
        $transaksi = Transaksi::with(['items.kaos', 'kasir'])
            ->findOrFail($id);

        return view('kasir.transaksi.show', compact('transaksi'));
    }

    /**
     * Confirm/Verify a transaction (ACC)
     */
    public function confirm(Request $request, $id)
    {
        // Validate payment method
        $request->validate([
            'metode_pembayaran' => 'required|in:Bank Transfer',
        ]);

        DB::beginTransaction();

        try {
            // Find transaction
            $transaksi = Transaksi::with('items.kaos')->findOrFail($id);

            // Check if already completed
            if ($transaksi->isCompleted()) {
                return redirect()->back()->with('error', 'Transaksi sudah dikonfirmasi sebelumnya.');
            }

            // 1. Check stock availability for all items
            foreach ($transaksi->items as $item) {
                if (!$item->kaos->hasStock($item->jumlah)) {
                    throw new \Exception("Stok tidak cukup untuk {$item->kaos->merek} ukuran {$item->kaos->ukuran}");
                }
            }

            // 2. Decrement stock for each item
            foreach ($transaksi->items as $item) {
                $item->kaos->decrementStock($item->jumlah);
            }

            // 3. Update transaction status
            $transaksi->status = 'completed';
            $transaksi->save();

            // 4. Generate PDF receipt
            $strukFilename = 'struk_' . $transaksi->id . '_' . time() . '.pdf';
            $pdf = $this->generateStrukPDF($transaksi);
            $pdf->save(storage_path('app/public/struk/' . $strukFilename));

            // 5. Create laporan entry (audit trail)
            Laporan::create([
                'id_karyawan' => Auth::id(),
                'pemasukan' => $transaksi->grand_total,
                'waktu_transaksi' => now(),
                'struk' => $strukFilename,
                'metode_pembayaran' => $request->metode_pembayaran,
            ]);

            DB::commit();

            return redirect()->route('kasir.transaksi.index')
                ->with('success', 'Transaksi berhasil dikonfirmasi!')
                ->with('struk_url', asset('storage/struk/' . $strukFilename));

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal konfirmasi transaksi: ' . $e->getMessage());
        }
    }

    /**
     * Cancel a transaction
     */
    public function cancel($id)
    {
        $transaksi = Transaksi::findOrFail($id);

        if ($transaksi->isCompleted()) {
            return redirect()->back()->with('error', 'Transaksi yang sudah selesai tidak bisa dibatalkan.');
        }

        $transaksi->status = 'cancelled';
        $transaksi->save();

        return redirect()->route('kasir.transaksi.index')
            ->with('success', 'Transaksi berhasil dibatalkan.');
    }

    /**
     * Generate PDF receipt
     */
    private function generateStrukPDF($transaksi)
    {
        $data = [
            'transaksi' => $transaksi,
            'items' => $transaksi->items,
        ];

        $pdf = Pdf::loadView('pdf.struk', $data);
        $pdf->setPaper([0, 0, 226.77, 566.93], 'portrait'); // 80mm width thermal paper

        return $pdf;
    }

    /**
     * Download receipt PDF
     */
    public function downloadStruk($id)
    {
        $transaksi = Transaksi::with('items.kaos')->findOrFail($id);

        if (!$transaksi->isCompleted()) {
            return redirect()->back()->with('error', 'Struk hanya tersedia untuk transaksi yang sudah selesai.');
        }

        $pdf = $this->generateStrukPDF($transaksi);

        return $pdf->download('struk_' . $transaksi->id . '.pdf');
    }

    /**
     * Show kasir's own transaction history
     */
    public function myTransactions()
    {
        $transaksis = Transaksi::with(['items.kaos'])
            ->where('id_kasir', Auth::id())
            ->where('status', 'completed')
            ->orderBy('waktu_transaksi', 'desc')
            ->paginate(20);

        return view('kasir.transaksi.history', compact('transaksis'));
    }
}
