<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
     {
       Schema::create('product', function (Blueprint $table) {
         $table->bigIncrements('id');
         $table->bigInteger('product_id')->nullable();
         $table->integer('brand_id')->nullable();
         $table->integer('category_id')->nullable();
         $table->integer('type_id')->nullable();
         $table->string('ms_id')->nullable();
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
        Schema::dropIfExists('product');
    }
}
