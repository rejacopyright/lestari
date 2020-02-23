@extends('layouts.user')
@section('title') {{$brand_name}} @endsection
@section('css')
<meta http-equiv="Content-Language" content="id" />
<meta property="og:title" content="{{$brand_name}}"/>
<meta property="og:description" content="{{$brand_name}}"/>
<meta name="description" content="{{$brand_name}}"/>
<meta property="og:type" content="image/jpeg"/>
<meta property="og:url" content="{{url()->full()}}"/>
<meta property="og:site_name" content="{{url('/')}}"/>
<link rel="stylesheet" href="{{url('public')}}/select2/select2.min.css">
@endsection
@section('content')
<div class="container pt-3">
  <!-- WHATSAPP -->
  <div class="position-fixed r-1 b-1 pointer z-999">
    <a href="https://api.whatsapp.com/send?phone=62{{ltrim(App\setting::first()->whatsapp, '0')}}" target="_blank" class="btn square-50 radius-50" bg="#4bc25a" data-tippy-placement="left" title="Ask Something"><i class="icon-brand-whatsapp text-white font-24 lh-13"></i></a>
  </div>
  <div class="row">
    <div class="col-lg-3 section gray py-3">
      <div class="input-with-icon-left no-border">
        <i class="icon-material-outline-search"></i>
        <input type="text" name="search" id="product-search" class="input-text" placeholder="Search product">
      </div>
      <div class="mt-2 text-left">
        <select class="select2" id="product-type" name="type_id"> </select>
      </div>
      <div class="mt-2 text-left">
        <select class="select2" id="product-brand" name="brand_id"> </select>
      </div>
      <!-- FOR SEO GRID -->
      <div class="mt-3 text-center">
        @include('layouts.ads.square')
      </div>
    </div>
    <div class="col-lg-9" id="product-list">
      <div class="row">
        <?php foreach ($product as $prod): ?>
          <div class="col-md-3 col-sm-4 col-6 text-center mb-3">
            <div class="card p-2 pointer shadow-xs" onclick="window.location.href = '{{url('product')}}/detail/{{$prod->product_id}}'" data-tippy-placement="bottom" title="{{$prod->name}}<hr class='m-0'>{{$prod->brand->name ?? 'OTHER'}}">
              <img src="{{url('public')}}/images/products/{{$prod->image ?? '../image.png'}}?{{time()}}" class="w-75">
              <p class="text-dark mt-2 mb-0 text-capitalize text-truncate bold font-16">{{$prod->name}}</p>
              <p class="text-warning m-0 text-capitalize text-truncate bold font-12"><strong class="badge-info font-10">{{$prod->brand->name ?? 'OTHER'}}</strong></p>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
      <div class="float-right mt-2">
        {{$product->appends(['q' => $q, 'type_id' => $type_id, 'brand_id' => $brand_id])->links()}}
      </div>
      <div class="clearfix"></div>
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
@endsection
@section('js')
<script src="{{url('public')}}/select2/select2.min.js"></script>
<!-- MENU -->
<script type="text/javascript">
  $(document).ready(function() {
    $("#navigation").find('.current').removeClass('current');
    $("#navigation").find('li>a.product-li').addClass('current');
  });
</script>
<!-- INIT SELECT -->
<script type="text/javascript">
  function exist(){
    var q = '{{$q ?? ''}}';
    var type_id = parseInt('{{$type_id ?? 0}}');
    var brand_id = parseInt('{{$brand_id ?? 0}}');
    if (q) { $('#product-search').val(q); }
    if (type_id) { $.get('{{url("ajax_type_detail")}}', {type_id:type_id}, function(data){ $('#product-type').html('<option value="'+data.type_id+'" selected>'+(data.name).toUpperCase()+'</option>'); }); }
    if (brand_id) { $.get('{{url("ajax_brand_detail")}}', {brand_id:brand_id}, function(data){ $('#product-brand').html('<option value="'+data.brand_id+'" selected>'+(data.name).toUpperCase()+'</option>'); }); }
  }
  $(document).ready(function() {
    $(".select2").select2();
    exist();
    // TYPE
    $("select[name='type_id']").select2({
      'placeholder': 'All Type',
      ajax: {
        url: "{{url('ajax_type_select2?all=true')}}",
        dataType: 'json',
        processResults: function (data, params) {
          params.page = params.page || 1;
          return {
            results: data,
            "pagination": {
              more: (params.page) < (data.length + 1)
            }
          };
        },
        cache: false
      }
    });
    // BRAND
    $("select[name='brand_id']").select2({
      'placeholder': 'All Brand',
      ajax: {
        url: "{{url('ajax_brand_select2?all=true')}}",
        dataType: 'json',
        processResults: function (data, params) {
          params.page = params.page || 1;
          return {
            results: data,
            "pagination": {
              more: (params.page) < (data.length + 1)
            }
          };
        },
        cache: false
      }
    });
  });
</script>
<!-- PAGINATION -->
<script type="text/javascript">
  $(document).on('click', '#product-list li.page-item:not(".disabled")', function(event) {
    event.preventDefault();
    var url = $(this).find("a:first").attr("href");
    window.history.replaceState({},"",url);
    $.get(url, function(data){
      var html = $($.parseHTML(data));
      var item = html.find("#product-list").html();
      $("#product-list").html(item);
    });
  });
</script>
<!-- SEARCH -->
<script type="text/javascript">
  function query(){
    var q = $('#product-search').val() || '';
    var type_id = $('#product-type').val() || '';
    var brand_id = $('#product-brand').val() || '';
    history.replaceState({},'','{{url()->current()}}?q='+q+'&type_id='+type_id+'&brand_id='+brand_id);
    $.get("{{url()->current()}}", {
      q: q,
      type_id: type_id,
      brand_id: brand_id,
    }, function(data){
      var html = $($.parseHTML(data));
      var item = html.find("#product-list").html();
      $("#product-list").html(item);
    });
  }
  $(document).on('keyup change', '#product-search', function(e) { query(); });
  $(document).on('change', '#product-type, #product-brand', function(e) { query(); });
  $(document).on('change', '#product-brand', function(e) {
    if (parseInt($(e.target).val())) {
      $('title').text($(e.target).find(":selected").text());
    }else {
      $('title').text("PRODUCTS");
    }
  });
</script>
@endsection
