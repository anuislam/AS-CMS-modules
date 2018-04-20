<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ShippingClass extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipping_class', function (Blueprint $table) {
            $table->bigIncrements('id');    
            $table->bigInteger('zone_id');
            $table->bigInteger('method_id');
            $table->string('class_name', 255);
            $table->string('class_slug', 255);
            $table->bigInteger('class_desc')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shipping_class');
    }
}
