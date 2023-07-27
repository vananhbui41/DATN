<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('table_id');
            $table->string('table_name');
            $table->integer('user_id');
            $table->string('user_name');
            $table->integer('total_price')->default(0);
            $table->integer('total_recieved')->default(0);
            $table->integer('change')->default(0);
            $table->string('payment_type')->default(""); // cash or transfer
            $table->string('sale_status')->default("unpaid"); // paid and unpaid
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
        Schema::dropIfExists('sales');
    }
}
