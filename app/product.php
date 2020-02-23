<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class product extends Model
{
  protected $table = "product";
  protected $guarded = [];

  // RELATIONSHIP
  function brand(){
    return $this->belongsTo('App\product_brand', 'brand_id', 'brand_id');
  }
  function type(){
    return $this->belongsTo('App\product_type', 'type_id', 'type_id');
  }
  function series(){
    return $this->hasMany('App\product_series', 'product_id', 'product_id');
  }
}
