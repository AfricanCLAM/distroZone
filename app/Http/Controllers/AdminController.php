<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Kaos;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    // ==================== DASHBOARD ====================

    public function dashboard()
    {
        $totalKaos = Kaos::count();
        $totalKaryawan = User::whereIn('role', ['kasir online', 'kasir offline'])->count();

        // CHANGED: Use transaksi instead of laporan
        $pemasukanHariIni = Transaksi::where('status', 'validated')
            ->whereDate('validated_at', today())
            ->sum('pemasukan');

        $transaksiHariIni = Transaksi::where('status', 'validated')
            ->whereDate('validated_at', today())
            ->count();

        // Additional useful stats
        $transaksiPending = Transaksi::where('status', 'pending')->count();

        return view('admin.dashboard', compact(
            'totalKaos',
            'totalKaryawan',
            'pemasukanHariIni',
            'transaksiHariIni',
            'transaksiPending',
        ));
    }

    // ==================== KARYAWAN MANAGEMENT ====================

    public function karyawanIndex(Request $request)
    {
        $query = User::whereIn('role', ['kasir online', 'kasir offline']);

        // Live search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('NIK', 'LIKE', "%{$search}%")
                    ->orWhere('nama', 'LIKE', "%{$search}%")
                    ->orWhere('username', 'LIKE', "%{$search}%");
            });
        }

        $karyawans = $query->orderBy('nama')->paginate(15);

        // If AJAX request, return partial view
        if ($request->ajax()) {
            return view('admin.karyawan.partials.table', compact('karyawans'))->render();
        }

        return view('admin.karyawan.index', compact('karyawans'));
    }

    public function karyawanCreate()
    {
        return view('admin.karyawan.create');
    }

    public function karyawanStore(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'alamat' => 'required|string',
            'password' => 'required|string|min:6',
            'no_telp' => 'required|string|max:20',
            'NIK' => 'required|string|max:20|unique:users,NIK',
            'role' => 'required|in:kasir online,kasir offline',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'shift_start' => 'nullable|date_format:H:i',
            'shift_end' => 'nullable|date_format:H:i',
        ]);

        $data = $request->except('foto');

        // Handle photo upload
        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('karyawan', 'public');
        }

        $latestKID = User::max('kID'); // e.g. "K001"

        // Extract the number part
        $number = intval(substr($latestKID, 1)); // 1

        // Increment
        $number++;

        // Rebuild with leading zeros
        $newKID = 'K' . str_pad($number, 3, '0', STR_PAD_LEFT);

        $data['kID'] = $newKID;

        User::create($data);

        return redirect()->route('admin.karyawan.index')
            ->with('success', 'Karyawan berhasil ditambahkan!');
    }

    public function karyawanEdit($id)
    {
        $karyawan = User::findOrFail($id);
        return view('admin.karyawan.edit', compact('karyawan'));
    }

    public function karyawanUpdate(Request $request, $id)
    {
        $karyawan = User::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'password' => 'nullable|string|min:6',
            'no_telp' => 'required|string|max:20',
            'NIK' => 'required|string|max:20|unique:users,NIK,' . $id,
            'role' => 'required|in:kasir online,kasir offline',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'shift_start' => 'nullable|date_format:H:i',
            'shift_end' => 'nullable|date_format:H:i',
        ]);

        $data = $request->except(['foto', 'password']);

        // Handle photo upload
        if ($request->hasFile('foto')) {
            // Delete old photo
            if ($karyawan->foto) {
                Storage::disk('public')->delete($karyawan->foto);
            }
            $data['foto'] = $request->file('foto')->store('karyawan', 'public');
        }

        $karyawan->update($data);

        return redirect()->route('admin.karyawan.index')
            ->with('success', 'Karyawan berhasil diupdate!');
    }

    public function karyawanDestroy($id)
    {
        $karyawan = User::findOrFail($id);

        // Delete photo
        if ($karyawan->foto) {
            Storage::disk('public')->delete($karyawan->foto);
        }

        $karyawan->delete();

        return redirect()->route('admin.karyawan.index')
            ->with('success', 'Karyawan berhasil dihapus!');
    }

    // ==================== KAOS MANAGEMENT ====================

    public function kaosIndex(Request $request)
    {
        $query = Kaos::query();

        // Live search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('merek', 'LIKE', "%{$search}%")
                    ->orWhere('tipe', 'LIKE', "%{$search}%")
                    ->orWhere('warna_kaos', 'LIKE', "%{$search}%");
            });
        }

        $kaos = $query->orderBy('merek')->paginate(15);

        // If AJAX request, return partial view
        if ($request->ajax()) {
            return view('admin.kaos.partials.table', compact('kaos'))->render();
        }

        return view('admin.kaos.index', compact('kaos'));
    }

    public function kaosCreate()
    {
        return view('admin.kaos.create');
    }

    public function kaosStore(Request $request)
    {
        $request->validate([
            'merek' => 'required|string|max:255',
            'tipe' => 'required|in:Lengan Panjang,Lengan Pendek',
            'warna_kaos' => 'required|string|max:255',
            'harga_jual' => 'required|numeric|min:0',
            'harga_pokok' => 'required|numeric|min:0',
            'stok_kaos' => 'required|integer|min:0',
            'ukuran' => 'required|in:XS,S,M,L,XL,2XL,3XL,4XL,5XL',
            'foto_kaos' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->except('foto_kaos');

        $latestKID = Kaos::max('tID'); // e.g. "T001"

        // Extract the number part
        $number = intval(substr($latestKID, 1)); // 1

        // Increment
        $number++;

        // Rebuild with leading zeros
        $newTID = 'T' . str_pad($number, 3, '0', STR_PAD_LEFT);

        $data['tID'] = $newTID;

        // Handle photo upload
        if ($request->hasFile('foto_kaos')) {
            $data['foto_kaos'] = $request->file('foto_kaos')->store('kaos', 'public');
        }

        Kaos::create($data);

        return redirect()->route('admin.kaos.index')
            ->with('success', 'Kaos berhasil ditambahkan!');
    }

    public function kaosEdit($id)
    {
        $kaos = Kaos::findOrFail($id);
        return view('admin.kaos.edit', compact('kaos'));
    }

    public function kaosUpdate(Request $request, $id)
    {
        $kaos = Kaos::findOrFail($id);

        $request->validate([
            'merek' => 'required|string|max:255',
            'tipe' => 'required|in:Lengan Panjang,Lengan Pendek',
            'warna_kaos' => 'required|string|max:255',
            'harga_jual' => 'required|numeric|min:0',
            'harga_pokok' => 'required|numeric|min:0',
            'stok_kaos' => 'required|integer|min:0',
            'ukuran' => 'required|in:XS,S,M,L,XL,2XL,3XL,4XL,5XL',
            'foto_kaos' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->except('foto_kaos');

        // Handle photo upload
        if ($request->hasFile('foto_kaos')) {
            // Delete old photo
            if ($kaos->foto_kaos) {
                Storage::disk('public')->delete($kaos->foto_kaos);
            }
            $data['foto_kaos'] = $request->file('foto_kaos')->store('kaos', 'public');
        }

        $kaos->update($data);

        return redirect()->route('admin.kaos.index')
            ->with('success', 'Kaos berhasil diupdate!');
    }

    public function kaosDestroy($id)
    {
        $kaos = Kaos::findOrFail($id);

        // Delete photo
        if ($kaos->foto_kaos) {
            Storage::disk('public')->delete($kaos->foto_kaos);
        }

        $kaos->delete();

        return redirect()->route('admin.kaos.index')
            ->with('success', 'Kaos berhasil dihapus!');
    }

    // ==================== LAPORAN / REPORTS ====================
    public function laporanIndex(Request $request)
    {
        // Base query: only completed transactions
        $query = Transaksi::with(['kasir', 'items.kaos'])
            ->where('status', 'validated')
            ->orderBy('validated_at', 'desc');

        // Filter by date range
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('validated_at', [
                $request->start_date . ' 00:00:00',
                $request->end_date . ' 23:59:59',
            ]);
        }

        // Filter by payment method
        if ($request->filled('metode_pembayaran')) {
            $query->where('metode_pembayaran', $request->metode_pembayaran);
        }

        // Filter by kasir
        if ($request->filled('id_kasir')) {
            $query->where('id_kasir', $request->id_kasir);
        }

        // Get paginated results
        $transaksis = $query->paginate(20)->withQueryString();

        // Calculate totals
        $totalPemasukan = $query->sum('pemasukan');
        $totalTransaksi = $query->count();
        $totalOngkir = $query->sum('ongkir');

        // Get all kasir for filter dropdown
        $kasirs = User::whereIn('role', ['kasir online', 'kasir offline'])->get();

        return view('admin.laporan.index', compact(
            'transaksis',
            'totalPemasukan',
            'totalTransaksi',
            'totalOngkir',
            'kasirs'
        ));
    }
}
