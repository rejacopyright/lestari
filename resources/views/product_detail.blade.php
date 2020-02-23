@extends('layouts.user')
@section('title') {{strtoupper($product->brand->name)}} {{strtoupper($product->name)}} @endsection
@section('css')
<meta http-equiv="Content-Language" content="id" />
<meta property="og:title" content="{{strtoupper($product->name)}}"/>
<meta property="og:description" content="Brand : {{strtoupper($product->brand->name ?? 'OTHER')}}"/>
<meta name="description" content="Brand : {{strtoupper($product->brand->name ?? 'OTHER')}}"/>
<meta property="og:type" content="image/jpeg"/>
<meta property="og:url" content="{{url()->full()}}"/>
<meta property="og:site_name" content="{{url('/')}}"/>
<meta property="og:image" itemprop="image" content="{{url('public')}}/images/products/{{$product->image ?? '../add-image.png'}}?{{time()}}"/>
<meta property="og:image:secure_url" content="{{url('public')}}/images/products/{{$product->image ?? '../add-image.png'}}?{{time()}}"/>
<meta property="og:image:width" content="400" />
<meta property="og:image:height" content="400" />
<meta property="og:image:alt" content="{{$product->name}}" />
@endsection
@section('content')
<?php
 function limit($a, $b){ $arr = explode(' ', $a); if (count($arr) <= $b) { $dot = ""; }else { $dot = "..."; } $limit = implode(' ', array_slice($arr,0,$b)); return $limit.$dot; }
 ?>
<div class="containers px-5 mt-3">
  <div class="row">
    <div class="col-lg-3">
      <div class="d-flex align-items-center hpx-200">
        <img src="{{url('public')}}/images/products/{{$product->image ?? '../image.png'}}?{{time()}}" class="h-100 p-2 mx-auto">
      </div>
      <h5 class="text-center m-0 bg-gray py-2 bold text-uppercase">{{$product->name}}</h5>
      <div class="mt-2">
        <?php if ($product->catalog): ?>
          <?php if (($product->download_access && auth::user()) || !$product->download_access): ?>
            <a href="{{url('public')}}/images/catalog/{{$product->catalog}}" target="_blank" class="btn btn-info btn-block w-100 ripple-effect text-white font-12 py-2">Download Catalog</a>
          <?php else: ?>
            <span class="btn bg-light btn-block text-secondary font-12 py-2 no-drop" data-tippy-placement="bottom" title="Login Required">Download Catalog</span>
          <?php endif; ?>
        <?php endif; ?>
      </div>
      <div class="mt-2">
        <a href="{{url('product/spec')}}?product_id={{$product->product_id}}" class="btn btn-block btn-info-light radius-5 mt-1"><i class=""></i>Find Specification</a>
      </div>
      <div class="mt-2">
        <a href="{{url('product')}}?brand_id={{$product->brand_id}}" class="btn btn-block btn-light radius-5 mt-1"><i class="icon-line-awesome-undo mr-1"></i>Back</a>
      </div>
    </div>
    <div class="col-lg-9">
      <div class="tabs">
				<div class="tabs-header">
					<ul>
						<li><a href="#tab-1" data-tab-id="1">Description</a></li>
						<li class="active"><a href="#tab-3" data-tab-id="2">Series</a></li>
					</ul>
					<div class="tab-hover"></div>
					<nav class="tabs-nav"> <span class="tab-prev"><i class="icon-material-outline-keyboard-arrow-left"></i></span> <span class="tab-next"><i class="icon-material-outline-keyboard-arrow-right"></i></span> </nav>
				</div>
				<!-- Tab Content -->
				<div class="tabs-content">
					<div class="tab" data-tab-id="1">
            {{$product->description}}
					</div>
					<div class="tab active pt-2" data-tab-id="2">
            <?php if ($series->count()): ?>
              <div class="input-with-icon-left no-border mb-3">
                <i class="icon-material-outline-search"></i>
                <input type="text" name="search" id="series-search" class="input-text" placeholder="Search Product Series">
              </div>
              <div id="series-list">
                <div class="row">
                  <?php foreach ($series as $sr): ?>
                    <?php
                     if ($sr->product->brand->child) {
                       $href = url('product/series').'/'.$sr->series_id;
                     }else {
                       $href = url('product/spec').'?product_id='.$product->product_id.'&series_id='.$sr->series_id;
                     }
                     ?>
                    <div class="col-md-2 col-sm-4 col-6 text-center mb-3">
                      <div class="card p-2 pointer shadow-xs" data-tippy-placement="top" title="{{$sr->name}}" onclick="window.location.href = '{{$href}}'">
                        <img src="{{url('public')}}/images/series/{{$sr->image ?? '../image.png'}}?{{time()}}" class="w-75">
                        <p class="text-dark my-2 text-uppercase font-10 bold text-truncate">{{$sr->name}}</p>
                      </div>
                    </div>
                  <?php endforeach; ?>
                </div>
                <div class="row">
                  <div class="col-12">
                    {{$series->links()}}
                  </div>
                </div>
              </div>
            <?php else: ?>
              <div class="border border-2 dash radius-10 hpx-75 d-flex align-items-center">
                <p class="w-100 text-center text-muted m-0">No Product Series</p>
              </div>
            <?php endif; ?>
					</div>
				</div>
			</div>
      <!-- FOR SEO GRID -->
      <div class="row mt-3">
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
  </div>
