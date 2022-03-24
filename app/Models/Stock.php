<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Stock extends Model
{
    use HasFactory;

    public function purchases(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Purchase::class)->withPivot('quantity', 'price');
    }
}
