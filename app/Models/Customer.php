<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'telepon',
        'alamat',
    ];

    // Relasi ke kendaraan (vehicles)
    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }

    // Relasi ke penjualan
    public function sales()
    {
        return $this->hasMany(Sale::class);
    }
}

