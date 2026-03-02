<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Variety extends Model
{
    protected $guarded = [];

    public function inventories()
    {
        return $this->hasMany(Inventory::class);
    }
}
