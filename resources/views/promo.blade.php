@extends('layouts.user')
@section('title') PROMO @endsection
@section('css')
@endsection
@section('content')
<?php
 function limit($a, $b){ $arr = explode(' ', $a); if (count($arr) <= $b) { $dot = ""; }else { $dot = "..."; } $limit = implode(' ', array_slice($arr,0,$b)); return $limit.$dot; }
 ?>
<div class="container mt-1">
  <!-- WHATSAPP -->
  <div class="position-fixed r-1 b-1 pointer z-999">
    <a href="https://api.whatsapp.com/send?phone=62{{ltrim(App\setting::first()->whatsapp, '0')}}" target="_blank" class="btn square-50 radius-50" bg="#4bc25a" data-tippy-placement="left" title="Ask Something"><i class="icon-brand-whatsapp text-white font-24 lh-13"></i></a>
  </div>
  <div class="row my-3">
    <div class="col-12">
      <div class="input-with-icon">
        <input id="promo-search" type="text" placeholder="Search Promo Here">
        <i class="icon-material-outline-search"></i>
      </div>
    </div>
  </div>
  <div class="row mt-4" id="promo-list">
    <?php foreach ($promo as $pr): ?>
      <div class="col-lg-4">
        <a href="{{url('promo')}}/{{$pr->promo_id}}" class="blog-compact-item-container">
          <div class="blog-compact-item">
            <img src="{{url('public')}}/images/promo/{{$pr->image ?? '../image.png'}}?{{time()}}" alt="">
            <div class="blog-compact-item-content">
              <ul class="blog-post-tags">
                <li>{{date('d M Y', strtotime($pr->created_at))}}</li>
              </ul>
              <h3>{{limit($pr->title, 8)}}</h3>
              <p>{{limit(strip_tags($pr->description), 10)}}</p>
            </div>
          </div>
        </a>
      </div>
    <?php endforeach; ?>
    <div class="col-12 text-center">
      {{$promo->appends(['q' => $q])->links()}}
    </div>
  </div>
  <!-- FOR SEO GRID -->
  <div class="row mt-3">
    <div class="col-4 col-md-2 mb-2 text-center">
      @include('layouts.ads.square_xs')
    </div>
    <div class="col-4 col-md-2 mb-2 text-center">
      @include('layouts.ads.square_xs')
    </div>
    <div class="col-4 col-md-2 mb-2 text-center">
      @include('layouts.ads.square_xs')
    </div>
    <div class="col-4 col-md-2 mb-2 text-center">
      @include('layouts.ads.square_xs')
    </div>
    <div class="col-4 col-md-2 mb-2 text-center">
      @include('layouts.ads.square_xs')
    </div>
    <div class="col-4 col-md-2 mb-2 text-center">
      @include('layouts.ads.square_xs')
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
<!-- PAGINATION -->
<script type="text/javascript">
  $(document).on('click', '#promo-list li.page-item:not(".disabled")', function(event) {
    event.preventDefault();
    var url = $(this).find("a:first").attr("href");
    window.history.replaceState({},"",url);
    $.get(url, function(data){
      var html = $($.parseHTML(data));
      var item = html.find("#promo-list").html();
      $("#promo-list").html(item);
      $('html, body').animate({
        scrollTop: $("body").offset().top
      }, 200);
    });
  });
</script>
<!-- SEARCH -->
<script type="text/javascript">
  $(document).on('keyup change', '#promo-search', function(e) {
    var val = $(e.target).val();
    $.get("{{url()->current()}}", {
      q:val
    }, function(data){
      var html = $($.parseHTML(data));
      var item = html.find("#promo-list").html();
      $("#promo-list").html(item);
    });
  });
</script>
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
  			  centerPadding: '20%',
  			  slidesToShow: 1,
  		  }
  		},
  		{
  		  breakpoint: 993,
  		  settings: {
  		    centerPadding: '15%',
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
