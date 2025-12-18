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

    // No timestamps
    public $timestamps = false;

    // Mass-assignable fields
    protected $fillable = [
        'id_kasir',
        'nama_pembeli',
        'alamat_pembeli',
        'no_pembeli',
        'status',
        'waktu_transaksi',
    ];

    // Cast attributes
    protected $casts = [
        'id_kasir' => 'integer',
        'waktu_transaksi' => 'datetime',
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
     * Transaction has many items
     */
    public function items()
    {
        return $this->hasMany(ItemTransaksi::class, 'id_transaksi', 'id');
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
     * Check if transaction is completed
     */
    public function isCompleted()
    {
        return $this->status === 'completed';
    }

    /**
     * Check if transaction is cancelled
     */
    public function isCancelled()
    {
        return $this->status === 'cancelled';
    }

    /**
     * Calculate total price of all items
     */
    public function getTotalHargaAttribute()
    {
        return $this->items->sum(function ($item) {
            return $item->kaos->harga_jual * $item->jumlah;
        });
    }

    /**
     * Calculate shipping cost based on region
     */
    public function getOngkirAttribute()
    {
        // Extract region from address
        $alamat = strtolower($this->alamat_pembeli);

        // Total items for weight calculation
        $totalItems = $this->items->sum('jumlah');
        $totalWeight = ceil($totalItems / 3); // 3 items = 1 kg, round up

        // Shipping rates per kg
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

        // Find matching region
        foreach ($rates as $region => $rate) {
            if (strpos($alamat, $region) !== false) {
                return $rate * $totalWeight;
            }
        }

        // Default to Jawa Barat if no match
        return $rates['jawa barat'] * $totalWeight;
    }

    /**
     * Calculate grand total (items + shipping)
     */
    public function getGrandTotalAttribute()
    {
        return $this->total_harga + $this->ongkir;
    }

    /**
     * Get formatted grand total
     */
    public function getFormattedGrandTotalAttribute()
    {
        return 'Rp ' . number_format($this->grand_total, 0, ',', '.');
    }

    /**
     * Get total weight in kg
     */
    public function getTotalBeratAttribute()
    {
        $totalItems = $this->items->sum('jumlah');
        return ceil($totalItems / 3);
    }
}
