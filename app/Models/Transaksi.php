<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    // Table name
    protected $table = 'transaksi';

    // Primary key
    protected $primaryKey = 'id';

    // Timestamps
    const CREATED_AT = 'created_at';
    const UPDATED_AT = null; // No updated_at column

    // Mass-assignable fields (matching actual database schema)
    protected $fillable = [
        'no_transaksi',
        'id_kasir',
        'nama_pembeli',
        'alamat',
        'no_telp_pembeli',
        'wilayah',
        'struk',
        'metode_pembayaran',
        'total_harga',
        'ongkir',
        'pemasukan',
        'status',
        'validated_at',
    ];

    // Cast attributes
    protected $casts = [
        'id_kasir' => 'integer',
        'total_harga' => 'integer',
        'ongkir' => 'integer',
        'pemasukan' => 'integer',
        'created_at' => 'datetime',
        'validated_at' => 'datetime',
    ];

    // --- RELATIONSHIPS ---

    /**
     * Transaction belongs to a kasir (user)
     */
    public function kasir()
    {
        return $this->belongsTo(User::class, 'id_kasir', 'id');
    }

    /**
     * Transaction has many transaction items
     * Using correct relationship name matching the actual table
     */
    public function transaksiItems()
    {
        return $this->hasMany(TransaksiItem::class, 'transaksi_id', 'id');
    }

    /**
     * Alias for transaksiItems for backward compatibility
     */
    public function items()
    {
        return $this->transaksiItems();
    }

    // --- HELPER METHODS ---

    /**
     * Check if transaction is pending
     */
    public function isPending()
    {
        return $this->status === 'pending';
    }

    /**
     * Check if transaction is validated
     */
    public function isValidated()
    {
        return $this->status === 'validated';
    }

    /**
     * Check if transaction is completed
     */
    public function isCompleted()
    {
        return $this->status === 'completed';
    }

    /**
     * Check if transaction is rejected
     */
    public function isRejected()
    {
        return $this->status === 'rejected';
    }

    /**
     * Check if transaction is cancelled
     */
    public function isCancelled()
    {
        return $this->isRejected(); // Rejected = Cancelled
    }

    /**
     * Calculate total weight in kg (3 items = 1 kg, rounded up)
     */
    public function getTotalBeratAttribute()
    {
        $totalItems = $this->transaksiItems->sum('qty');
        return ceil($totalItems / 3);
    }

    /**
     * Get grand total (should match pemasukan field)
     */
    public function getGrandTotalAttribute()
    {
        return $this->pemasukan;
    }

    /**
     * Get formatted grand total
     */
    public function getFormattedGrandTotalAttribute()
    {
        return 'Rp ' . number_format($this->grand_total, 0, ',', '.');
    }

    /**
     * Get waktu transaksi (alias for created_at)
     */
    public function getWaktuTransaksiAttribute()
    {
        return $this->created_at;
    }

    /**
     * Get formatted pemasukan
     */
    public function getFormattedPemasukanAttribute()
    {
        return 'Rp ' . number_format($this->pemasukan, 0, ',', '.');
    }

    /**
     * Scope: Get only pending transactions
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope: Get only completed/validated transactions
     */
    public function scopeCompleted($query)
    {
        return $query->whereIn('status', ['validated']);
    }

    /**
     * Scope: Get transactions by kasir
     */
    public function scopeByKasir($query, $kasirId)
    {
        return $query->where('id_kasir', $kasirId);
    }

    /**
     * Scope: Get transactions by date range
     */
    public function scopeDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('created_at', [$startDate, $endDate]);
    }

    /**
     * Scope: Get transactions by wilayah
     */
    public function scopeByWilayah($query, $wilayah)
    {
        return $query->where('wilayah', $wilayah);
    }

    /**
     * Scope: Get transactions by payment method
     */
    public function scopeByPaymentMethod($query, $method)
    {
        return $query->where('metode_pembayaran', $method);
    }
}
