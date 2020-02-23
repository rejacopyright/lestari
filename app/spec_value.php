<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class spec_value extends Model
{
  protected $table = "spec_value";
  protected $guarded = [];
  // RELATIONSHIP
  function spec(){
    return $this->belongsTo('App\product_spec', 'spec_id', 'spec_id');
  }
}
