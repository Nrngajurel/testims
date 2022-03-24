<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomePageController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    public function __invoke(Request $request)
    {
        $stock_id = $request->input('stock_id')??1;
        $purchase_qty = $request->input('purchase_qty')??1;

        $customer_id = \App\Models\Customer::all()->random()->id;

        $stock = \App\Models\Stock::select(['stocks.id','stocks.name',\DB::raw("SUM(purchase_stock.quantity) as quantity"),\DB::raw("SUM(purchase_stock.price) as price"), \DB::raw("SUM(purchase_stock.quantity * purchase_stock.price) as total")])
            ->leftJoin('purchase_stock','purchase_stock.stock_id','=','stocks.id')
            ->groupBy('stocks.id')
            ->findOrFail($stock_id);

        if ($stock->quantity < $purchase_qty) {
            return 'Not enough stock';
        }else{
            $purchase_stocks = \App\Models\PurchaseStock::where('quantity','>',0)->where('stock_id',$stock_id)->get();
            $sale = \App\Models\Sale::create([
                'name' => 'test ' . rand(1,10000),
                'customer_id'=> $customer_id,
            ]);
            foreach ($purchase_stocks as $purchase_stock) {
                if ($purchase_stock->quantity >= $purchase_qty) {
                    $purchase_stock->quantity -= $purchase_qty;
                    $purchase_stock->save();
                    \App\Models\PurchaseStockSale::create([
                        'sale_id' => $sale->id,
                        'purchase_stock_id' => $stock_id,
                        'quantity' => $purchase_qty,
                        'price' => $purchase_stock->price,
                    ]);
                    break;
                }else{
                    $purchase_qty -= $purchase_stock->quantity;
                    \App\Models\PurchaseStockSale::create([
                        'sale_id' => $sale->id,
                        'purchase_stock_id' => $stock_id,
                        'quantity' => $purchase_stock->quantity,
                        'price' => $purchase_stock->price,
                    ]);
                    $purchase_stock->quantity = 0;
                    $purchase_stock->save();
                }
            }
        }
        return 'success';
    }
}
