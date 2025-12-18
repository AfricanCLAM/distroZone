<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemTransaksi extends Model
{
    use HasFactory;

    // Table name
    protected $table = 'item_transaksi';

    // Primary key
    protected $primaryKey = 'id';

    // No timestamps
    public $timestamps = false;

    // Mass-assignable fields
    protected $fillable = [
        'id_transaksi',
        'id_kaos',
        'jumlah',
    ];

    // Cast attributes
    protected $casts = [
        'id_transaksi' => 'integer',
        'id_kaos' => 'integer',
        'jumlah' => 'integer',
    ];

    // --- RELATIONSHIPS ---

    /**
     * Item belongs to a transaction
     */
    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'id_transaksi', 'id');
    }

    /**
     * Item belongs to a kaos
     */
    public function kaos()
    {
        return $this->belongsTo(Kaos::class, 'id_kaos', 'id_kaos');
    }

    // --- HELPER METHODS ---

    /**
     * Calculate subtotal for this item
     */
    public function getSubtotalAttribute()
    {
        return $this->kaos->harga_jual * $this->jumlah;
    }

    /**
     * Get formatted subtotal
     */
    public function getFormattedSubtotalAttribute()
    {
        return 'Rp ' . number_format($this->subtotal, 0, ',', '.');
    }
}
