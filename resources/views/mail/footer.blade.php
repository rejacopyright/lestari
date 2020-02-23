<div style="display: block;background-color: #fff;padding: 1rem;-webkit-box-shadow: 0 5px 50px rgba(0,0,0,.15);box-shadow: 0 5px 50px rgba(0,0,0,.15);margin-top: 20px;margin-bottom: 30px;">
  <div style="width: 100%;text-align: center;margin-bottom: 20px;">
    <a style="text-decoration: none;color: #3f51b5;line-height: 2;margin-right: 15px;" href="{{url('/')}}" target="_blank">Home</a>
    <a style="text-decoration: none;color: #3f51b5;line-height: 2;margin-right: 15px;" href="{{url('product')}}" target="_blank">Products</a>
    <a style="text-decoration: none;color: #3f51b5;line-height: 2;margin-right: 15px;" href="{{url('about')}}" target="_blank">About Us</a>
    <a style="text-decoration: none;color: #3f51b5;line-height: 2;margin-right: 15px;" href="{{url('news')}}" target="_blank">News</a>
    <a style="text-decoration: none;color: #3f51b5;line-height: 2;margin-right: 15px;" href="{{url('promo')}}" target="_blank">Promo</a>
    <a style="text-decoration: none;color: #3f51b5;line-height: 2;" href="{{url('contact')}}" target="_blank">Contact Us</a>
  </div>
  <div style="width: 100%;text-align: center;margin-bottom: 10px;">
    <a style="text-decoration: none;" href="{{$setting->facebook ?? 'javascript:void(0)'}}" target="_blank"> <img src="{{url('public/images/icon/facebook.png')}}"style="height: 30px;"> </a>
    <a style="text-decoration: none;" href="{{$setting->twitter ?? 'javascript:void(0)'}}" target="_blank"> <img src="{{url('public/images/icon/twitter.png')}}"style="height: 30px;"> </a>
    <a style="text-decoration: none;" href="{{$setting->instagram ?? 'javascript:void(0)'}}" target="_blank"> <img src="{{url('public/images/icon/instagram.png')}}"style="height: 30px;"> </a>
    <a style="text-decoration: none;" href="{{$setting->youtube ?? 'javascript:void(0)'}}" target="_blank"> <img src="{{url('public/images/icon/youtube.png')}}"style="height: 30px;"> </a>
  </div>
  <div style="display: block;width: 100%;"><hr style="border-top: 1px solid #eee;"></div>
  <div style="width: 100%;text-align: center;margin-top: 10px;line-height: 1.5;font-size: 10pt;">
    {{$setting->address}}
  </div>
  <div style="width: 100%;text-align: center;margin-top: 10px;line-height: 1.5;font-size: 10pt;color: #aaa;">
    ©Copyright {{date('Y')}} <strong>{{ucwords($setting->alias)}}</strong> All Right Reserved
  </div>
</div>
