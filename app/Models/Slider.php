<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    protected $fillable = ['url','image', 'status','admin_id'];

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
