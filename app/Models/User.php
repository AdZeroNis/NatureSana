<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = ['name', 'email', 'password', 'phone', 'role', 'status','store_id','is_verified','email_verified_at'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id');
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function hasVerifiedEmail()
    {
        return !is_null($this->email_verified_at);
    }



    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function sliders()
    {
        return $this->hasMany(Slider::class);
    }
    public function address()
    {
        return $this->hasOne(UserAddress::class);
    }
    public function Productcomments()
    {
        return $this->hasMany(ProductComment::class);
    }
    public function Articlecomments()
    {
        return $this->hasMany(ArticleComment::class);
    }
}
