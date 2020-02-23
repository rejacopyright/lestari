@extends('layouts.user')
@section('title') ABOUT @endsection
@section('css')
<meta http-equiv="Content-Language" content="id" />
<meta property="og:title" content="ABOUT"/>
<meta property="og:description" content="ABOUT"/>
<meta name="description" content="ABOUT"/>
<meta property="og:type" content="image/jpeg"/>
<meta property="og:url" content="{{url()->full()}}"/>
<meta property="og:site_name" content="{{url('/')}}"/>
@endsection
@section('content')
<div class="single-page-header freelancer-header mb-4 py-3" data-background-image="{{url('public')}}/images/banner/{{App\banner::first()->image}}">
  <div class="container">
    <div class="col-12">
      <div class="single-page-header-inner">
        <div class="left-side">
          <div class="header-image freelancer-avatar p-3"><img src="{{url('public')}}/images/logo.png" alt=""></div>
          <div class="header-details">
            <h3>{{strtoupper($setting->name)}} <span class="text-info font-16 bold">{{ucwords($setting->description)}}</span></h3>
            <div class="freelancer-socials">
              <ul>
                <li><a href="{{$setting->facebook ?? 'javascript:void(0)'}}" target="{{$setting->facebook ? '_blank' : '_self'}}" title="Facebook" data-tippy-placement="top"><i class="icon-brand-facebook"></i></a></li>
                <li><a href="{{$setting->twitter ?? 'javascript:void(0)'}}" target="{{$setting->twitter ? '_blank' : '_self'}}" title="Twitter" data-tippy-placement="top"><i class="icon-brand-twitter"></i></a></li>
                <li><a href="{{$setting->instagram ?? 'javascript:void(0)'}}" target="{{$setting->instagram ? '_blank' : '_self'}}" title="Instagram" data-tippy-placement="top"><i class="icon-brand-instagram"></i></a></li>
                <li><a href="{{$setting->youtube ?? 'javascript:void(0)'}}" target="{{$setting->youtube ? '_blank' : '_self'}}" title="Youtube" data-tippy-placement="top"><i class="icon-brand-youtube"></i></a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="container mt-3">
  <!-- WHATSAPP -->
  <div class="position-fixed r-1 b-1 pointer z-999">
    <a href="https://api.whatsapp.com/send?phone=62{{ltrim(App\setting::first()->whatsapp, '0')}}" target="_blank" class="btn square-50 radius-50" bg="#4bc25a" data-tippy-placement="left" title="Ask Something"><i class="icon-brand-whatsapp text-white font-24 lh-13"></i></a>
  </div>
  <div class="row">
    <div class="col-lg-9 text-dark">
      <h2 class="mb-3 bg-gray py-2 px-3">About Us</h2>
      {!! $setting->about !!}
      <!-- FOR SEO Horizontal -->
      <div class="mt-3 text-center">
        @include('layouts.ads.horizontal')
      </div>
    </div>
    <div class="col-lg-3">
      <div class="accordion js-accordion">
				<div class="accordion__item js-accordion-item active">
					<div class="accordion-header js-accordion-header">VISION</div>
					<div class="accordion-body js-accordion-body">
						<div class="accordion-body__contents lh-12 text-dark">
              {!! $setting->vision !!}
						</div>
					</div>
				</div>
				<div class="accordion__item js-accordion-item">
					<div class="accordion-header js-accordion-header">MISSION</div>
					<div class="accordion-body js-accordion-body">
						<div class="accordion-body__contents lh-12 text-dark">
              {!! $setting->mission !!}
						</div>
					</div>
				</div>
			</div>
      <!-- FOR SEO GRID -->
      <div class="sidebar-widget text-center mt-4">
        @include('layouts.ads.square')
      </div>
    </div>
  </div>
</div>
@endsection
@section('js')
<script type="text/javascript">
  $(document).ready(function() {
    $("#navigation").find('.current').removeClass('current');
    $("#navigation").find('li a[href="{{url("about")}}"]:first').addClass('current');
  });
</script>
@endsection
