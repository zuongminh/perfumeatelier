<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bill', function (Blueprint $table) {
            $table->increments('idBill');
            $table->integer('idCustomer');
            $table->string('Voucher');
            $table->string('Address');
            $table->string('PhoneNumber',20);
            $table->string('CustomerName',50);
            $table->dateTime('ReceiveDate');
            $table->tinyInteger('Status');
            $table->string('TotalBill');
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
        Schema::dropIfExists('bill');
    }
}
