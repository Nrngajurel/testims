<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class PurchaseStockSale extends Model
{
    use HasFactory;

    protected $table = 'purchase_stock_sale';


    public function sale(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Sale::class);
    }

    public function purchase(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Purchase::class);
    }
}
