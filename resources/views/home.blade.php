@extends('layouts.user')
@section('title') LESTARI ELECTRIC @endsection
@section('css')
<meta http-equiv="Content-Language" content="id" />
<meta property="og:title" content="LESTARI ELECTRIC"/>
<meta property="og:description" content="LESTARI ELECTRIC"/>
<meta name="description" content="LESTARI ELECTRIC"/>
<meta property="og:type" content="image/jpeg"/>
<meta property="og:url" content="{{url()->full()}}"/>
<meta property="og:site_name" content="{{url('/')}}"/>
@endsection
@section('content')
<?php function limit($a, $b){ $arr = explode(' ', $a); if (count($arr) <= $b) { $dot = ""; }else { $dot = "..."; } $limit = implode(' ', array_slice($arr,0,$b)); return $limit.$dot; } ?>
<!-- WHATSAPP -->
<div class="position-fixed r-1 b-1 pointer z-999">
  <a href="https://api.whatsapp.com/send?phone=62{{ltrim(App\setting::first()->whatsapp, '0')}}" target="_blank" class="btn square-50 radius-50" bg="#4bc25a" data-tippy-placement="left" title="Ask Something"><i class="icon-brand-whatsapp text-white font-24 lh-13"></i></a>
</div>
<div class="row mb-3 mx-0">
  <div class="col-12 p-0">
    <div class="your-class">
      <?php foreach ($banner as $bn): ?>
        <img src="{{url('public')}}/images/banner/{{$bn->image}}?{{time()}}" alt="">
      <?php endforeach; ?>
    </div>
  </div>
</div>
<div class="row mx-0 align-items-center mt-2 mb-3"> <div class="col"><hr/></div> <div class="col-auto"><h4 class="badge-warning px-5">BRAND</h4></div> <div class="col"><hr/></div> </div>
<div class="row mx-4">
  <?php foreach ($brand as $br): ?>
    <div class="col-lg-1 col-md-2 col-6 text-center mb-3 mx-auto">
      <div class="shadow-xs card p-2 pointer" onclick="window.location.href = '{{url("product")}}?brand_id={{$br->brand_id}}'" data-tippy-placement="top" title="{{ucwords($br->name)}}<hr class='m-0'>{{$br->product->count()}} Products">
        <img src="{{url('public')}}/images/brand/{{$br->image ?? '../image.png'}}?{{time()}}" class="p-s4">
        <!-- <p class="badge-info my-2 text-uppercase">{{$br->name}}</p> -->
      </div>
    </div>
  <?php endforeach; ?>
</div>
<div class="section gray mt-2 pt-5 pb-0">
  <div class="container">
    <div class="row">
      <?php foreach ($type as $tp): ?>
        <div class="col-lg text-center mb-3 mx-auto">
          <a href="{{url('product')}}?type_id={{$tp->type_id}}" class="photo-box small" data-background-image="{{url('public')}}/images/type/{{$tp->image ?? '../image.png'}}?{{time()}}">
            <div class="photo-box-content">
              <h3>{{$tp->name}}</h3>
              <span>{{$tp->product->count()}} Products</span>
            </div>
          </a>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</div>
<div class="row mx-0 align-items-center my-4"> <div class="col"><hr/></div> <div class="col-auto"><h4 class="badge-warning px-5">NEWS AND PROMOTIONS</h4></div> <div class="col"><hr/></div> </div>
<div class="row mx-md-4 mx-2">
  <!-- NEWS -->
  <div class="col-md-8">
    <div class="section-headline mt-0 mb-2">
      <h4 class="text-info"> <i class="icon-line-awesome-info"></i> News</h4>
      <a href="{{url('news')}}" class="headline-link">All News</a>
    </div>
    <hr>
    <div class="listings-container compact-list-layout shadow-none">
      <!-- FOR SEO Feed 2 -->
      <div class="job-listing with-apply-button p-0">
        @include('layouts.ads.feed')
      </div>
      <?php foreach ($news as $nw): ?>
        <a href="{{url('news')}}/{{$nw->news_id}}" class="job-listing with-apply-button py-3 px-md-4 px-0">
          <div class="job-listing-details align-items-start">
            <div class="wpx-100 mr-md-4 mr-2">
              <img src="{{url('public')}}/images/news/{{$nw->image ?? '../image.png'}}?{{time()}}" alt="">
            </div>
            <div class="job-listing-description pt-0">
              <h4 class="job-listing-title bold text-info lh-12"><u>{{limit($nw->title, 8)}}</u></h4>
              <div class="job-listing-footer">
                <ul>
                  <li class="text-success"><small>{{date('D, d M Y', strtotime($nw->created_at))}}</small></li>
                </ul>
              </div>
              {{limit(strip_tags($nw->description), 15)}}
            </div>
            <span class="list-apply-button ripple-effect d-none d-md-block">See News</span>
          </div>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
  <!-- PROMO -->
  <div class="col-md-4 bg-white">
    <div class="boxed-list">
      <div class="boxed-list-headline p-2">
        <h5 class="bold d-flex align-items-center">
          <div class="col">
            <i class="icon-feather-shopping-bag text-dark"></i> Newest Promotion
          </div>
          <div class="col-auto">
            <a href="{{url('promo')}}" class="btn btn-sm btn-light radius-5 text-info">See All Promo</a>
          </div>
        </h5>
      </div>
      <ul class="boxed-list-ul">
        <!-- FOR SEO Horizontal -->
        <li class="py-1 px-0">
          @include('layouts.ads.feed')
        </li>
        <?php foreach ($promo as $pr): ?>
          <li class="py-3 px-1">
            <a class="boxed-list-item" href="{{url('promo')}}/{{$pr->promo_id}}">
              <div class="wpx-100 my-auto mx-2 d-flex align-items-center hpx-50 oh">
                <img src="{{url('public')}}/images/promo/{{$pr->image ?? '../image.png'}}?{{time()}}" alt="">
              </div>
              <div class="item-content">
                <h5 class="m-0 lh-12 bold">{{ucwords(limit($pr->title, 8))}}</h5>
                <div class="item-details">
                  <small class="detail-item"><i class="icon-material-outline-date-range"></i> May 2019 - Present</small>
                </div>
                <div class="item-description mt-1">
                  {{limit(strip_tags($pr->description), 8)}}
                </div>
              </div>
            </a>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
  </div>
</div>
<!-- FOR SEO Horizontal -->
<div class="row m-0 mt-3">
  <div class="col-12 text-center">
    @include('layouts.ads.horizontal')
  </div>
</div>
@endsection
@section('js')
<!-- SLIDER -->
<script type="text/javascript">
  $(document).ready(function() {
    $('.your-class').slick({
      autoplay: false,
      centerMode: true,
  	  centerPadding: '10%',
  	  slidesToShow: 1,
  	  dots: false,
  	  arrows: true,
  	  adaptiveHeight: false,
      responsive: [
  		{
  		  breakpoint: 1600,
  		  settings: {
  			  centerPadding: '12%',
  			  slidesToShow: 1,
  		  }
  		},
  		{
  		  breakpoint: 993,
  		  settings: {
  		    centerPadding: '10%',
  		    slidesToShow: 1,
  		  }
  		},
  		{
  		  breakpoint: 769,
  		  settings: {
  		    centerPadding: '5%',
  		    arrows: false
  		  }
  		}
  	  ]
    });
    $(".slick-prev").css('left', 'calc(20% - 25px)');
    $(".slick-next").css('right', 'calc(20% - 25px)');
  });
</script>
@endsection
