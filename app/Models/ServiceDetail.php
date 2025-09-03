<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ServiceDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_id',
        'product_id',
        'qty',
        'harga_satuan',
        'subtotal',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
     public function sale()
    {
        return $this->belongsTo(Sale::class);
    }
}
