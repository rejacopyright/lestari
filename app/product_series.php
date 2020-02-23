<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class product_series extends Model
{
  protected $table = "product_series";
  protected $guarded = [];
  // RELATIONSHIP
  function product(){
    return $this->belongsTo('App\product', 'product_id', 'product_id');
  }
}
