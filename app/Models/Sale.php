<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = ['customer_id', 'tanggal', 'total'];

       public function details()
    {
        return $this->hasMany(SaleDetail::class);
    }

    // (Opsional) relasi ke customer
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }


    public function items()
    {
        return $this->hasMany(SaleItem::class);
    }
    public function service()
{
    return $this->belongsTo(Service::class);
}

}
