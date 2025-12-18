<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Kaos;
use App\Models\Laporan;
use App\Models\Shift;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    // ==================== DASHBOARD ====================

    public function dashboard()
    {
        $totalKaos = Kaos::count();
        $totalKaryawan = User::whereIn('role', ['kasir online', 'kasir offline'])->count();
        $totalPemasukan = Laporan::sum('pemasukan');
        $transaksiHariIni = Laporan::whereDate('waktu_transaksi', today())->count();

        return view('admin.dashboard', compact(
            'totalKaos',
            'totalKaryawan',
            'totalPemasukan',
            'transaksiHariIni'
        ));
    }

    // ==================== KARYAWAN MANAGEMENT ====================

    public function karyawanIndex()
    {
        $karyawans = User::whereIn('role', ['kasir online', 'kasir offline'])->paginate(15);
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
        $data['password'] = Hash::make($request->password);

        // Handle photo upload
        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('karyawan', 'public');
        }

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

        // Update password if provided
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

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

    public function kaosIndex()
    {
        $kaos = Kaos::orderBy('merek')->paginate(15);
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
        $query = Laporan::with('karyawan')->orderBy('waktu_transaksi', 'desc');

        // Filter by date range
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('waktu_transaksi', [
                $request->start_date . ' 00:00:00',
                $request->end_date . ' 23:59:59',
            ]);
        }

        // Filter by payment method
        if ($request->filled('metode_pembayaran')) {
            $query->where('metode_pembayaran', $request->metode_pembayaran);
}
    $laporans = $query->paginate(20);
    $totalPemasukan = $query->sum('pemasukan');

    return view('admin.laporan.index', compact('laporans', 'totalPemasukan'));
}

// ==================== SHIFT MANAGEMENT ====================

public function shiftIndex()
{
    $shifts = Shift::all();
    return view('admin.shift.index', compact('shifts'));
}

public function shiftStore(Request $request)
{
    $request->validate([
        'tipe' => 'required|string|max:255',
        'jam_buka' => 'required|date_format:H:i',
        'jam_tutup' => 'required|date_format:H:i',
    ]);

    Shift::create($request->all());

    return redirect()->route('admin.shift.index')
        ->with('success', 'Shift berhasil ditambahkan!');
}

public function shiftUpdate(Request $request, $id)
{
    $shift = Shift::findOrFail($id);

    $request->validate([
        'tipe' => 'required|string|max:255',
        'jam_buka' => 'required|date_format:H:i',
        'jam_tutup' => 'required|date_format:H:i',
    ]);

    $shift->update($request->all());

    return redirect()->route('admin.shift.index')
        ->with('success', 'Shift berhasil diupdate!');
}

public function shiftDestroy($id)
{
    $shift = Shift::findOrFail($id);
    $shift->delete();

    return redirect()->route('admin.shift.index')
        ->with('success', 'Shift berhasil dihapus!');
}
}