</div>
<!-- WHATSAPP -->
<div class="position-fixed r-1 b-1 pointer z-999">
  <div class="pop">
    <div class="pop-target">
      <a href="javascript:void(0)" bg="#3b5998" class="btn square-50 radius-50 mb-2 facebook-btn" title="Share on Facebook" data-tippy-placement="left"><i class="icon-brand-facebook-f font-16 lh-2 text-white"></i></a>
      <br>
      <a href="https://api.whatsapp.com/send?text={{urlencode(url()->full())}}" target="_blank" bg="#4bc25a" class="btn square-50 radius-50 mb-2 pt-1" title="Share on Whatsapp" data-tippy-placement="left"><i class="icon-brand-whatsapp font-20 lh-2 text-white"></i></a>
    </div>
    <div class="btn square-50 radius-50 mb-2 pop-trigger" bg="#ddd"><i class="icon-feather-share-2 text-success font-24 lh-13"></i></div>
  </div>
  <a href="https://api.whatsapp.com/send?phone={{$whatsapp}}&text={{urlencode(url()->full())}}" target="_blank" class="btn square-50 radius-50" bg="#4bc25a" data-tippy-placement="left" title="Ask Something"><i class="icon-brand-whatsapp text-white font-24 lh-13"></i></a>
</div>
@endsection
@section('js')
<!-- MENU -->
<script type="text/javascript">
  $(document).ready(function() {
    $("#navigation").find('.current').removeClass('current');
    $("#navigation").find('li>a.product-li').addClass('current');
  });
</script>
<!-- PAGINATION -->
<script type="text/javascript">
  $(document).on('click', '#series-list li.page-item:not(".disabled")', function(event) {
    event.preventDefault();
    var url = $(this).find("a:first").attr("href");
    window.history.replaceState({},"",url);
    $.get(url, function(data){
      var html = $($.parseHTML(data));
      var item = html.find("#series-list").html();
      $("#series-list").html(item);
    });
  });
</script>
<!-- SEARCH -->
<script type="text/javascript">
  function query(){
    var q = $('#series-search').val() || '';
    history.replaceState({},'','{{url()->current()}}?q='+q);
    $.get("{{url()->current()}}", {
      q: q,
    }, function(data){
      var html = $($.parseHTML(data));
      var item = html.find("#series-list").html();
      $("#series-list").html(item);
    });
  }
  $(document).on('keyup change', '#series-search', function(e) {
    query();
  });
  $(document).on('change', '#product-series', function(e) {
    query();
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
