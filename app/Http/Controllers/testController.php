<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use App\setting;
use Analytics;
use Spatie\Analytics\Period;

use App\product;
use App\product_series as series;
use App\product_model as model;
use App\product_spec as spec;

class testController extends Controller
{
  function email(){
    $name = ['JAMES'];
    $email = ['reja.copyright@gmail.com'];
    $subject = 'Promo in this month';
    $setting = setting::first();
    // dd(env('MAIL_USERNAME'));
    Mail::send(["html"=> "mail.news"], compact('setting'), function($message) use ($name, $email, $subject){
      $message->to($email, $name)->subject($subject);
      $message->from(env('MAIL_USERNAME'), env('APP_NAME'));
    });
    return "Success";
    // return view('mail.test');
  }
  function incoming_mail(){
    $setting = setting::first();
    $element = [];
    $image = null;
    $content = 'Incoming Mail Tester';
    $from = 'reja.copyright@gmail.com';
    $to = 'info@lestariautomation.com';
    $sender = 'Reja Jamil';
    $subject = 'Incoming Mail Tester';
    // return Mail::send(["html"=> 'mail.mail'], compact('setting', 'element', 'image', 'content'), function($message) use ($to, $subject, $from, $sender){
    //   $message->to($to)->subject($subject);
    //   $message->from($from, $sender);
    // });
    return "Success";
    // return view('mail.test');
  }
  function email_view(){
    $setting = setting::first();
    return view('mail.news', compact('setting'));
  }
  function analytics(){
    $visitor = Analytics::performQuery(Period::months(1), 'ga:pageviews', ['metrics' => 'ga:sessions, ga:pageviews',]);
    dd($visitor);
  }
  function kueri(){
    $product_id = product::where('brand_id', 2)->select('product_id')->pluck('product_id')->all();
    $series = series::whereIn('product_id', $product_id);
    // $model_id = model::max('model_id')+1;
    // foreach ($series->get() as $sr) {
    //   $m_id = $model_id++;
    //   model::create([
    //     'model_id' => $m_id,
    //     'series_id' => $sr->series_id,
    //     'name' => 'Model 2',
    //     'description' => 'Description of Model 2',
    //     'created_at' => now(),
    //     'updated_at' => now(),
    //   ]);
    // }
    $series_id = model::select('series_id')->pluck('series_id')->all();
    $spec = spec::whereIn('series_id', $series_id);
    foreach (model::orderByDesc('id')->get()->unique('series_id') as $mdl) {
      $take = (int)floor(spec::where('series_id', $mdl->series_id)->count() / 2);
      if ($take) {
        // spec::where('series_id', $mdl->series_id)->whereNull('model_id')->update(['model_id' => $mdl->model_id]);
        // spec::where('series_id', $mdl->series_id)->take($take)->update(['model_id' => $mdl->model_id]);
      }
    }
    dd("OK");
  }
}
