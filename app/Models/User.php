<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Table name (Laravel assumes 'users' by default, so this is optional)
    protected $table = 'users';

    // Primary key
    protected $primaryKey = 'id';

    // This table does NOT have created_at/updated_at columns
    public $timestamps = false;

    // Mass-assignable fields
    protected $fillable = [
        'nama',
        'alamat',
        'password',
        'no_telp',
        'NIK',
        'foto',
        'role',
        'kID',
        'shift_start',
        'shift_end',
    ];

    // Hidden fields (not included in JSON/array output)
    protected $hidden = [
        'password',
    ];

    // Cast attributes to specific types
    protected $casts = [
        'shift_start' => 'datetime:H:i:s',
        'shift_end' => 'datetime:H:i:s',
    ];

    // --- RELATIONSHIPS ---

    /**
     * A user (kasir) can have many transactions
     */
    public function transaksis()
    {
        return $this->hasMany(Transaksi::class, 'id_kasir', 'id');
    }

    /**
     * A user (kasir/karyawan) can have many laporan entries
     */
    public function laporans()
    {
        return $this->hasMany(Laporan::class, 'id_karyawan', 'id');
    }

    // --- HELPER METHODS ---

    /**
     * Check if user is admin
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is kasir online
     */
    public function isKasirOnline()
    {
        return $this->role === 'kasir online';
    }

    /**
     * Check if user is kasir offline
     */
    public function isKasirOffline()
    {
        return $this->role === 'kasir offline';
    }

    /**
     * Get the name of the unique identifier for the user.
     *
     * @return string
     */
    public function getAuthIdentifierName()
    {
        return 'NIK'; // Use NIK instead of default 'id'
    }

    /**
     * Get the username used for authentication
     */
    public function username()
    {
        return 'NIK';
    }
}
