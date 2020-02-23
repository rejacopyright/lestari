@extends('layouts.user')
@section('css')
@endsection
@section('content')
<?php
 function limit($a, $b){ $arr = explode(' ', $a); if (count($arr) <= $b) { $dot = ""; }else { $dot = "..."; } $limit = implode(' ', array_slice($arr,0,$b)); return $limit.$dot; }
 ?>
<!-- <div class="container">
  <div class="row">
    <div class="col-xl-12">
      <div class="blog-carousel">
        <?php for ($i=1; $i < 4; $i++): ?>
          <a href="#" class="blog-compact-item-container">
            <div class="blog-compact-item">
              <img src="{{url('public')}}/images/samples/p-{{$i}}.png" alt="">
              <div class="blog-compact-item-content">
                <ul class="blog-post-tags">
                  <li>20 Dec 2019</li>
                </ul>
                <h3>Prevent Job Seekers from Overcoming</h3>
                <p>Distinctively reengineer revolutionary meta-services and premium.</p>
              </div>
            </div>
          </a>
        <?php endfor; ?>
      </div>
    </div>
  </div>
</div> -->
<div class="container">
  <div class="row my-3">
    <div class="col-md-8">
      <div class="input-with-icon">
        <input id="news-search" type="text" placeholder="Search News Here">
        <i class="icon-material-outline-search"></i>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-8 listings-container compact-list-layout shadow-none" id="news-list">
      <?php foreach ($news as $nw): ?>
        <a href="{{url('news')}}/{{$nw->news_id}}" class="job-listing with-apply-button py-3 px-4">
          <div class="job-listing-details">
            <div class="wpx-100 mr-4">
              <img src="{{url('public')}}/images/news/{{$nw->image ?? '../image.png'}}?{{time()}}" alt="">
            </div>
            <div class="job-listing-description">
              <h4 class="job-listing-title bold text-info"><u>{{limit($nw->title, 8)}}</u></h4>
              {{limit(strip_tags($nw->description), 15)}}
              <div class="job-listing-footer">
                <ul>
                  <li><i class="icon-line-awesome-clock-o"></i> <small>{{date('d-m-Y', strtotime($nw->created_at))}}</small></li>
                </ul>
              </div>
            </div>
          </div>
        </a>
        <!-- <a href="{{url('news')}}/{{$nw->news_id}}" class="blog-post mb-3">
          <div class="blog-post-thumbnail">
            <div class="blog-post-thumbnail-inner">
              <img src="{{url('public')}}/images/news/{{$nw->image ?? '../image.png'}}?{{time()}}" alt="">
            </div>
          </div>
          <div class="blog-post-content">
            <span class="blog-post-date">{{date('d M Y', strtotime($nw->created_at))}}</span>
            <h3>{{$nw->title}}</h3>
            {{limit(strip_tags($nw->description), 10)}}
          </div>
          <div class="entry-icon"></div>
        </a> -->
      <?php endforeach; ?>
      <div class="clearfix"></div>
      <div class="row">
        <div class="col-md-12 text-right">
          {{$news->appends(['q' => $q])->links()}}
        </div>
      </div>
    </div>
    <div class="col-md-4 content-left-offset">
      <div class="sidebar-container">
        <!-- Widget -->
        <div class="sidebar-widget">
          <h3 class="mb-0">New Promo</h3>
          <ul class="widget-tabs">
            <?php foreach ($promo as $pr): ?>
              <li>
                <a href="{{url('promo')}}/{{$pr->promo_id}}" class="widget-content">
                  <img src="{{url('public')}}/images/promo/{{$pr->image ?? '../image.png'}}?{{time()}}" alt="">
                  <div class="widget-text">
                    <h5>{{limit($pr->title, 9)}}</h5>
                    <span>{{date('d M Y', strtotime($pr->created_at))}}</span>
                  </div>
                </a>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>
        <!-- Widget -->
        <div class="sidebar-widget">
          <h3>Social Profiles</h3>
          <div class="freelancer-socials margin-top-25">
            <ul>
              <li><a href="{{$setting->facebook ?? 'javascript:void(0)'}}" target="_blank" title="Facebook" data-tippy-placement="top"><i class="icon-brand-facebook"></i></a></li>
              <li><a href="{{$setting->twitter ?? 'javascript:void(0)'}}" target="_blank" title="Twitter" data-tippy-placement="top"><i class="icon-brand-twitter"></i></a></li>
              <li><a href="{{$setting->instagram ?? 'javascript:void(0)'}}" target="_blank" title="Instagram" data-tippy-placement="top"><i class="icon-brand-instagram"></i></a></li>
              <li><a href="{{$setting->youtube ?? 'javascript:void(0)'}}" target="_blank" title="Youtube" data-tippy-placement="top"><i class="icon-brand-youtube"></i></a></li>
            </ul>
          </div>
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
    $("#navigation").find('li a[href="{{url("news")}}"]:first').addClass('current');
    $('title').text("NEWS");
    $('.widget-tabs').find('li:first a.widget-content').addClass('active');
  });
</script>
<!-- PAGINATION -->
<script type="text/javascript">
  $(document).on('click', '#news-list li.page-item:not(".disabled")', function(event) {
    event.preventDefault();
    var url = $(this).find("a:first").attr("href");
    window.history.replaceState({},"",url);
    $.get(url, function(data){
      var html = $($.parseHTML(data));
      var item = html.find("#news-list").html();
      $("#news-list").html(item);
    });
  });
</script>
<!-- SEARCH -->
<script type="text/javascript">
  $(document).on('keyup change', '#news-search', function(e) {
    var val = $(e.target).val();
    $.get("{{url()->current()}}", {
      q:val
    }, function(data){
      var html = $($.parseHTML(data));
      var item = html.find("#news-list").html();
      $("#news-list").html(item);
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
