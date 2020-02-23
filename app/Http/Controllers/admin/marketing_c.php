<?php

namespace App\Http\Controllers\admin;
use Mail;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\contact_email;
use App\setting;
use App\User;
use App\banner;

class marketing_c extends Controller
{
  function marketing(){
    return view('admin.marketing');
  }
  function contact_email(Request $data){
    $q = $data->q;
    if ($q) {
      $email = contact_email::where('name', 'like', '%'.$q.'%')->orWhere('email', 'like', '%'.$q.'%')->orderBy('created_at', 'DESC')->paginate(12);
    }else {
      $email = contact_email::orderBy('created_at', 'DESC')->paginate(12);
    }
    return view('admin.marketing_contact_email', compact('email', 'q'));
  }
  function contact_email_store(Request $data){
    function checkEmail($email) {
      $f1 = strpos($email, '@');
      $f2 = strpos(last(explode('@', $email)), '.');
      return ($f1 !== false && $f2 !== false);
    }
    $exist = contact_email::where('email', $data->email)->count();
    $exist_in_user = user::where('email', $data->email)->count();
    $email_id = contact_email::max('email_id')+1;
    $email = new contact_email;
    $email->email_id = $email_id;
    $email->name = ucwords($data->name);
    $email->email = $data->email;
    if ($data->name && $data->email && checkEmail($data->email) && !$exist_in_user && !$exist) {
      $email->save();
      return $email;
    }elseif (!$data->name || !$data->email) {
      return "Please fill field name and email";
    }elseif (!checkEmail($data->email)) {
      return "Email is Not Valid";
    }elseif ($exist_in_user) {
      return "The email you entered has been registered";
    }elseif ($exist) {
      return "The email you entered is already in contact list";
    }
  }
  function contact_email_delete(Request $data){
    contact_email::where('email_id', $data->email_id)->delete();
    return "Email successfully deleted";
  }
  function email(){
    return view('admin.marketing_email');
  }
  function email_store(Request $data){
    $email = collect([]);
    $element = [];
    $image = null;
    if ($data->image) {
      $element = collect($element)->push('image')->toArray();
      $image = banner::where('banner_id', $data->image)->first();
    }
    $setting = setting::first();
    $content = $data->message;
    if ($data->has('user')) {
      $email = user::pluck('email');
    }
    if ($data->has('contact')) {
      $email = contact_email::pluck('email')->merge($email->all());
    }elseif ($data->email_id) {
      $email = contact_email::whereIn('email_id', $data->email_id)->pluck('email')->merge($email->all());
    }
    if (count($email) > 0 && $data->button == 'submit') {
      $from = strtolower(env('MAIL_USERNAME', 'info@lestariautomation.com'));
      $to = $email->all();
      $sender = ucwords(strtolower($setting->alias ?? 'Email'));
      $subject = $data->subject;
      return Mail::send(["html"=> 'mail.mail'], compact('setting', 'element', 'image', 'content'), function($message) use ($to, $subject, $from, $sender){
        $message->to($to)->subject($subject);
        $message->from($from, $sender);
      });
    }elseif ($data->button == 'preview') {
      return view('mail.mail', compact('setting', 'element', 'image', 'content'));
    }
    // return redirect('admin/marketing/email');
  }
}
