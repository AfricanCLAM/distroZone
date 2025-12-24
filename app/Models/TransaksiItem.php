<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiItem extends Model
{
    use HasFactory;

    // Table name (matching actual database schema)
    protected $table = 'transaksi_items';

    // Primary key
    protected $primaryKey = 'id';

    // No timestamps
    public $timestamps = false;

    // Mass-assignable fields (matching actual database columns)
    protected $fillable = [
        'transaksi_id',
        'id_kaos',
        'qty',
        'harga',
        'subtotal',
    ];

    // Cast attributes
    protected $casts = [
        'transaksi_id' => 'integer',
        'id_kaos' => 'integer',
        'qty' => 'integer',
        'harga' => 'integer',
        'subtotal' => 'integer',
    ];

    // --- RELATIONSHIPS ---

    /**
     * Item belongs to a transaction
     */
    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'transaksi_id', 'id');
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
     * Calculate subtotal (if not stored in database)
     * This provides a fallback calculation
     */
    public function calculateSubtotal()
    {
        return $this->harga * $this->qty;
    }

    /**
     * Get formatted subtotal
     */
    public function getFormattedSubtotalAttribute()
    {
        return 'Rp ' . number_format($this->subtotal, 0, ',', '.');
    }

    /**
     * Get formatted harga
     */
    public function getFormattedHargaAttribute()
    {
        return 'Rp ' . number_format($this->harga, 0, ',', '.');
    }

    /**
     * Alias for qty (for backward compatibility)
     */
    public function getJumlahAttribute()
    {
        return $this->qty;
    }
}
