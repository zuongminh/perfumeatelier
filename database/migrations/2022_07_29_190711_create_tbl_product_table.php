<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product', function (Blueprint $table) {
            $table->Increments('idProduct');
            $table->integer('idCategory');
            $table->integer('idBrand');
            $table->integer('QuantityTotal');
            $table->string('ProductName');
            $table->string('ProductSlug');
            $table->longText('DesProduct');
            $table->text('ShortDes');
            $table->string('Price');
            $table->integer('Sold');
            $table->tinyInteger('StatusPro');
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
        Schema::dropIfExists('product');
    }
}
