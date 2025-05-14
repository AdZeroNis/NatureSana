<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    protected $fillable = ['name', 'address', 'image', 'phone_number', 'admin_id', 'status', 'is_approved'];

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function categories()
    {
        return $this->hasMany(Category::class);
    }
    public function products()
    {
        return $this->hasMany(Product::class);
    }
    public function partners()
    {
        return $this->belongsToMany(Store::class, 'store_partners', 'store_id', 'partner_store_id')
            ->wherePivot('status', true);
    }
    public function partnerOf()
    {
        return $this->belongsToMany(Store::class, 'store_partners', 'partner_store_id', 'store_id')
            ->wherePivot('status', 1)
            ->where('stores.status', 1); // 👈 مشخص کردن جدول
    }
    
}
