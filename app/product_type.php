<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class product_type extends Model
{
  protected $table = "product_type";
  protected $guarded = [];
  // RELATIONSHIP
  function product(){
    return $this->hasMany('App\product', 'type_id', 'type_id');
  }
}
