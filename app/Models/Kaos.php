<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kaos extends Model
{
    use HasFactory;

    // Table name
    protected $table = 'kaos';

    // Primary key
    protected $primaryKey = 'id_kaos';

    // No timestamps in this table
    public $timestamps = false;

    // Mass-assignable fields
    protected $fillable = [
        'merek',
        'tipe',
        'warna_kaos',
        'harga_jual',
        'harga_pokok',
        'stok_kaos',
        'foto_kaos',
        'ukuran',
        'tID',
    ];

    // Cast attributes
    protected $casts = [
        'harga_jual' => 'integer',
        'harga_pokok' => 'integer',
        'stok_kaos' => 'integer',
    ];

    // --- RELATIONSHIPS ---

    /**
     * A kaos can appear in many transactions
     */
    public function transaksis()
    {
        return $this->hasMany(Transaksi::class, 'id_kaos', 'id_kaos');
    }

    // --- HELPER METHODS ---

    /**
     * Check if kaos has sufficient stock
     */
    public function hasStock($quantity = 1)
    {
        return $this->stok_kaos >= $quantity;
    }

    /**
     * Decrease stock (use in transactions)
     */
    public function decrementStock($quantity = 1)
    {
        if ($this->hasStock($quantity)) {
            $this->stok_kaos -= $quantity;
            return $this->save();
        }
        return false;
    }

    /**
     * Increase stock (use for returns/restocking)
     */
    public function incrementStock($quantity = 1)
    {
        $this->stok_kaos += $quantity;
        return $this->save();
    }

    /**
     * Get formatted price for display
     */
    public function getFormattedHargaJualAttribute()
    {
        return 'Rp ' . number_format($this->harga_jual, 0, ',', '.');
    }

    /**
     * Check if out of stock
     */
    public function isOutOfStock()
    {
        return $this->stok_kaos <= 0;
    }
}
