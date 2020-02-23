<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\setting;
use App\contact_email;
use App\product;
use App\product_type as type;
use App\product_brand as brand;
use App\product_series as series;
use App\product_spec as spec;

class dashboard_c extends Controller
{
  function dashboard(){
    $count = collect([]);
    $count['brand'] = brand::count();
    $count['product'] = product::count();
    $count['product_series'] = series::count();
    $count['product_type'] = spec::count();
    $count['user'] = user::count();
    $count['email_contact'] = contact_email::count();
    return view('admin.dashboard', compact('count'));
  }
}
