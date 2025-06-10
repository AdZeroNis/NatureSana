<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'description', 'inventory', 'price', 'status', 'category_id', 'image', 'store_id'];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function ProductComments()
    {
        return $this->hasMany(ProductComment::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
// در مدل Product
public function sharedPartnerships()
{
    return $this->belongsToMany(StorePartner::class, 'partner_products', 'product_id', 'store_partner_id')
                ->withPivot('id')
                ->withTimestamps();
}

}
