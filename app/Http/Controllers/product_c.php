<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\setting;
use App\product;
use App\product_type as type;
use App\product_brand as brand;
use App\product_series as series;
use App\product_model as model;
use App\product_spec as spec;
use App\master_spec as ms;
use App\spec_value as value;

class product_c extends Controller
{
  function product(Request $data){
    $q = $data->q;
    $type_id = $data->type_id;
    $brand_id = $data->brand_id;
    $product = product::orderBy('created_at', 'DESC');
    if ($q) { $product = $product->where('name', 'like', '%'.$q.'%'); }
    if ($type_id) { $product = $product->where('type_id', $type_id); }
    if ($brand_id) { $product = $product->where('brand_id', $brand_id); }
    if ($brand_id) {
      $brand_name = strtoupper(brand::where('brand_id', $brand_id)->first()->name);
    }else {
      $brand_name = 'PRODUCTS';
    }
    $product = $product->paginate(8);
    return view('product', compact('product', 'q', 'type_id', 'brand_id', 'brand_name'));
  }
  function detail(Request $data, $product_id){
    $q = $data->q;
    $product = product::where('product_id', $product_id)->first();
    $series = series::where('product_id', $product_id)->paginate(12);
    if ($q) { $series = series::where('product_id', $product_id)->where('name', 'like', '%'.$q.'%')->paginate(12); }
    $whatsapp = '62'.ltrim(setting::first()->whatsapp, "0");
    return view('product_detail', compact('product', 'series', 'q', 'whatsapp'));
  }
  function series(Request $data, $series_id){
    $q = $data->q;
    $series = series::where('series_id', $series_id)->first();
    $model = model::where('series_id', $series_id)->paginate(12);
    if ($q) { $model = model::where('series_id', $series_id)->where('name', 'like', '%'.$q.'%')->paginate(12); }
    $whatsapp = '62'.ltrim(setting::first()->whatsapp, "0");
    return view('series_detail', compact('series', 'model', 'q', 'whatsapp'));
  }
  function spec(Request $data){
    $q = $data->q;
    $product_id = $data->product_id;
    $series_id = $data->series_id;
    $model_id = $data->model_id;
    $value = $data->value;
    if ($value) {
      $value = value::whereIn('ms_value', $value)->where('product_id', $product_id)->pluck('spec_id')->all();
    }
    $spec = spec::orderBy('created_at', 'DESC');
    $product = product::where('product_id', $data->product_id)->first();
    $series = series::where('series_id', $data->series_id)->first();
    $model = model::where('model_id', $data->model_id)->first();
    $ms = ms::whereIn('ms_id', explode('|', $product->ms_id))->get();
    if ($q) { $spec = $spec->where('name', 'like', '%'.$q.'%'); }
    if ($product_id) { $spec = $spec->whereIn('series_id', series::where('product_id', $product_id)->pluck('series_id')->all()); }
    if ($series_id) { $spec = $spec->where('series_id', $series_id); }
    if ($model_id) { $spec = $spec->where('model_id', $model_id); }
    if ($value) { $spec = $spec->whereIn('spec_id', $value); }
    $spec = $spec->paginate(12);
    return view('product_spec', compact('spec', 'q', 'product_id', 'series_id', 'model_id', 'ms', 'product', 'series', 'model'));
  }
  function spec_detail($spec_id){
    $spec = spec::where('spec_id', $spec_id)->first();
    $ms_id = $spec->value()->pluck('ms_id')->all();
    $ms = ms::whereIn('ms_id', $ms_id)->get();
    $whatsapp = '62'.ltrim(setting::first()->whatsapp, "0");
    return view('product_spec_detail', compact('spec', 'ms', 'whatsapp'));
  }
}
