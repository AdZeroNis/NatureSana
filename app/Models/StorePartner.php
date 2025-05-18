<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StorePartner extends Model
{
    protected $table = 'store_partners';

    protected $fillable = [
        'store_id',
        'partner_store_id',
        'status',
        'store_approval',
        'partner_approval'
    ];

    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id');
    }

    public function partnerStore()
    {
        return $this->belongsTo(Store::class, 'partner_store_id');
    }

    public function selectedProducts()
    {
        return $this->belongsToMany(Product::class, 'partner_selected_products', 'store_partner_id', 'product_id');
    }
public function sharedProducts()
{
    return $this->belongsToMany(Product::class, 'partner_products', 'store_partner_id', 'product_id')
        ->withTimestamps();
}

}
