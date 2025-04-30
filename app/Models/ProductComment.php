<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductComment extends Model
{
    protected $table = 'product_comments';
    protected $fillable = ['content', 'user_id', 'product_id', 'parent_id'];

    protected $with = ['user', 'replies'];
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function replies()
    {
        return $this->hasMany(ProductComment::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(ProductComment::class, 'parent_id');
    }
}
