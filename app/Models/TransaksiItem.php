<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiItem extends Model
{
    use HasFactory;

    protected $table = 'transaksi_items';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'transaksi_id',
        'id_kaos',
        'qty',
    ];

    protected $casts = [
        'transaksi_id' => 'integer',
        'id_kaos' => 'integer',
        'qty' => 'integer',
    ];

    // Relationships
    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'transaksi_id', 'id');
    }

    public function kaos()
    {
        return $this->belongsTo(Kaos::class, 'id_kaos', 'id_kaos');
    }

    // Calculate subtotal
    public function getSubtotalAttribute()
    {
        return $this->kaos->harga_jual * $this->qty;
    }

    public function getFormattedSubtotalAttribute()
    {
        return 'Rp ' . number_format($this->subtotal, 0, ',', '.');
    }
}
