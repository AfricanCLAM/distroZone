<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    use HasFactory;

    // Table name
    protected $table = 'shifts';

    // Primary key
    protected $primaryKey = 'id';

    // No timestamps
    public $timestamps = false;

    // Mass-assignable fields
    protected $fillable = [
        'tipe',
        'jam_buka',
        'jam_tutup',
    ];

    // Cast time fields
    protected $casts = [
        'jam_buka' => 'datetime:H:i:s',
        'jam_tutup' => 'datetime:H:i:s',
    ];

    // --- HELPER METHODS ---

    /**
     * Check if current time is within shift hours
     */
    public function isActive()
    {
        $now = now()->format('H:i:s');
        return $now >= $this->jam_buka && $now <= $this->jam_tutup;
    }

    /**
     * Get formatted shift time
     */
    public function getShiftTimeAttribute()
    {
        return $this->jam_buka . ' - ' . $this->jam_tutup;
    }
}
