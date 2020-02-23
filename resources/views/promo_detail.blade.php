@extends('layouts.user')
@section('title') {{strtoupper($promo->title)}} @endsection
<?php function limit($a, $b){ $arr = explode(' ', $a); if (count($arr) <= $b) { $dot = ""; }else { $dot = "..."; } $limit = implode(' ', array_slice($arr,0,$b)); return $limit.$dot; } ?>
@section('css')
<meta http-equiv="Content-Language" content="id" />
<meta property="og:title" content="{{strtoupper($promo->title)}}"/>
<meta property="og:description" content="{{limit(strip_tags($promo->description), 5)}}"/>
<meta name="description" content="{{limit(strip_tags($promo->description), 5)}}"/>
<meta property="og:type" content="image/jpeg"/>
<meta property="og:url" content="{{url()->full()}}"/>
<meta property="og:site_name" content="{{url('/')}}"/>
<meta property="og:image" itemprop="image" content="{{url('public')}}/images/promo/{{$promo->image ?? '../image.png'}}?{{time()}}"/>
<meta property="og:image:secure_url" content="{{url('public')}}/images/promo/{{$promo->image ?? '../image.png'}}?{{time()}}"/>
<meta property="og:image:width" content="400" />
<meta property="og:image:height" content="400" />
<meta property="og:image:alt" content="{{strtoupper($promo->title)}}" />
@endsection
@section('content')
<div class="container mt-3">
  <!-- WHATSAPP -->
  <div class="position-fixed r-1 b-1 pointer z-999">
    <a href="https://api.whatsapp.com/send?phone=62{{ltrim(App\setting::first()->whatsapp, '0')}}" target="_blank" class="btn square-50 radius-50" bg="#4bc25a" data-tippy-placement="left" title="Ask Something"><i class="icon-brand-whatsapp text-white font-24 lh-13"></i></a>
  </div>
  <div class="row">
    <div class="col-md-9">
      <div class="blog-post single-post">
        <div class="blog-post-content py-3">
          <h3 class="lh-15 bold mb-1">{{$promo->title}}</h3>
          <div class="blog-post-info-list">
            <a href="javascript:void(0)" class="blog-post-info"><i class="icon-line-awesome-clock-o"></i> {{date('D, d M Y', strtotime($promo->created_at))}}</a>
            <div class="row align-items-center pop float-right mt-n2">
              <div class="col-auto d-flex pl-1 pop-target">
                <a href="javascript:void(0)" bg="#3b5998" class="d-block radius-40 text-center square-40 pt-1 mr-1 facebook-btn" title="Share on Facebook" data-tippy-placement="top"><i class="icon-brand-facebook-f font-16 lh-2 text-white"></i></a>
                <a href="https://api.whatsapp.com/send?text={{urlencode(url()->full())}}" target="_blank" bg="#4bc25a" class="d-block radius-40 text-center square-40 pt-1" title="Share on Whatsapp" data-tippy-placement="top"><i class="icon-brand-whatsapp font-16 lh-2 text-white"></i></a>
              </div>
              <div class="col-auto badge-info px-4 py-2 pop-trigger pointer"><i class="icon-feather-share-2"></i> Share</div>
            </div>
          </div>
        </div>
        <?php if ($promo->image): ?>
          <img class="w-100 h-auto" src="{{url('public')}}/images/promo/{{$promo->image ?? '../image.png'}}?{{time()}}" alt="">
        <?php endif; ?>
        <div class="blog-post-content pt-2">
          <h3 class="lh-15 bold mb-1">{{$promo->title}}</h3>
          <div class="blog-post-info-list">
            <a href="javascript:void(0)" class="blog-post-info"><i class="icon-line-awesome-clock-o"></i> {{date('D, d M Y', strtotime($promo->created_at))}}</a>
            <div class="row align-items-center pop float-right mt-n2">
              <div class="col-auto d-flex pl-1 pop-target">
                <a href="javascript:void(0)" bg="#3b5998" class="d-block radius-40 text-center square-40 pt-1 mr-1 facebook-btn" title="Share on Facebook" data-tippy-placement="top"><i class="icon-brand-facebook-f font-16 lh-2 text-white"></i></a>
                <a href="https://api.whatsapp.com/send?text={{urlencode(url()->full())}}" target="_blank" bg="#4bc25a" class="d-block radius-40 text-center square-40 pt-1" title="Share on Whatsapp" data-tippy-placement="top"><i class="icon-brand-whatsapp font-16 lh-2 text-white"></i></a>
              </div>
              <div class="col-auto badge-info px-4 py-2 pop-trigger pointer"><i class="icon-feather-share-2"></i> Share</div>
            </div>
          </div>
          <hr>
          {!! $promo->description !!}
        </div>
      </div>
      <!-- FOR SEO GRID -->
      <div class="row my-1">
        <div class="col-6 col-md-3 text-center">
          @include('layouts.ads.square_xs')
        </div>
        <div class="col-6 col-md-3 text-center">
          @include('layouts.ads.square_xs')
        </div>
        <div class="col-6 col-md-3 text-center">
          @include('layouts.ads.square_xs')
        </div>
        <div class="col-6 col-md-3 text-center">
          @include('layouts.ads.square_xs')
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="sidebar-widget">
        <h3 class="mb-0 lh-0">Newest Promo</h3>
        <hr class="mb-0">
        <ul class="widget-tabs">
          <?php foreach ($all_promo as $an): ?>
            <li>
              <a href="{{url('promo')}}/{{$an->promo_id}}" class="widget-content active">
                <img src="{{url('public')}}/images/promo/{{$an->image ?? '../image.png'}}?{{time()}}" alt="">
                <div class="widget-text">
                  <h5>{{$an->title}}</h5>
                  <span>{{date('d M Y', strtotime($promo->created_at))}}</span>
                </div>
              </a>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>
      <!-- FOR SEO GRID -->
      <div class="sidebar-widget text-center">
        @include('layouts.ads.square')
      </div>
      <div class="row">
        <div class="col-12 font-16 text-dark bold">Subscibe For News <hr></div>
        <div class="col-12 mt-2 subscribe-form">
          <div class="input-with-icon-left no-border">
            <i class="icon-material-baseline-mail-outline"></i>
            <input type="text" class="input-text subscribe-input" name="email" placeholder="Email Address" required/>
          </div>
          <button class="button w-100 button-sliding-icon ripple-effect mt-2 subscribe-btn" type="submit" form="add-comment">Subscribe <i class="icon-material-outline-arrow-right-alt"></i></button>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@section('js')
<script type="text/javascript">
  $(document).ready(function() {
    $("#navigation").find('.current').removeClass('current');
    $("#navigation").find('li a[href="{{url("promo")}}"]:first').addClass('current');
  });
</script>
<!-- Facebook Share -->
<script type="text/javascript">
  $(document).on('click', '.facebook-btn',function() {
    var link = 'https://www.facebook.com/sharer?u={{urlencode(url()->full())}}';
    window.open(link, '', "width=1,height=1");
  });
</script>
@endsection
