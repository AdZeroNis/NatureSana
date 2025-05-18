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
       public function sharedProducts()
{
    return $this->belongsToMany(Product::class, 'partner_products')
                ->withTimestamps();
}


}
