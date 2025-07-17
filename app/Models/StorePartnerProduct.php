<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StorePartnerProduct extends Model
{

    protected $table = 'partner_products';
    protected $fillable = [
     'store_partner_id',
     'product_id',

    ];
    public function product()
    {
        return $this->belongsTo(Product::class);
    }




public function storePartner()
{
    return $this->belongsTo(StorePartner::class, 'store_partner_id');
}

}
