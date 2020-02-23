<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\promo;
use App\setting;

class promo_c extends Controller
{
  function promo(Request $data){
    $q = $data->q;
    $page = $data->page;
    if ($q) {
      $promo = promo::where('title', 'like', '%'.$q.'%')->orderBy('created_at', 'DESC')->paginate(6);
    }else {
      $promo = promo::orderBy('created_at', 'DESC')->paginate(6);
    }
    // dd($promo);
    $setting = setting::first();
    return view('promo', compact('promo', 'q', 'page', 'setting'));
  }
  function promo_detail($promo_id){
    $promo = promo::where('promo_id', $promo_id)->first();
    $all_promo = promo::orderBy('created_at', 'DESC')->paginate(5);
    return view('promo_detail', compact('promo', 'all_promo'));
  }
}
