<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Purchase extends Model
{
    use HasFactory;

    public function stocks(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Stock::class, 'purchase_stock', 'purchase_id', 'stock_id')->withPivot('quantity', 'price');
    }
}
