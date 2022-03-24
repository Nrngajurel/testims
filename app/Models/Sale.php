<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sale extends Model
{
    use HasFactory;

    public function customer(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function purchase_stock_sales()
    {
        return $this->hasMany(PurchaseStockSale::class);
    }
}
