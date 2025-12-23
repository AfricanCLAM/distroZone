<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Support\Facades\Auth;

class KasirController extends Controller
{
    /**
     * Display kasir dashboard
     */
    public function dashboard()
    {
        $user = Auth::user();

        // Count pending transactions (for kasir online)
        $pendingCount = 0;
        if ($user->isKasirOnline()) {
            $pendingCount = Transaksi::where('status', 'pending')->count();
        }

        // Count today's transactions by this kasir
        $todayCount = Transaksi::where('id_kasir', $user->id)
            ->where('status', 'validated')
            ->whereDate('validated_at', today())
            ->count();

        // Total completed transactions by this kasir
        $totalCompleted = Transaksi::where('id_kasir', $user->id)
            ->where('status', 'validated')
            ->count();

        return view('kasir.dashboard', compact('pendingCount', 'todayCount', 'totalCompleted'));
    }
}
