<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'status','store_id'];
    public function store()
    {
        return $this->belongsTo(Store::class);
    }
    public function products()
    {
        return $this->hasMany(Product::class, 'Id_category', 'id');
    }
}
