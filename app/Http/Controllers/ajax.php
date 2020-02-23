<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Analytics;
use Spatie\Analytics\Period;
use Auth;
use App\product;
use App\product_type as type;
use App\product_brand as brand;
use App\product_series as series;
use App\product_model as model;
use App\product_spec as spec;
use App\master_spec as ms;
use App\spec_value as value;
use App\setting;
use App\news;
use App\promo;
use App\contact_email;
use App\banner;

class ajax extends Controller
{
  // -------------------------- ANALYTICS --------------------------
  function analytics(){
    $visitor = Analytics::fetchVisitorsAndPageViews(Period::months(1));
    $view = Analytics::performQuery(Period::months(1), 'ga:pageviews', ['metrics' => 'ga:sessions, ga:pageviews',]);
    $view = $view->rows;
    return compact('visitor', 'view');
  }
  // -------------------------- SEARCH --------------------------
  function search(Request $data){
    $q = $data->q;
    $limit = 5;
    $result = collect([]);
    $series = series::where('name', 'like', '%'.$q.'%')->take($limit)->get()->map(function($i){
      $i['img'] = url('public/images/series').'/'.$i->image ?? '../image.png';
      $i['link'] = url('product/spec').'?product_id='.$i->product_id.'&series_id='.$i->series_id;
      $i['series_name'] = ucwords($i->name);
      $i['product_name'] = ucwords($i->product->name);
      $i['brand_name'] = ucwords($i->product->brand->name);
      return $i->only('series_name', 'product_name', 'brand_name', 'link', 'img');
    });
    $product = product::where('name', 'like', '%'.$q.'%')->take($limit)->get()->map(function($i){
      $i['img'] = url('public/images/products').'/'.$i->image ?? '../image.png';
      $i['link'] = url('product/detail').'/'.$i->product_id;
      $i['product_name'] = ucwords($i->name);
      $i['brand_name'] = ucwords($i->brand->name);
      return $i->only('product_name', 'brand_name', 'link', 'img');
    });
    $brand = brand::where('name', 'like', '%'.$q.'%')->take($limit)->get()->map(function($i){
      $i['img'] = url('public/images/brand').'/'.$i->image ?? '../image.png';
      $i['link'] = url('product').'?brand_id='.$i->brand_id;
      $i['brand_name'] = ucwords($i->name);
      return $i->only('brand_name', 'link', 'img');
    });
    $result = $result->merge($series)->merge($product)->merge($brand);
    return $result->take($limit);
  }
  function search_admin(Request $data){
    $q = $data->q;
    $limit = 5;
    $result = collect([]);
    $series = series::where('name', 'like', '%'.$q.'%')->take($limit)->get()->map(function($i){
      $i['img'] = url('public/images/series').'/'.$i->image ?? '../image.png';
      $i['link'] = url('admin/product/series').'?q='.urlencode($i->name).'&product_id='.$i->product_id.'&type_id='.$i->product->type_id.'&brand_id='.$i->product->brand_id;
      $i['series_name'] = ucwords($i->name);
      $i['product_name'] = ucwords($i->product->name);
      $i['brand_name'] = ucwords($i->product->brand->name);
      return $i->only('series_name', 'product_name', 'brand_name', 'link', 'img');
    });
    $product = product::where('name', 'like', '%'.$q.'%')->take($limit)->get()->map(function($i){
      $i['img'] = url('public/images/products').'/'.$i->image ?? '../image.png';
      $i['link'] = url('admin/product').'?q='.urlencode($i->name).'&type_id='.$i->type_id.'&brand_id='.$i->brand_id;
      $i['product_name'] = ucwords($i->name);
      $i['brand_name'] = ucwords($i->brand->name);
      return $i->only('product_name', 'brand_name', 'link', 'img');
    });
    $brand = brand::where('name', 'like', '%'.$q.'%')->take($limit)->get()->map(function($i){
      $i['img'] = url('public/images/brand').'/'.$i->image ?? '../image.png';
      $i['link'] = url('admin/product/brand').'?q='.urlencode($i->name);
      $i['brand_name'] = ucwords($i->name);
      return $i->only('brand_name', 'link', 'img');
    });
    $result = $result->merge($series)->merge($product)->merge($brand);
    return $result->take($limit);
  }
  // -------------------------- ADMIN PROFILE --------------------------
  function old_password_admin(Request $data){
    $admin = auth::guard('admin')->user();
    if (Hash::check($data->password, $admin->password)) {
      return 'match';
    }else {
      return 'mismatch';
    }
  }
  function change_password_admin(Request $data){
    auth::guard('admin')->user()->update(['password' => Hash::make($data->password)]);
  }
  function change_profile_admin(Request $data){
    $admin = auth::guard('admin')->user();
    if ($data->nama) { $admin->nama = $data->nama; }
    if ($data->username) { $admin->username = strtolower($data->username); }
    if ($data->email) { $admin->email = strtolower($data->email); }
    if ($data->wa) { $admin->wa = $data->wa; }
    $admin->save();
  }
  // -------------------------- SELECT2 --------------------------
  function ms_select2(Request $data){
    $ms = ms::where('name', 'like', '%'.$data->q.'%')->paginate(10);
    $map = ($ms)->map(function($item){
      return ['id' => $item['ms_id'], 'text' => strtoupper($item['name'])];
    });
    if ($data->all) { $map = $map->prepend(['id' => 0, 'text' => 'All Spec', 'selected' => true]); }
    return $map;
  }
  function ms_detail(Request $data){
    $ms = ms::where('ms_id', $data->ms_id)->first();
    return $ms;
  }
  function spec_detail($spec_id){
    $spec = spec::where('spec_id', $spec_id)->first();
    $spec = collect($spec)->merge([
      'series' => $spec->series,
      'product' => $spec->series->product,
      'brand' => $spec->series->product->brand,
      'ms' => ms::whereIn('ms_id', explode('|', $spec->series->product->ms_id))->get(),
    ]);
    return $spec;
  }
  function spec_value($spec_id){
    $value = value::where('spec_id', $spec_id)->get();
    return $value;
  }
  function series_select2(Request $data){
    $series = series::where('name', 'like', '%'.$data->q.'%')->paginate(10);
    if ($data->product_id) {
      $series = series::where('name', 'like', '%'.$data->q.'%')->where('product_id', $data->product_id)->paginate(10);
    }
    $map = ($series)->map(function($item){
      return ['id' => $item['series_id'], 'text' => strtoupper($item['name'])];
    });
    if ($data->all) { $map = $map->prepend(['id' => 0, 'text' => 'All Series', 'selected' => true]); }
    return $map;
  }
  function series_haschild_select2(Request $data){
    $brand_id = brand::where('child', 1)->select('brand_id')->pluck('brand_id')->all();
    $product_id = product::whereIn('brand_id', $brand_id)->select('product_id')->pluck('product_id')->all();
    $series = series::whereIn('product_id', $product_id)->where('name', 'like', '%'.$data->q.'%')->paginate(10);
    if ($data->product_id) {
      $series = series::where('name', 'like', '%'.$data->q.'%')->where('product_id', $data->product_id)->paginate(10);
    }
    $map = ($series)->map(function($item){
      return ['id' => $item['series_id'], 'text' => strtoupper($item['name'])];
    });
    if ($data->all) { $map = $map->prepend(['id' => 0, 'text' => 'All Series', 'selected' => true]); }
    return $map;
  }
  function series_detail($series_id){
    $series = series::where('series_id', $series_id)->first();
    $series = collect($series)->merge([
      'product' => $series->product,
      'spec' => spec::where('series_id', $series_id)->get()
    ]);
    return $series;
  }
  function model_select2(Request $data){
    $model = model::where('name', 'like', '%'.$data->q.'%')->paginate(10);
    if ($data->series_id) {
      $model = model::where('name', 'like', '%'.$data->q.'%')->where('series_id', $data->series_id)->paginate(10);
    }
    $map = ($model)->map(function($item){
      return ['id' => $item['model_id'], 'text' => strtoupper($item['name'])];
    });
    if ($data->all) { $map = $map->prepend(['id' => 0, 'text' => 'All Models', 'selected' => true]); }
    return $map;
  }
  function model_detail($model_id){
    $model = model::where('model_id', $model_id)->first();
    $model = collect($model)->merge([
      'product' => $model->series->product,
      'series' => $model->series,
      'spec' => spec::where('model_id', $model_id)->get()
    ]);
    return $model;
  }
  function product_select2(Request $data){
    $product = product::where('name', 'like', '%'.$data->q.'%')->paginate(10);
    $map = ($product)->map(function($item){
      return ['id' => $item['product_id'], 'text' => strtoupper($item['name']).' ('.strtoupper($item->brand->name).')'];
    });
    if ($data->all) { $map = $map->prepend(['id' => 0, 'text' => 'All Product', 'selected' => true]); }
    return $map;
  }
  function product_haschild_select2(Request $data){
    $brand_id = brand::where('child', 1)->select('brand_id')->pluck('brand_id')->all();
    $product = product::whereIn('brand_id', $brand_id)->where('name', 'like', '%'.$data->q.'%')->paginate(10);
    $map = ($product)->map(function($item){
      return ['id' => $item['product_id'], 'text' => strtoupper($item['name']).' ('.strtoupper($item->brand->name).')'];
    });
    if ($data->all) { $map = $map->prepend(['id' => 0, 'text' => 'All Product', 'selected' => true]); }
    return $map;
  }
  function product_detail($product_id){
    $product = product::where('product_id', $product_id)->first();
    $product = collect($product)->merge([
      'ms' => ms::whereIn('ms_id', explode('|', $product->ms_id))->get(),
      'type' => $product->type,
      'brand' => $product->brand,
      'series' => series::where('product_id', $product->product_id)->get(),
      'spec' => spec::whereIn('series_id', series::where('product_id', $product->product_id)->pluck('series_id')->all())->get()
    ]);
    return $product;
  }
  function type_select2(Request $data){
    $type = type::where('name', 'like', '%'.$data->q.'%')->paginate(10);
    $map = ($type)->map(function($item){
      return ['id' => $item['type_id'], 'text' => strtoupper($item['name'])];
    });
    if ($data->all) { $map = $map->prepend(['id' => 0, 'text' => 'All Type', 'selected' => true]); }
    return $map;
  }
  function brand_select2(Request $data){
    $brand = brand::where('name', 'like', '%'.$data->q.'%')->paginate(10);
    $map = ($brand)->map(function($item){
      return ['id' => $item['brand_id'], 'text' => strtoupper($item['name'])];
    });
    if ($data->all) { $map = $map->prepend(['id' => 0, 'text' => 'All Brand', 'selected' => true]); }
    return $map;
  }
  function type_detail(Request $data){
    $type = type::where('type_id', $data->type_id)->first();
    return $type;
  }
  function brand_detail(Request $data){
    $brand = brand::where('brand_id', $data->brand_id)->first();
    return $brand;
  }
  function contact_email_select2(Request $data){
    $email = contact_email::where('name', 'like', '%'.$data->q.'%')->paginate(10);
    $map = ($email)->map(function($item){
      return ['id' => $item['email_id'], 'text' => ucwords($item['name']).' - '.strtolower($item['email'])];
    });
    if ($data->all) { $map = $map->prepend(['id' => 0, 'text' => 'All Brand', 'selected' => true]); }
    return $map;
  }
  // -------------------------- SETTINGS --------------------------
  function setting(Request $data){
    $setting = setting::first();
    $request = $data->all();
    return compact('request', 'setting');
  }
  // -------------------------- NEWS --------------------------
  function news_detail(Request $data){
    $news = news::where('news_id', $data->news_id)->first();
    return $news;
  }
  // -------------------------- PROMO --------------------------
  function promo_detail(Request $data){
    $promo = promo::where('promo_id', $data->promo_id)->first();
    return $promo;
  }
  // -------------------------- BANNER --------------------------
  function banner_detail($banner_id){
    $banner = banner::where('banner_id', $banner_id)->first();
    return $banner;
  }
  // -------------------------- CHILD CHECKER --------------------------
  function series_ishaschild($series_id){
    $series = series::where('series_id', $series_id)->first();
    $child = $series->product->brand->child;
    $model = model::where('series_id', $series_id)->get();
    $count = $model->count();
    return compact('series_id', 'child', 'model', 'count');
  }
}
