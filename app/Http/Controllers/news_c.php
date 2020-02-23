<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\news;
use App\promo;
use App\setting;

class news_c extends Controller
{
  function news(Request $data){
    $q = $data->q;
    if ($q) {
      $news = news::where('title', 'like', '%'.$q.'%')->orderBy('created_at', 'DESC')->paginate(5);
    }else {
      $news = news::orderBy('created_at', 'DESC')->paginate(5);
    }
    $promo = promo::orderBy('created_at', 'DESC')->take(3)->get();
    $setting = setting::first();
    return view('news', compact('news', 'q', 'promo', 'setting'));
  }
  function news_detail($news_id){
    $news = news::where('news_id', $news_id)->first();
    $all_news = news::orderBy('created_at', 'DESC')->paginate(5);
    return view('news_detail', compact('news', 'all_news'));
  }
}
