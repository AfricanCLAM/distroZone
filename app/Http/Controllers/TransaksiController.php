<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
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
        $transaksis = Transaksi::with(['transaksiItems.kaos', 'kasir'])
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
        $transaksi = Transaksi::with(['transaksiItems.kaos', 'kasir'])
            ->findOrFail($id);

        return view('kasir.transaksi.show', compact('transaksi'));
    }

    /**
     * Confirm/Verify a transaction (ACC)
     */
    public function confirm(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            // Find transaction
            $transaksi = Transaksi::with('transaksiItems.kaos')->findOrFail($id);

            // Check if already completed/validated
            if ($transaksi->isCompleted() || $transaksi->isValidated()) {
                return redirect()->back()->with('error', 'Transaksi sudah dikonfirmasi sebelumnya.');
            }

            // 1. Check stock availability for all items
            foreach ($transaksi->transaksiItems as $item) {
                if (!$item->kaos->hasStock($item->qty)) {
                    throw new \Exception("Stok tidak cukup untuk {$item->kaos->merek} ukuran {$item->kaos->ukuran}");
                }
            }

            // 2. Decrement stock for each item
            foreach ($transaksi->transaksiItems as $item) {
                $item->kaos->decrementStock($item->qty);
            }

            // 3. Update transaction status
            $transaksi->status = 'validated';
            $transaksi->id_kasir = Auth::user()->id;
            $transaksi->validated_at = now();
            $transaksi->save();

            // 4. Generate PDF receipt
            $strukFilename = 'struk_' . $transaksi->no_transaksi . '_' . time() . '.pdf';
            $pdf = $this->generateStrukPDF($transaksi);

            // Ensure directory exists
            $strukPath = storage_path('app/public/struk');
            if (!file_exists($strukPath)) {
                mkdir($strukPath, 0755, true);
            }

            $pdf->save($strukPath . '/' . $strukFilename);

            // 5. Update struk field in transaction
            $transaksi->struk = $strukFilename;
            $transaksi->save();

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

        if ($transaksi->isValidated()) {
            return redirect()->back()->with('error', 'Transaksi yang sudah selesai tidak bisa dibatalkan.');
        }

        $transaksi->id_kasir = Auth::user()->id;
        $transaksi->status = 'rejected';
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
            'items' => $transaksi->transaksiItems,
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
        $transaksi = Transaksi::with('transaksiItems.kaos')->findOrFail($id);

        if (!$transaksi->isValidated()) {
            return redirect()->back()->with('error', 'Struk hanya tersedia untuk transaksi yang sudah selesai.');
        }

        $pdf = $this->generateStrukPDF($transaksi);

        return $pdf->download('struk_' . $transaksi->no_transaksi . '.pdf');
    }

    /**
     * Show kasir's own transaction history
     */
    public function myTransactions()
    {
        $transaksis = Transaksi::with(['transaksiItems.kaos'])
            ->where('id_kasir', Auth::user()->id)
            ->whereIn('status', ['validated','rejected'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('kasir.transaksi.history', compact('transaksis'));
    }
}
