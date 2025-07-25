<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = ['user_id', 'product_id', 'quantity', 'partner_product_id','partner_store_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

public function partnerProduct()
{
    return $this->belongsTo(StorePartnerProduct::class, 'partner_product_id');
}

public function partnerStore()
{
    return $this->belongsTo(Store::class, 'partner_store_id');
}

}
