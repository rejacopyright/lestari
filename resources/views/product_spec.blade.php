@extends('layouts.user')
@section('title')
{{strtoupper($product->brand->name)}}
{{strtoupper($product->name)}}
{{$series_id ? ' '.strtoupper(App\product_series::where('series_id', $series_id)->first()->name) : ''}}
@endsection
@section('css')
<meta http-equiv="Content-Language" content="id" />
<meta property="og:title" content="{{strtoupper($product->name)}}"/>
<meta property="og:description" content="{{strtoupper($product->name)}}"/>
<meta name="description" content="{{strtoupper($product->name)}}"/>
<meta property="og:type" content="image/jpeg"/>
<meta property="og:url" content="{{url()->full()}}"/>
<meta property="og:site_name" content="{{url('/')}}"/>
<link rel="stylesheet" href="{{url('public')}}/select2/select2.min.css">
@endsection
@section('content')
<div class="px-4 pt-3">
  <!-- WHATSAPP -->
  <div class="position-fixed r-1 b-1 pointer z-999">
    <a href="https://api.whatsapp.com/send?phone=62{{ltrim(App\setting::first()->whatsapp, '0')}}" target="_blank" class="btn square-50 radius-50" bg="#4bc25a" data-tippy-placement="left" title="Ask Something"><i class="icon-brand-whatsapp text-white font-24 lh-13"></i></a>
  </div>
  <div class="row">
    <div class="col-lg-3 section gray py-3">
      <div class="product-image border border-2 radius-10 dash p-2 d-block text-center">
        <img class="hpx-100 shadow-xs radius-10 card" src="{{url('public')}}/images/series/{{$series->image ?? '../products/'.$product->image ?? '../image.png'}}?{{time()}}" alt="" />
      </div>
      <div class="mt-2 text-left">
        <p class="mt-0 mb-1 text-info bold">Choose Product</p>
        <select class="select2" id="product-product" name="product_id"> </select>
      </div>
      <div class="mt-3 text-left">
        <p class="mt-0 mb-1 text-info bold">Filter by Series</p>
        <select class="select2" id="product-series" name="series_id"> </select>
      </div>
      <div class="mt-3 text-left model-row" style="display: none;">
        <p class="mt-0 mb-1 text-info bold">Filter by Model</p>
        <select class="select2" id="product-model" name="model_id" style="width: 100%;"> </select>
      </div>
      <div class="mt-3 text-left" id="spec-filter">
        <p class="mt-0 mb-1 text-info bold">Filter by Specification</p>
        <?php foreach ($ms as $master): ?>
          <?php $value = $master->value()->where('product_id', $product_id)->get(); ?>
          <?php if ($value->count()): ?>
            <p class="bold text-dark mt-2 mb-0">{{$master->name}}</p>
          <?php endif; ?>
          <div class="row">
            <?php foreach ($value->unique('ms_value') as $vl): ?>
              <div class="checkbox-small mt-1 col-auto">
                <input type="checkbox" class="ck-vl" name="vl_value[]" value="{{$vl->ms_value}}" id="ck-{{$vl->id}}">
                <label class="font-12 bold" for="ck-{{$vl->id}}"><span class="checkbox-icon"></span>{{ucwords(strtolower($vl->ms_value))}}</label>
              </div>
            <?php endforeach; ?>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
    <div class="col-lg-9" id="product-list">
      <div class="row">
        <?php foreach ($spec as $spc): ?>
          <div class="col-md-2 col-sm-4 col-6 text-center mb-3">
            <div class="card p-2 pointer shadow-xs" onclick="window.location.href = '{{url('product')}}/spec/detail/{{$spc->spec_id}}'" data-tippy-placement="bottom" title="{{$spc->name}}<hr class='m-0'>{{ $spc->description }}<hr class='m-0'>{{$spc->series->product->name ?? 'OTHER'}}<hr class='m-0'>{{$spc->series->name ?? 'OTHER'}}">
              <img src="{{url('public')}}/images/spec/{{$spc->image ?? '../series/'.$spc->series->image ?? '../products/'.$spc->series->product->image ?? '../image.png'}}?{{time()}}" class="w-75">
              <p class="text-dark mt-2 mb-0 text-capitalize text-truncate bold font-14">{{$spc->name}}</p>
              <p class="text-warning m-0 text-capitalize text-truncate bold font-12">{{$spc->series->product->name}}</p>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
      <div class="float-right mt-2">
        {{$spec->appends(['q' => $q, 'product_id' => $product_id, 'series_id' => $series_id, 'model_id' => $model_id])->links()}}
      </div>
      <div class="clearfix"></div>
      <!-- FOR SEO GRID -->
      <div class="row mt-3">
        <div class="col-md-8 offset-md-2">
          <div class="row">
            <div class="col-4 text-center">
              @include('layouts.ads.square_xs')
            </div>
            <div class="col-4 text-center">
              @include('layouts.ads.square_xs')
            </div>
            <div class="col-4 text-center">
              @include('layouts.ads.square_xs')
            </div>
          </div>
          <div class="row mt-2">
            <div class="col-4 text-center">
              @include('layouts.ads.square_xs')
            </div>
            <div class="col-4 text-center">
              @include('layouts.ads.square_xs')
            </div>
            <div class="col-4 text-center">
              @include('layouts.ads.square_xs')
            </div>
          </div>
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
    var product_id = parseInt('{{$product_id ?? 0}}');
    var series_id = parseInt('{{$series_id ?? 0}}');
    var model_id = parseInt('{{$model_id ?? 0}}');
    if (product_id) { $.get('{{url("ajax_product_detail")}}/'+product_id, function(data){ $('#product-product').html('<option value="'+data.product_id+'" selected>'+(data.name).toUpperCase()+'</option>'); }); }
    if (series_id) { $.get('{{url("ajax_series_detail")}}/'+series_id, function(data){ $('#product-series').html('<option value="'+data.series_id+'" selected>'+(data.name).toUpperCase()+'</option>'); }); }
    if (model_id) { $.get('{{url("ajax_model_detail")}}/'+model_id, function(data){ $('#product-model').html('<option value="'+data.model_id+'" selected>'+(data.name).toUpperCase()+'</option>'); }); }
  }
  $(document).ready(function() {
    $(".select2").select2();
    exist();
    // PRODUCT
    $("select[name='product_id']").select2({
      'placeholder': 'All Product',
      ajax: {
        url: "{{url('ajax_product_select2')}}",
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
    // SERIES
    $("select[name='series_id']").select2({
      'placeholder': 'All Series',
      ajax: {
        url: "{{url('ajax_series_select2?all=true')}}&product_id={{$product_id}}",
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
    // MODEL
    if ("{{$series_id}}") {
      $.get("{{url('ajax_series_ishaschild')}}/{{$series_id}}", function(data){
        if (data.child) {
          $(".model-row").show();
        }else {
          $(".model-row").hide();
        }
      });
    }
    // if ("{{$model_id}}") { $(".model-row").show(); }else { $(".model-row").hide(); }
    $("select[name='model_id']").select2({
      'placeholder': 'ALL MODELS',
      ajax: {
        url: "{{url('ajax_model_select2?all=true')}}&series_id={{$series_id}}",
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
<!-- ON CHANGE -->
<script type="text/javascript">
  $(document).on('change', '#product-product', function(e) {
    var product_id = $(e.target).val();
    $("#product-series").html('');
    $("#product-series").select2({
      'placeholder': 'All Series',
      ajax: {
        url: "{{url('ajax_series_select2')}}?all=true&product_id="+product_id,
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
    $("#product-model").html('');
    $(".model-row").hide();
  });
  $(document).on('change', '#product-series', function(e) {
    var series_id = $(e.target).val();
    if (!parseInt(series_id)) {
      $(".model-row").hide();
    }
    $("#product-model").html('');
    $("#product-model").select2({
      'placeholder': 'ALL MODELS',
      ajax: {
        url: "{{url('ajax_model_select2')}}?all=true&series_id="+series_id,
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
    $.get("{{url('ajax_series_ishaschild')}}/"+series_id, function(data){
      if (data.child) {
        $(".model-row").show();
      }else {
        $(".model-row").hide();
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
  function query(e){
    var product_id = $('#product-product').val() || '';
    var series_id = $('#product-series').val() || '';
    var model_id = $('#product-model').val() || '';
    var value = $(".ck-vl:checked").get().map(function(i){ return $(i).val(); });
    var check = $(e.target).hasClass('ck-vl');
    history.replaceState({},'','{{url()->current()}}?&product_id='+product_id+'&series_id='+series_id+'&model_id='+model_id);
    $.get("{{url()->current()}}", {
      product_id: product_id,
      series_id: series_id,
      model_id: model_id,
      value: value,
    }, function(data){
      var html = $($.parseHTML(data));
      var item = html.find("#product-list").html();
      var img = html.find(".product-image").html();
      $("#product-list").html(item);
      $(".product-image").html(img);
      if (!check) {
        var spec_filter = html.find("#spec-filter").html();
        $("#spec-filter").html(spec_filter);
      }
    });
    $.get("{{url('ajax_product_detail')}}/"+product_id, function(data){
      $('title').text(data.brand.name+' '+data.name.toUpperCase());
      if (series_id) {
        $.get("{{url('ajax_series_detail')}}/"+series_id, function(data){
          $('title').append(' ' + data.name.toUpperCase());
        });
      }
    });
  }
  $(document).on('keyup change', '#product-search', function(e) { query(e); });
  $(document).on('change', '#product-product, #product-series, #product-model',function(e) { query(e); });
  $(document).on('change', '.ck-vl', function(e) {
    query(e);
  });
</script>
@endsection
