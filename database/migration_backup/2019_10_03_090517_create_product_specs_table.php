<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductSpecsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
     {
       Schema::create('product_spec', function (Blueprint $table) {
         $table->bigIncrements('id');
         $table->bigInteger('spec_id')->nullable();
         $table->bigInteger('series_id')->nullable();
         $table->string('name')->nullable();
         $table->string('catalog')->nullable();
         $table->integer('download_access')->nullable();
         $table->text('description')->nullable();
         $table->string('image')->nullable();
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
        Schema::dropIfExists('product_spec');
    }
}
