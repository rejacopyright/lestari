<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class master_spec extends Model
{
  protected $table = "master_spec";
  protected $guarded = [];
  // RELATIONSHIP
  function value(){
    return $this->hasMany('App\spec_value', 'ms_id', 'ms_id');
  }
}
