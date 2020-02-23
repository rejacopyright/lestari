<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class product_spec extends Model
{
  protected $table = "product_spec";
  protected $guarded = [];
  // RELATIONSHIP
  function series(){
    return $this->belongsTo('App\product_series', 'series_id', 'series_id');
  }
  function value(){
    return $this->hasMany('App\spec_value', 'spec_id', 'spec_id');
  }
}
