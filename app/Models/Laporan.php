<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    use HasFactory;

    // Table name
    protected $table = 'laporan';

    // Primary key
    protected $primaryKey = 'id';

    // No timestamps
    public $timestamps = false;

    // Mass-assignable fields
    protected $fillable = [
        'id_karyawan',
        'pemasukan',
        'waktu_transaksi',
        'struk',
        'metode_pembayaran',
    ];

    // Cast attributes
    protected $casts = [
        'id_karyawan' => 'integer',
        'pemasukan' => 'integer',
        'waktu_transaksi' => 'datetime',
    ];

    // --- RELATIONSHIPS ---

    /**
     * Laporan belongs to a karyawan (user)
     */
    public function karyawan()
    {
        return $this->belongsTo(User::class, 'id_karyawan', 'id');
    }

    // --- HELPER METHODS ---

    /**
     * Get formatted income for display
     */
    public function getFormattedPemasukanAttribute()
    {
        return 'Rp ' . number_format($this->pemasukan, 0, ',', '.');
    }

    /**
     * Check payment method
     */
    public function isCashPayment()
    {
        return strtolower($this->metode_pembayaran) === 'cash';
    }

    public function isQrisPayment()
    {
        return strtolower($this->metode_pembayaran) === 'qris';
    }

    public function isBankTransferPayment()
    {
        return strtolower($this->metode_pembayaran) === 'bank transfer';
    }
}
