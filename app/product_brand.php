<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class product_brand extends Model
{
  protected $table = "product_brand";
  protected $guarded = [];
  // RELATIONSHIP
  function product(){
    return $this->hasMany('App\product', 'brand_id', 'brand_id');
  }
}
