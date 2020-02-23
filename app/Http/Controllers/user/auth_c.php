<?php

namespace App\Http\Controllers\user;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Closure;
use Session;
use Auth;
use App\User;
use Hash;

class auth_c extends Controller
{
  public function login(Request $data) {
    $credential = ['username' => $data->username, 'password' => $data->password];
    Auth::guard('web')->attempt($credential, $data->remember);
    return back();
  }
  public function logout(Request $data) {
    Auth::guard('web')->logout();
    return back();
  }
  function register(Request $data){
    $user_id = user::max('user_id')+1;
    $user = new user;
    $user->user_id = $user_id;
    $user->email = $data->email;
    $user->username = $data->username;
    $user->password = hash::make($data->password);
    $user->save();
    $credential = ['username' => $user->username, 'password' => $data->password];
    auth::guard('web')->attempt($credential);
    return back();
  }
}
