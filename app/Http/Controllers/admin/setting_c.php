<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Storage;
use App\setting;

class setting_c extends Controller
{
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
  // About
  function about(){
    $setting = setting::first();
    return view('admin.set_about', compact('setting'));
  }
  function about_update(Request $data){
    $setting = setting::first();
    if (!$setting) { $setting = new setting; $setting->setting_id = 1; }
    $setting->about = $data->about;
    $setting->save();
    return back();
  }
  // Vision
  function vision(){
    $setting = setting::first();
    return view('admin.set_vision', compact('setting'));
  }
  function vision_update(Request $data){
    $setting = setting::first();
    if (!$setting) { $setting = new setting; $setting->setting_id = 1; }
    $setting->vision = $data->vision;
    $setting->save();
    return back();
  }
  // Vision
  function mission(){
    $setting = setting::first();
    return view('admin.set_mission', compact('setting'));
  }
  function mission_update(Request $data){
    $setting = setting::first();
    if (!$setting) { $setting = new setting; $setting->setting_id = 1; }
    $setting->mission = $data->mission;
    $setting->save();
    return back();
  }
  // Company
  function company(){
    $setting = setting::first();
    return view('admin.set_company', compact('setting'));
  }
  function company_update(Request $data){
    $setting = setting::first();
    if ($data->hasFile('image')) {
      $base64 = 'data:'.($data->image)->getClientMimeType().';base64,'.base64_encode(file_get_contents($data->image));
      $base64 = $this->resize_img($base64, 150);
      $filename = 'logo'.$base64['type'];
      Storage::delete('public/images/'.$setting->logo);
      file_put_contents('public/images/'.$filename, base64_decode($base64['img']));
    }
    if (!$setting) { $setting = new setting; $setting->setting_id = 1; }
    if ($data->name) { $setting->name = $data->name; }
    if ($data->alias) { $setting->alias = $data->alias; }
    if ($data->description) { $setting->description = $data->description; }
    if ($data->address) { $setting->address = $data->address; }
    if ($data->contact) { $setting->contact = $data->contact; }
    if ($data->email) { $setting->email = $data->email; }
    if ($data->whatsapp) { $setting->whatsapp = $data->whatsapp; }
    if ($data->facebook) { $setting->facebook = $data->facebook; }
    if ($data->twitter) { $setting->twitter = $data->twitter; }
    if ($data->instagram) { $setting->instagram = $data->instagram; }
    if ($data->youtube) { $setting->youtube = $data->youtube; }
    if ($data->hasFile('image')) { $setting->logo = $filename; }
    $setting->save();
    return back();
  }
}
