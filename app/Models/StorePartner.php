<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StorePartner extends Model
{
    protected $fillable = ['store_id', 'partner_store_id', 'status'];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function partnerStore()
    {
        return $this->belongsTo(Store::class, 'partner_store_id');
    }
}
