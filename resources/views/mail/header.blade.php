<div style="display: -webkit-flex;display: -ms-flex;display: flex;border-top: 10px solid #3f51b5;padding: 1rem;background-color: #fff;">
  <div style="width:auto;">
    <a href="{{url('/')}}" style="text-decoration: none;color: #3f51b5;display: -webkit-flex;display: -ms-flex;display: flex;-ms-align-items: center;align-items: center;">
      <img src="{{url('public')}}/images/logo.png?{{time()}}" style="margin-right: 10px;height: 30px;">
      <h4 style="display: inline;font-weight: bold;margin: 0;font-size: 80%;white-space: nowrap;line-height: 30px;">{{strtoupper($setting->alias)}}</h4>
    </a>
  </div>
  <div style="width:auto;margin-left: auto;">
    <a href="{{$setting->facebook ?? 'javascript:void(0)'}}" target="_blank" style="text-decoration: none;margin-right: auto;"> <img src="{{url('public/images/icon/facebook.png')}}" alt="" style="width: 30px;"> </a>
    <a href="{{$setting->twitter ?? 'javascript:void(0)'}}" target="_blank" style="text-decoration: none;margin-right: auto;"> <img src="{{url('public/images/icon/twitter.png')}}" alt="" style="width: 30px;"> </a>
    <a href="{{$setting->instagram ?? 'javascript:void(0)'}}" target="_blank" style="text-decoration: none;margin-right: auto;"> <img src="{{url('public/images/icon/instagram.png')}}" alt="" style="width: 30px;"> </a>
    <a href="{{$setting->youtube ?? 'javascript:void(0)'}}" target="_blank" style="text-decoration: none;"> <img src="{{url('public/images/icon/youtube.png')}}" alt="" style="width: 30px;"> </a>
  </div>
</div>
