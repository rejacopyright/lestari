<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Storage;

use App\promo;

class promo_c extends Controller
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
  function compress_img($base64, $x){
    $encoded_string = explode(',', $base64)[1];
    $imgdata = base64_decode($encoded_string);
    list($w_ori, $h_ori) = getimagesizefromstring($imgdata);
    $img = imagecreatefromstring($imgdata);
    $y = $h_ori/($w_ori/$x);
    $img_edit = imagecreatetruecolor($x, $y);
    imagecopyresampled($img_edit, $img, 0, 0, 0, 0, $x, $y, $w_ori, $h_ori);
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
  function promo(Request $data){
    $q = $data->q;
    if ($q) {
      $promo = promo::where('title', 'like', '%'.$data->q.'%')->orderBy('created_at', 'DESC')->paginate(5);
    }else {
      $promo = promo::orderBy('created_at', 'DESC')->paginate(5);
    }
    return view('admin.promo', compact('promo', 'q'));
  }
  function add(){
    return view('admin.promo_add');
  }
  function edit($promo_id){
    $promo = promo::where('promo_id', $promo_id)->first();
    return view('admin.promo_edit', compact('promo'));
  }
  function store(Request $data){
    // dd($data->all());
    $promo_id = promo::max('promo_id')+1;
    if ($data->hasFile('image')) {
      $base64 = 'data:'.($data->image)->getClientMimeType().';base64,'.base64_encode(file_get_contents($data->image));
      $base64 = $this->compress_img($base64, 500);
      $filename = $promo_id.$base64['type'];
    }
    // STORE TO TYPE
    $promo = new promo;
    $promo->promo_id = $promo_id;
    $promo->title = $data->title;
    $promo->description = $data->description;
    $promo->image = $filename ?? null;
    $promo->save();
    // SAVE IMAGE
    if ($data->hasFile('image')) {
      if (!is_dir('public/images/promo')) { mkdir('public/images/promo', 0777, true); }
      file_put_contents('public/images/promo/'.$filename, base64_decode($base64['img']));
    }
    return redirect('admin/promo');
  }
  function put(Request $data){
    $promo_id = $data->promo_id;
    $promo = promo::where('promo_id', $data->promo_id)->first();
    if ($data->hasFile('image')) {
      $base64 = 'data:'.($data->image)->getClientMimeType().';base64,'.base64_encode(file_get_contents($data->image));
      $base64 = $this->compress_img($base64, 500);
      $filename = $promo_id.$base64['type'];
      Storage::delete('public/images/promo/'.$promo->image);
      if (!is_dir('public/images/promo')) { mkdir('public/images/promo', 0777, true); }
      file_put_contents('public/images/promo/'.$filename, base64_decode($base64['img']));
    }
    // STORE TO TYPE
    $promo->title = $data->title;
    $promo->description = $data->description;
    $promo->image = $filename ?? $promo->image;
    $promo->save();
    return redirect('admin/promo');
  }
  function delete(Request $data){
    $promo = promo::where('promo_id', $data->promo_id)->first();
    Storage::delete('public/images/promo/'.$promo->image);
    $promo->delete();
    return back();
  }
}
