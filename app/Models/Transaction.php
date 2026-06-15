<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $guarded = [];

    public function variety()
    {
        return $this->belongsTo(Variety::class)->withTrashed();
    }

    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }
}
