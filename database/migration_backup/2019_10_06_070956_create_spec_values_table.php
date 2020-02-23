<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpecValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spec_value', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('spec_id')->nullable();
            $table->bigInteger('product_id')->nullable();
            $table->integer('ms_id')->nullable();
            $table->string('ms_value')->nullable();
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
        Schema::dropIfExists('spec_value');
    }
}
