<?php

// app/Models/Vehicle.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = ['customer_id', 'no_polisi', 'merk', 'tipe', 'tahun'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
