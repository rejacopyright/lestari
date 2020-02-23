<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Closure;
use Session;
use Auth;
use App\admin;
use Hash;

class auth_c extends Controller
{
  protected $redirectTo = 'admin';
  public function __construct() {
    if (auth::guard('admin')->check()) {
      $this->middleware('auth:admin')->except('logout');
    }else {
      return redirect('admin');
    }
  }
  function index(){
    if (auth::guard('admin')->check()) {
      // return "<script> window.history.back(); </script>";
      return redirect('admin/dashboard');
    }else {
      return view('auth.admin');
    }
  }
  public function login(Request $data) {
    $credential = ['username' => $data->username, 'password' => $data->password];
    Auth::guard('admin')->attempt($credential, $data->remember);
    return redirect()->intended('admin');
  }
  public function logout(Request $data) {
    Auth::guard('admin')->logout();
    return redirect('admin');
  }
  function register(Request $data){
    $admin_id = admin::max('admin_id')+1;
    $admin = new admin;
    $admin->admin_id = $admin_id;
    $admin->nama = $data->nama;
    $admin->email = $data->email;
    $admin->username = $data->username;
    $admin->password = hash::make($data->password);
    $admin->tgl = now();
    $admin->status = 1;
    $admin->save();
    $credential = ['username' => $admin->username, 'password' => $data->password];
    auth::guard('admin')->attempt($credential);
    return redirect('admin');
  }
}
