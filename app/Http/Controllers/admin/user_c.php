<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class user_c extends Controller
{
  function profile(){
    $admin = auth::guard('admin')->user();
    return view('admin.user_profile', compact('admin'));
  }
}
