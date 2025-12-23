<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi';
    protected $primaryKey = 'id';

    // Enable timestamps for created_at and validated_at
    public $timestamps = true;
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'validated_at'; // Use validated_at as updated_at

    protected $fillable = [
        'no_transaksi',
        'id_kasir',
        'nama_pembeli',
        'alamat',
        'no_telp_pembeli',
        'wilayah',
        'status',
        'metode_pembayaran',
        'total_harga',
        'ongkir',
        'pemasukan',
        'struk',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'validated_at' => 'datetime',
        'total_harga' => 'float',
        'ongkir' => 'float',
        'pemasukan' => 'float',
    ];

    // Relationships
    public function kasir()
    {
        return $this->belongsTo(User::class, 'id_kasir', 'id');
    }

    public function items()
    {
        return $this->hasMany(TransaksiItem::class, 'transaksi_id', 'id');
    }

    // Status helpers
    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isValidated()
    {
        return $this->status === 'validated';
    }

    public function isCompleted()
    {
        return $this->status === 'completed';
    }

    public function isRejected()
    {
        return $this->status === 'rejected';
    }

    // Calculate totals (these should be called before saving)
    public function calculateTotals()
    {
        // Calculate subtotal from items
        $this->total_harga = $this->items->sum(function ($item) {
            return $item->qty * $item->kaos->harga_jual;
        });

        // Calculate shipping
        $this->ongkir = $this->calculateShipping();

        // Grand total
        $this->pemasukan = $this->total_harga + $this->ongkir;
    }

    private function calculateShipping()
    {
        $totalItems = $this->items->sum('qty');
        $totalWeight = ceil($totalItems / 3); // 3 items = 1 kg

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

        $alamat = strtolower($this->alamat);

        foreach ($rates as $region => $rate) {
            if (strpos($alamat, $region) !== false) {
                return $rate * $totalWeight;
            }
        }

        // Default to Jawa Barat if no match
        return $rates['jawa barat'] * $totalWeight;
    }

    // Formatted attributes
    public function getFormattedTotalHargaAttribute()
    {
        return 'Rp ' . number_format($this->total_harga, 0, ',', '.');
    }

    public function getFormattedOngkirAttribute()
    {
        return 'Rp ' . number_format($this->ongkir, 0, ',', '.');
    }

    public function getFormattedGrandTotalAttribute()
    {
        return 'Rp ' . number_format($this->pemasukan, 0, ',', '.');
    }
}
