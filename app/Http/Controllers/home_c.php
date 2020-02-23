<?php

namespace App\Http\Controllers;
use Mail;

use Illuminate\Http\Request;
use App\product;
use App\product_type as type;
use App\product_brand as brand;
use App\product_series as series;
use App\product_spec as spec;
use App\setting;
use App\news;
use App\promo;
use App\banner;

class home_c extends Controller
{
  function privacy(){
    return view('privacy');
  }
  function terms(){
    return view('terms');
  }
  function home(){
    $product = product::orderBy('updated_at', 'DESC')->paginate(12);
    $brand = brand::orderBy('updated_at', 'DESC')->paginate(12);
    $type = type::orderBy('updated_at', 'DESC')->paginate(12);
    $news = news::orderBy('updated_at', 'DESC')->take(5)->get();
    $promo = promo::orderBy('updated_at', 'DESC')->take(4)->get();
    $banner = banner::where('status', 1)->orderBy('created_at', 'DESC')->take(5)->get();
    return view('home', compact('product', 'brand', 'type', 'news', 'promo', 'banner'));
  }
  function about(){
    $setting = setting::first();
    return view('about', compact('setting'));
  }
  function contact(){
    $setting = setting::first();
    return view('contact', compact('setting'));
  }
  function contact_submit(Request $data){
    $setting = setting::first();
    $content = $data->message;
    $from = $data->email;
    $to = strtolower(env('MAIL_USERNAME'));
    $sender = ucwords($data->name);
    $subject = ucwords($data->subject);
    return Mail::raw($content, function($message) use ($to, $subject, $from, $sender){
      $message->to($to)->subject($subject);
      $message->from($from, $sender);
    });
  }
}
