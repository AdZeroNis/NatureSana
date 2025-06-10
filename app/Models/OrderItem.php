<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{

    protected $fillable = [
    'order_id',
    'product_id',
    'quantity',
    'seller_store_id',
    'owner_store_id',
    'seller_share',
    'owner_share'
];


    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    // در مدل OrderItem
public function sellerStore()
{
    return $this->belongsTo(Store::class, 'seller_store_id');
}

public function ownerStore()
{
    return $this->belongsTo(Store::class, 'owner_store_id');
}


}
