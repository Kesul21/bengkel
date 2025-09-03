<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Sale;
use App\Models\SaleDetail;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'motor',
        'tanggal',
        'biaya_jasa',
        'total_sparepart',
        'total_bayar',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function details()
    {
        return $this->hasMany(ServiceDetail::class);
    }
    public function sale()
{
    return $this->hasOne(Sale::class);
}

    public function generateSale(): void
{
    $sale = Sale::create([
        'customer_id' => $this->customer_id,
        'tanggal' => $this->tanggal,
        'total' => $this->total_sparepart,
        'service_id' => $this->id, // jika kamu pakai foreign key ke service
    ]);

    foreach ($this->details as $detail) {
        $sale->details()->create([
            'product_id' => $detail->product_id,
            'qty' => $detail->qty,
            'harga_satuan' => $detail->harga_satuan,
            'subtotal' => $detail->subtotal,
        ]);
    }
}
}
