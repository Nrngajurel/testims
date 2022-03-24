<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_stock_sale', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('purchase_stock_id');
            $table->unsignedBigInteger('sale_id');
            $table->foreign('purchase_stock_id')->references('id')->on('purchase_stock')->onDelete('cascade');
            $table->foreign('sale_id')->references('id')->on('sales')->onDelete('cascade');
            $table->integer('quantity');
            $table->integer('price');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchase_stock_sale');
    }
};
