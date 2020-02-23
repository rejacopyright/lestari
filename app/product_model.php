<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class product_model extends Model
{
  protected $table = "product_model";
  protected $guarded = [];
  // PARENT
  function series(){
    return $this->belongsTo('App\product_series', 'series_id', 'series_id');
  }
  // CHILD
  function spec(){
    return $this->hasMany('App\product_spec', 'model_id', 'model_id');
  }
}
