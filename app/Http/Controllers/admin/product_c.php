<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Storage;
use App\product;
use App\product_type as type;
use App\product_brand as brand;
use App\product_series as series;
use App\product_model as model;
use App\product_spec as spec;
use App\master_spec as ms;
use App\spec_value as value;
use App\banner;

class product_c extends Controller
{
  function crop_img($base64, $dimensi){
    $encoded_string = explode(',', $base64)[1];
    $imgdata = base64_decode($encoded_string);
    list($w_ori, $h_ori) = getimagesizefromstring($imgdata);
    $img = imagecreatefromstring($imgdata);
    $img_edit = imagecreatetruecolor($dimensi, $dimensi);
    // $white = imagecolorallocate($img_edit, 255, 255, 255);
    // imagefill($img_edit,0,0,$white);
    if ($w_ori > $h_ori) {
      $ratio = $w_ori/$h_ori;
      // dd(((($dimensi*$ratio)-$dimensi)/3));
      imagecopyresampled($img_edit, $img, -((($dimensi*$ratio)-$dimensi)/3), 0, 0, 0, ($dimensi*$ratio), $dimensi, $w_ori, $h_ori);
    }elseif ($w_ori < $h_ori) {
      $ratio = $h_ori/$w_ori;
      imagecopyresampled($img_edit, $img, 0, -((($dimensi*$ratio)-$dimensi)/3), 0, 0, $dimensi, ($dimensi*$ratio), $w_ori, $h_ori);
    }else {
      imagecopyresampled($img_edit, $img, 0, 0, 0, 0, $dimensi, $dimensi, $w_ori, $h_ori);
    }
    // imagecopyresampled($img_edit, $img, 0, 0, 0, 0, $dimensi, $dimensi, $w_ori, $h_ori);
    ob_start();
    imagejpeg($img_edit);
    $contents =  ob_get_contents();
    ob_end_clean();
    $img = base64_encode($contents);
    $base = explode(',', $base64)[0];
    if ($base == "data:image/jpeg;base64") {
      $type = '.jpg';
    }elseif ($base == "data:image/png;base64") {
      $type = '.png';
    }
    $base = $base.",";
    return compact('base', 'img', 'type');
  }
  function resize_img($base64, $dimensi){
    $encoded_string = explode(',', $base64)[1];
    $imgdata = base64_decode($encoded_string);
    list($w_ori, $h_ori) = getimagesizefromstring($imgdata);
    $img = imagecreatefromstring($imgdata);
    $img_edit = imagecreatetruecolor($dimensi, $dimensi);
    $white = imagecolorallocate($img_edit, 255, 255, 255);
    imagefill($img_edit,0,0,$white);
    if ($w_ori > $h_ori) {
      $ratio = $h_ori/$w_ori;
      imagecopyresampled($img_edit, $img, 0, (($dimensi-($dimensi*$ratio))/2), 0, 0, $dimensi, ($dimensi*$ratio), $w_ori, $h_ori);
    }elseif ($w_ori < $h_ori) {
      $ratio = $w_ori/$h_ori;
      imagecopyresampled($img_edit, $img, (($dimensi-($dimensi*$ratio))/2), 0, 0, 0, ($dimensi*$ratio), $dimensi, $w_ori, $h_ori);
    }else {
      imagecopyresampled($img_edit, $img, 0, 0, 0, 0, $dimensi, $dimensi, $w_ori, $h_ori);
    }
    // imagecopyresampled($img_edit, $img, 0, 0, 0, 0, $dimensi, $dimensi, $w_ori, $h_ori);
    ob_start();
    imagejpeg($img_edit);
    $contents =  ob_get_contents();
    ob_end_clean();
    $img = base64_encode($contents);
    $base = explode(',', $base64)[0];
    if ($base == "data:image/jpeg;base64") {
      $type = '.jpg';
    }elseif ($base == "data:image/png;base64") {
      $type = '.png';
    }
    $base = $base.",";
    return compact('base', 'img', 'type');
  }
  // MASTER
  function master_spec(Request $data){
    $q = $data->q;
    if ($q) {
      $ms = ms::where('name', 'like', '%'.$data->q.'%')->orderBy('created_at', 'DESC')->paginate(10);
    }else {
      $ms = ms::orderBy('created_at', 'DESC')->paginate(10);
    }
    return view('admin.product_master_spec', compact('ms', 'q'));
  }
  function master_spec_store(Request $data){
    $ms_id = ms::max('ms_id')+1;
    $ms = new ms;
    $ms->ms_id = $ms_id;
    $ms->name = $data->name;
    $ms->save();
    return back();
  }
  function master_spec_update(Request $data){
    $ms = ms::where('ms_id', $data->ms_id)->first();
    if ($data->name) { $ms->name = $data->name; }
    $ms->save();
    return back();
  }
  function master_spec_delete(Request $data){
    value::where('ms_id', $data->ms_id)->delete();
    ms::where('ms_id', $data->ms_id)->delete();
    return back();
  }
  // TYPE
  function type(Request $data){
    $q = $data->q;
    if ($q) {
      $type = type::where('name', 'like', '%'.$data->q.'%')->orderBy('created_at', 'DESC')->paginate(5);
    }else {
      $type = type::orderBy('created_at', 'DESC')->paginate(5);
    }
    return view('admin.product_type', compact('type', 'q'));
  }
  function type_store(Request $data){
    $type_id = type::max('type_id')+1;
    if ($data->hasFile('image')) {
      $base64 = 'data:'.($data->image)->getClientMimeType().';base64,'.base64_encode(file_get_contents($data->image));
      $base64 = $this->resize_img($base64, 500);
      $filename = $type_id.$base64['type'];
    }
    // STORE TO TYPE
    $type = new type;
    $type->type_id = $type_id;
    $type->name = $data->name;
    $type->image = $filename ?? null;
    $type->save();
    // SAVE IMAGE
    if ($data->hasFile('image')) {
      if (!is_dir('public/images/type')) { mkdir('public/images/type', 0777, true); }
      file_put_contents('public/images/type/'.$filename, base64_decode($base64['img']));
    }
    return back();
  }
  function type_update(Request $data){
    $type = type::where('type_id', $data->type_id)->first();
    if ($data->hasFile('image')) {
      $base64 = 'data:'.($data->image)->getClientMimeType().';base64,'.base64_encode(file_get_contents($data->image));
      $base64 = $this->resize_img($base64, 500);
      $filename = $type->type_id.$base64['type'];
      Storage::delete('public/images/type/'.$type->image);
    }
    // STORE TO TYPE
    if ($data->name) { $type->name = $data->name; }
    $type->image = $filename ?? $type->image;
    $type->save();
    // SAVE IMAGE
    if ($data->hasFile('image')) {
      file_put_contents('public/images/type/'.$filename, base64_decode($base64['img']));
    }
    return back();
  }
  function type_delete(Request $data){
    product::where('type_id', $data->type_id)->update(['type_id' => null]);
    type::where('type_id', $data->type_id)->delete();
    return back();
  }
  // BRAND
  function brand(Request $data){
    $q = $data->q;
    if ($q) {
      $brand = brand::where('name', 'like', '%'.$data->q.'%')->orderBy('created_at', 'DESC')->paginate(5);
    }else {
      $brand = brand::orderBy('created_at', 'DESC')->paginate(5);
    }
    return view('admin.product_brand', compact('brand', 'q'));
  }
  function brand_store(Request $data){
    $brand_id = brand::max('brand_id')+1;
    if ($data->hasFile('image')) {
      $base64 = 'data:'.($data->image)->getClientMimeType().';base64,'.base64_encode(file_get_contents($data->image));
      $base64 = $this->resize_img($base64, 250);
      $filename = $brand_id.$base64['type'];
    }
    // STORE TO BRAND
    $brand = new brand;
    $brand->brand_id = $brand_id;
    $brand->name = $data->name;
    $brand->image = $filename ?? null;
    $brand->save();
    // SAVE IMAGE
    if ($data->hasFile('image')) {
      if (!is_dir('public/images/brand')) { mkdir('public/images/brand', 0777, true); }
      file_put_contents('public/images/brand/'.$filename, base64_decode($base64['img']));
    }
    return back();
  }
  function brand_update(Request $data){
    $brand = brand::where('brand_id', $data->brand_id)->first();
    if ($data->hasFile('image')) {
      $base64 = 'data:'.($data->image)->getClientMimeType().';base64,'.base64_encode(file_get_contents($data->image));
      $base64 = $this->resize_img($base64, 250);
      $filename = $brand->brand_id.$base64['type'];
      Storage::delete('public/images/brand/'.$brand->image);
    }
    // STORE TO BRAND
    if ($data->name) { $brand->name = $data->name; }
    $brand->image = $filename ?? $brand->image;
    $brand->save();
    // SAVE IMAGE
    if ($data->hasFile('image')) {
      file_put_contents('public/images/brand/'.$filename, base64_decode($base64['img']));
    }
    return back();
  }
  function brand_delete(Request $data){
    product::where('brand_id', $data->brand_id)->update(['brand_id' => null]);
    brand::where('brand_id', $data->brand_id)->delete();
    return back();
  }
  // PRODUCT
  function index(Request $data){
    $q = $data->q;
    $type_id = $data->type_id;
    $brand_id = $data->brand_id;
    $product = product::orderBy('created_at', 'DESC');
    if ($q) { $product = $product->where('name', 'like', '%'.$q.'%'); }
    if ($type_id) { $product = $product->where('type_id', $type_id); }
    if ($brand_id) { $product = $product->where('brand_id', $brand_id); }
    $product = $product->paginate(5);
    return view('admin.product', compact('product', 'q', 'type_id', 'brand_id'));
  }
  function product_add(){
    return view('admin.product_add');
  }
  function product_edit($product_id){
    $product = product::where('product_id', $product_id)->first();
    $ms = ms::whereIn('ms_id', explode('|', $product->ms_id))->get();
    return view('admin.product_edit', compact('product', 'ms'));
  }
  function product_store(Request $data){
    $ms = $data->ms_id ? implode('|', $data->ms_id) : null;
    $product_id = product::max('product_id')+1;
    $product = new product;
    if ($data->hasFile('catalog') && !$data->delete_catalog) {
      $catalog_ext = explode('.', $data->file('catalog')->getClientOriginalName());
      $catalog_ext = end($catalog_ext);
      $catalog_name = 'PROD_'.$product_id.'.'.$catalog_ext;
      $data->file('catalog')->storeAs('public/images/catalog', $catalog_name);
    }
    if ($data->hasFile('image')) {
      $base64 = 'data:'.($data->image)->getClientMimeType().';base64,'.base64_encode(file_get_contents($data->image));
      $base64 = $this->resize_img($base64, 500);
      $image_name = $product_id.$base64['type'];
      // SAVE IMAGE
      if (!is_dir('public/images/products')) { mkdir('public/images/products', 0777, true); }
      file_put_contents('public/images/products/'.$image_name, base64_decode($base64['img']));
    }
    // STORE TO PRODUCT
    $product->product_id = $product_id;
    $product->brand_id = $data->brand_id;
    $product->type_id = $data->type_id;
    $product->ms_id = $ms;
    $product->name = $data->name;
    $product->catalog = $catalog_name ?? null;
    if ($data->has('download_access')) { $product->download_access = 1; }
    $product->description = $data->description;
    $product->image = $image_name ?? null;
    $product->save();
    return redirect('admin/product?brand_id='.$data->brand_id);
  }
  function product_update(Request $data){
    $ms = $data->ms_id ? implode('|', $data->ms_id) : null;
    $product = product::where('product_id', $data->product_id)->first();
    if ($data->hasFile('catalog') || $data->has('delete_catalog')) {
      Storage::delete('public/images/catalog/'.$product->catalog);
    }
    if ($data->hasFile('catalog') && !$data->delete_catalog) {
      $catalog_ext = explode('.', $data->file('catalog')->getClientOriginalName());
      $catalog_ext = end($catalog_ext);
      $catalog_name = 'PROD_'.$product->product_id.'.'.$catalog_ext;
      $data->file('catalog')->storeAs('public/images/catalog', $catalog_name);
    }
    if ($data->hasFile('image')) {
      Storage::delete('public/images/products/'.$product->image);
      $base64 = 'data:'.($data->image)->getClientMimeType().';base64,'.base64_encode(file_get_contents($data->image));
      $base64 = $this->resize_img($base64, 500);
      $image_name = $product->product_id.$base64['type'];
      // SAVE IMAGE
      if (!is_dir('public/images/products')) { mkdir('public/images/products', 0777, true); }
      file_put_contents('public/images/products/'.$image_name, base64_decode($base64['img']));
    }
    // STORE TO PRODUCT
    if ($data->brand_id) { $product->brand_id = $data->brand_id; }
    if ($data->type_id) { $product->type_id = $data->type_id; }
    if ($ms) { $product->ms_id = $ms; }
    if ($data->name) { $product->name = $data->name; }
    if ($data->hasFile('catalog') && !$data->delete_catalog) {
      $product->catalog = $catalog_name;
    }elseif ($data->has('delete_catalog')) {
      $product->catalog = null;
    }
    if ($data->has('download_access')) { $product->download_access = 1; }else { $product->download_access = null; }
    if ($data->description) { $product->description = $data->description; }
    $product->image = $image_name ?? $product->image;
    $product->save();
    return redirect('admin/product?q='.urlencode($product->name).'&brand_id='.$product->brand_id);
  }
  function product_delete(Request $data){
    $product = product::where('product_id', $data->product_id)->first();
    $series = series::where('product_id', $product->product_id);
    $spec = spec::whereIn('series_id', $series->pluck('series_id')->all());
    $value = value::where('product_id', $product->product_id);
    // DELETE STORAGE
    Storage::delete('public/images/products/'.$product->image);
    Storage::delete('public/images/catalog/'.$product->catalog);
    foreach ($series->get() as $sr) {
      Storage::delete('public/images/series/'.$sr->image);
      Storage::delete('public/images/catalog/'.$sr->catalog);
    }
    foreach ($spec->get() as $spc) {
      Storage::delete('public/images/spec/'.$spc->image);
      Storage::delete('public/images/catalog/'.$spc->catalog);
    }
    // DELETE RECORD
    $value->delete();
    $spec->delete();
    $series->delete();
    $product->delete();
    return back();
  }
  // SERIES
  function product_series(Request $data){
    $q = $data->q;
    $type_id = $data->type_id;
    $brand_id = $data->brand_id;
    $product_id = $data->product_id;
    $series = series::orderBy('created_at', 'DESC');
    if ($q) { $series = $series->where('name', 'like', '%'.$q.'%'); }
    if ($type_id) { $series = $series->whereIn('product_id', product::where('type_id', $type_id)->pluck('product_id')->all()); }
    if ($brand_id) { $series = $series->whereIn('product_id', product::where('brand_id', $brand_id)->pluck('product_id')->all()); }
    if ($product_id) { $series = $series->where('product_id', $product_id); }
    $series = $series->paginate(5);
    return view('admin.product_series', compact('series', 'q', 'type_id', 'brand_id', 'product_id'));
  }
  function product_series_add(){
    return view('admin.product_series_add');
  }
  function product_series_edit($series_id){
    $series = series::where('series_id', $series_id)->first();
    return view('admin.product_series_edit', compact('series'));
  }
  function product_series_store(Request $data){
    $series_id = series::max('series_id')+1;
    $series = new series;
    if ($data->hasFile('catalog') && !$data->delete_catalog) {
      $catalog_ext = explode('.', $data->file('catalog')->getClientOriginalName());
      $catalog_ext = end($catalog_ext);
      $catalog_name = 'SR_'.$series_id.'.'.$catalog_ext;
      $data->file('catalog')->storeAs('public/images/catalog', $catalog_name);
    }
    if ($data->hasFile('image')) {
      $base64 = 'data:'.($data->image)->getClientMimeType().';base64,'.base64_encode(file_get_contents($data->image));
      $base64 = $this->resize_img($base64, 500);
      $image_name = $series_id.$base64['type'];
      // SAVE IMAGE
      if (!is_dir('public/images/series')) { mkdir('public/images/series', 0777, true); }
      file_put_contents('public/images/series/'.$image_name, base64_decode($base64['img']));
    }
    // STORE TO SERIES
    $series->series_id = $series_id;
    $series->product_id = $data->product_id;
    $series->name = $data->name;
    $series->catalog = $catalog_name ?? null;
    if ($data->has('download_access')) { $series->download_access = 1; }
    $series->description = $data->description;
    $series->image = $image_name ?? null;
    $series->save();
    return redirect('admin/product/series?product_id='.$data->product_id ?? '');
  }
  function product_series_update(Request $data){
    $series = series::where('series_id', $data->series_id)->first();
    $spec = spec::where('series_id', $series->series_id)->pluck('spec_id')->all();
    value::whereIn('spec_id', $spec)->update(['product_id' => $data->product_id]);
    if ($data->hasFile('catalog') || $data->has('delete_catalog')) {
      Storage::delete('public/images/catalog/'.$series->catalog);
    }
    if ($data->hasFile('catalog') && !$data->delete_catalog) {
      $catalog_ext = explode('.', $data->file('catalog')->getClientOriginalName());
      $catalog_ext = end($catalog_ext);
      $catalog_name = 'SR_'.$series->series_id.'.'.$catalog_ext;
      $data->file('catalog')->storeAs('public/images/catalog', $catalog_name);
    }
    if ($data->hasFile('image')) {
      Storage::delete('public/images/series/'.$series->image);
      $base64 = 'data:'.($data->image)->getClientMimeType().';base64,'.base64_encode(file_get_contents($data->image));
      $base64 = $this->resize_img($base64, 500);
      $image_name = $series->series_id.$base64['type'];
      // SAVE IMAGE
      if (!is_dir('public/images/series')) { mkdir('public/images/series', 0777, true); }
      file_put_contents('public/images/series/'.$image_name, base64_decode($base64['img']));
    }
    // STORE TO PRODUCT
    if ($data->product_id) { $series->product_id = $data->product_id; }
    if ($data->name) { $series->name = $data->name; }
    if ($data->hasFile('catalog') && !$data->delete_catalog) {
      $series->catalog = $catalog_name;
    }elseif ($data->has('delete_catalog')) {
      $series->catalog = null;
    }
    if ($data->has('download_access')) { $series->download_access = 1; }else { $series->download_access = null; }
    if ($data->description) { $series->description = $data->description; }
    $series->image = $image_name ?? $series->image;
    $series->save();
    return redirect('admin/product/series?product_id='.$data->product_id ?? '');
  }
  function product_series_delete(Request $data){
    $series = series::where('series_id', $data->series_id)->first();
    $spec = spec::where('series_id', $series->series_id);
    $value = value::whereIn('spec_id', $spec->pluck('spec_id')->all());
    // DELETE STORAGE
    Storage::delete('public/images/series/'.$series->image);
    Storage::delete('public/images/catalog/'.$series->catalog);
    foreach ($spec->get() as $spc) {
      Storage::delete('public/images/spec/'.$spc->image);
      Storage::delete('public/images/catalog/'.$spc->catalog);
    }
    // DELETE RECORD
    $value->delete();
    $spec->delete();
    $series->delete();
    return back();
  }
  // SPEC
  function product_spec(Request $data){
    $q = $data->q;
    $product_id = $data->product_id;
    $series_id = $data->series_id;
    $model_id = $data->model_id;
    $spec = spec::orderBy('created_at', 'DESC');
    if ($q) { $spec = $spec->where('name', 'like', '%'.$q.'%'); }
    if ($product_id) { $spec = $spec->whereIn('series_id', series::where('product_id', $product_id)->pluck('series_id')->all()); }
    if ($series_id) { $spec = $spec->where('series_id', $series_id); }
    if ($model_id) { $spec = $spec->where('model_id', $model_id); }
    $spec = $spec->paginate(5);
    return view('admin.product_spec', compact('spec', 'q', 'product_id', 'series_id', 'model_id'));
  }
  function product_spec_store(Request $data){
    $spec_id = spec::max('spec_id')+1;
    $spec = new spec;
    if ($data->hasFile('catalog') && !$data->delete_catalog) {
      $catalog_ext = explode('.', $data->file('catalog')->getClientOriginalName());
      $catalog_ext = end($catalog_ext);
      $catalog_name = 'SPC_'.$spec_id.'.'.$catalog_ext;
      $data->file('catalog')->storeAs('public/images/catalog', $catalog_name);
    }
    if ($data->hasFile('image')) {
      $base64 = 'data:'.($data->image)->getClientMimeType().';base64,'.base64_encode(file_get_contents($data->image));
      $base64 = $this->resize_img($base64, 500);
      $image_name = $spec_id.$base64['type'];
      // SAVE IMAGE
      if (!is_dir('public/images/spec')) { mkdir('public/images/spec', 0777, true); }
      file_put_contents('public/images/spec/'.$image_name, base64_decode($base64['img']));
    }
    // STORE TO SERIES
    $spec->spec_id = $spec_id;
    $spec->series_id = $data->series_id;
    $spec->name = $data->name;
    $spec->catalog = $catalog_name ?? null;
    if ($data->has('download_access')) { $spec->download_access = 1; }
    $spec->description = $data->description;
    $spec->image = $image_name ?? null;
    $spec->save();
    return back();
  }
  function product_spec_update(Request $data){
    // dd($data->all());
    $spec = spec::where('spec_id', $data->spec_id)->first();
    if ($data->product_id && $spec->series->product_id != $data->product_id) {
      value::where('spec_id', $spec->spec_id)->delete();
    }
    if ($data->hasFile('catalog') || $data->has('delete_catalog')) {
      Storage::delete('public/images/catalog/'.$spec->catalog);
    }
    if ($data->hasFile('catalog') && !$data->delete_catalog) {
      $catalog_ext = explode('.', $data->file('catalog')->getClientOriginalName());
      $catalog_ext = end($catalog_ext);
      $catalog_name = 'SPC_'.$spec->spec_id.'.'.$catalog_ext;
      $data->file('catalog')->storeAs('public/images/catalog', $catalog_name);
    }
    if ($data->hasFile('image')) {
      Storage::delete('public/images/spec/'.$spec->image);
      $base64 = 'data:'.($data->image)->getClientMimeType().';base64,'.base64_encode(file_get_contents($data->image));
      $base64 = $this->resize_img($base64, 500);
      $image_name = $spec->spec_id.$base64['type'];
      // SAVE IMAGE
      if (!is_dir('public/images/spec')) { mkdir('public/images/spec', 0777, true); }
      file_put_contents('public/images/spec/'.$image_name, base64_decode($base64['img']));
    }
    // STORE TO SPEC
    if ($data->series_id) { $spec->series_id = $data->series_id; }
    if ($data->name) { $spec->name = $data->name; }
    if ($data->hasFile('catalog') && !$data->delete_catalog) {
      $spec->catalog = $catalog_name;
    }elseif ($data->has('delete_catalog')) {
      $spec->catalog = null;
    }
    if ($data->has('download_access')) { $spec->download_access = 1; }else { $spec->download_access = null; }
    if ($data->description) { $spec->description = $data->description; }
    $spec->image = $image_name ?? $spec->image;
    $spec->save();
    return back();
  }
  function product_spec_value(Request $data){
    value::where('spec_id', $data->spec_id)->delete();
    foreach ($data->ms_name as $key => $val) {
      $value = new value;
      $value->spec_id = $data->spec_id;
      $value->product_id = $data->product_id;
      $value->ms_id = $data->ms_name[$key];
      $value->ms_value = $data->ms_value[$key];
      $value->save();
    }
    return back();
  }
  function product_spec_delete(Request $data){
    $spec = spec::where('spec_id', $data->spec_id)->first();
    $value = value::where('spec_id', $spec->spec_id);
    // DELETE STORAGE
    Storage::delete('public/images/spec/'.$spec->image);
    Storage::delete('public/images/catalog/'.$spec->catalog);
    // DELETE RECORD
    $value->delete();
    $spec->delete();
    return back();
  }
  // MODEL
  function product_model(Request $data){
    $q = $data->q;
    $product_id = $data->product_id;
    $series_id = $data->series_id;
    $model = model::orderBy('created_at', 'DESC');
    if ($q) { $model = $model->where('name', 'like', '%'.$q.'%'); }
    if ($product_id) { $model = $model->whereIn('series_id', series::where('product_id', $product_id)->pluck('series_id')->all()); }
    if ($series_id) { $model = $model->where('series_id', $series_id); }
    $model = $model->paginate(5);
    return view('admin.product_model', compact('model', 'q', 'product_id', 'series_id'));
  }
  function product_model_store(Request $data){
    $model_id = model::max('model_id')+1;
    $model = new model;
    if ($data->hasFile('image')) {
      $base64 = 'data:'.($data->image)->getClientMimeType().';base64,'.base64_encode(file_get_contents($data->image));
      $base64 = $this->resize_img($base64, 500);
      $image_name = $model_id.$base64['type'];
      // SAVE IMAGE
      if (!is_dir('public/images/model')) { mkdir('public/images/model', 0777, true); }
      file_put_contents('public/images/model/'.$image_name, base64_decode($base64['img']));
    }
    // STORE TO SERIES
    $model->model_id = $model_id;
    $model->series_id = $data->series_id;
    $model->name = $data->name;
    $model->description = $data->description;
    $model->image = $image_name ?? null;
    $model->save();
    return back();
  }
  function product_model_update(Request $data){
    $model = model::where('model_id', $data->model_id)->first();
    $spec = spec::where('model_id', $model->model_id)->select('spec_id')->pluck('spec_id')->all();
    value::whereIn('spec_id', $spec)->update(['product_id' => $data->product_id]);
    spec::where('model_id', $model->model_id)->update(['series_id' => $data->series_id]);
    if ($data->hasFile('image')) {
      Storage::delete('public/images/model/'.$model->image);
      $base64 = 'data:'.($data->image)->getClientMimeType().';base64,'.base64_encode(file_get_contents($data->image));
      $base64 = $this->resize_img($base64, 500);
      $image_name = $model->model_id.$base64['type'];
      // SAVE IMAGE
      if (!is_dir('public/images/model')) { mkdir('public/images/model', 0777, true); }
      file_put_contents('public/images/model/'.$image_name, base64_decode($base64['img']));
    }
    // UPDATE TO MODEL
    if ($data->series_id) { $model->series_id = $data->series_id; }
    if ($data->name) { $model->name = $data->name; }
    if ($data->description) { $model->description = $data->description; }
    $model->image = $image_name ?? $model->image;
    $model->save();
    return back();
  }
  function product_model_delete(Request $data){
    $model = model::where('model_id', $data->model_id)->first();
    $spec = spec::where('model_id', $model->model_id);
    $value = value::whereIn('spec_id', $spec->pluck('spec_id')->all());
    // DELETE STORAGE
    Storage::delete('public/images/model/'.$model->image);
    foreach ($spec->get() as $spc) {
      Storage::delete('public/images/spec/'.$spc->image);
    }
    // DELETE RECORD
    $value->delete();
    $spec->delete();
    $model->delete();
    return back();
  }
  // BANNER
  function master_banner_list(){
    $banner = banner::where('type', 'home')->orderBy('created_at', 'DESC')->paginate(6);
    return view('admin.banner_list', compact('banner'));
  }
  function master_banner(){
    $banner = banner::where('type', 'home')->orderBy('created_at', 'DESC')->paginate(6);
    return view('admin.banner', compact('banner'));
  }
  function master_banner_store(Request $data){
    $ext = explode(',', $data->image)[0]; if ($ext == "data:image/jpeg;base64") { $ext = ".jpg"; }elseif ($ext == "data:image/png;base64") { $ext = ".png"; }
    $banner_id = banner::max('banner_id')+1;
    $banner = new banner;
    if ($data->image) {
      $filename = ($banner_id).$ext;
      $base64 = explode(',', $data->image)[1];
      if (!is_dir('public/images/banner')) { mkdir('public/images/banner', 0777, true); }
      file_put_contents('public/images/banner/'.$filename, base64_decode($base64));
      $banner->banner_id = $banner_id;
      $banner->type = $data->type;
      $banner->image = $filename;
      $banner->status = 1;
      $banner->save();
    }
    return back();
  }
  function master_banner_update(Request $data){
    $ext = explode(',', $data->image)[0]; if ($ext == "data:image/jpeg;base64") { $ext = ".jpg"; }elseif ($ext == "data:image/png;base64") { $ext = ".png"; }
    $banner = banner::where('banner_id', $data->banner_id)->first();
    if ($data->image) {
      Storage::delete('public/images/banner/'.$banner->image);
      $filename = ($banner->banner_id).$ext;
      $base64 = explode(',', $data->image)[1];
      if (!is_dir('public/images/banner')) { mkdir('public/images/banner', 0777, true); }
      file_put_contents('public/images/banner/'.$filename, base64_decode($base64));
    }
    return back();
  }
  function master_banner_delete(Request $data){
    $banner = banner::where('banner_id', $data->delete_id)->first();
    Storage::delete('public/images/banner/'.$banner->image);
    $banner->delete();
    return back();
  }
  function master_banner_switch(Request $data){
    $banner = banner::where('banner_id', $data->banner_id)->first();
    if ($data->status) {
      $banner->status = 1;
    }else {
      $banner->status = null;
    }
    $banner->save();
    return $banner;
  }
}
