<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\TransaksiItem;
use App\Models\Kaos;
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
        $transaksis = Transaksi::with(['items.kaos', 'kasir'])
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
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
     * This is the ONLY place where transactions are finalized
     */
    public function confirm(Request $request, $id)
    {
        $request->validate([
            'metode_pembayaran' => 'required|in:Bank Transfer',
        ]);

        DB::beginTransaction();

        try {
            // 1. Find transaction with items
            $transaksi = Transaksi::with('items.kaos')->findOrFail($id);

            // 2. Validate status
            if (!$transaksi->isPending()) {
                throw new \Exception('Transaksi sudah diproses sebelumnya.');
            }

            // 3. Check stock availability for ALL items
            foreach ($transaksi->items as $item) {
                if (!$item->kaos->hasStock($item->qty)) {
                    throw new \Exception("Stok tidak cukup untuk {$item->kaos->merek} ukuran {$item->kaos->ukuran}. Tersedia: {$item->kaos->stok_kaos}, diminta: {$item->qty}");
                }
            }

            // 4. Update transaction details
            $transaksi->status = 'completed';
            $transaksi->metode_pembayaran = $request->metode_pembayaran;
            $transaksi->id_kasir = Auth::id();
            $transaksi->validated_at = now();

            // 5. Calculate totals (if not already calculated)
            if ($transaksi->pemasukan == 0) {
                $transaksi->calculateTotals();
            }

            // 6. Generate and save receipt PDF
            $strukFilename = 'struk_' . $transaksi->id . '_' . time() . '.pdf';
            $pdf = $this->generateStrukPDF($transaksi);

            // Ensure directory exists
            $strukPath = storage_path('app/public/struk');
            if (!file_exists($strukPath)) {
                mkdir($strukPath, 0755, true);
            }

            $pdf->save($strukPath . '/' . $strukFilename);
            $transaksi->struk = $strukFilename;

            // 7. Save transaction (this updates validated_at timestamp)
            $transaksi->save();

            // 8. Decrement stock for each item (AFTER validation)
            foreach ($transaksi->items as $item) {
                $item->kaos->decrementStock($item->qty);
            }

            DB::commit();

            return redirect()->route('kasir.transaksi.index')
                ->with('success', 'Transaksi #' . $transaksi->id . ' berhasil dikonfirmasi!')
                ->with('struk_url', asset('storage/struk/' . $strukFilename));

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->with('error', 'Gagal konfirmasi transaksi: ' . $e->getMessage());
        }
    }

    /**
     * Reject/Cancel a transaction
     */
    public function cancel($id)
    {
        DB::beginTransaction();

        try {
            $transaksi = Transaksi::findOrFail($id);

            if (!$transaksi->isPending()) {
                throw new \Exception('Hanya transaksi pending yang bisa dibatalkan.');
            }

            $transaksi->status = 'rejected';
            $transaksi->validated_at = now();
            $transaksi->id_kasir = Auth::id();
            $transaksi->save();

            DB::commit();

            return redirect()->route('kasir.transaksi.index')
                ->with('success', 'Transaksi #' . $transaksi->id . ' berhasil dibatalkan.');

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->with('error', 'Gagal membatalkan transaksi: ' . $e->getMessage());
        }
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
        $pdf->setPaper([0, 0, 226.77, 566.93], 'portrait'); // 80mm thermal paper

        return $pdf;
    }

    /**
     * Download receipt PDF
     */
    public function downloadStruk($id)
    {
        $transaksi = Transaksi::with('items.kaos')->findOrFail($id);

        if (!$transaksi->isCompleted()) {
            return redirect()->back()
                ->with('error', 'Struk hanya tersedia untuk transaksi yang sudah selesai.');
        }

        if (!$transaksi->struk || !file_exists(storage_path('app/public/struk/' . $transaksi->struk))) {
            // Regenerate if missing
            $pdf = $this->generateStrukPDF($transaksi);
            return $pdf->download('struk_' . $transaksi->id . '.pdf');
        }

        return response()->download(
            storage_path('app/public/struk/' . $transaksi->struk),
            'struk_' . $transaksi->id . '.pdf'
        );
    }

    /**
     * Show kasir's own transaction history
     */
    public function myTransactions()
    {
        $transaksis = Transaksi::with(['items.kaos'])
            ->where('id_kasir', Auth::id())
            ->whereIn('status', ['completed', 'rejected'])
            ->orderBy('validated_at', 'desc')
            ->paginate(20);

        return view('kasir.transaksi.history', compact('transaksis'));
    }
}
