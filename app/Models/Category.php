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
        return $this->hasMany(Product::class, 'category_id', 'id');
    }
    protected static function booted(): void
    {
        static::deleting(function (Category $category) {
            if (!$category->isDeletable()) {
                abort(403, 'این دسته‌بندی قابل حذف نیست');
            }
        });
    }

    public function isDeletable()
    {
        return !$this->products()->exists(); 
    }
}
