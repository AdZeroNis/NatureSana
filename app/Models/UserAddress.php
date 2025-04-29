<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    protected $table = 'user_address';

    protected $fillable = [
        'user_id',
        'address_one',
        'address_two',
        'address_three',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
