@extends('layouts.admin')
@section('css')
<link rel="stylesheet" href="{{url('public')}}/select2/select2.min.css">
@endsection
@section('content')
<?php
 function limit($a, $b){ $arr = explode(' ', $a); if (count($arr) <= $b) { $dot = ""; }else { $dot = "..."; } $limit = implode(' ', array_slice($arr,0,$b)); return $limit.$dot; }
 ?>
<div class="container pt-3">
  <div class="row">
    <div class="col-lg-3 section gray py-3">
      <div class="input-with-icon-left no-border">
        <i class="icon-material-outline-search"></i>
        <input type="text" name="search" id="product-search" class="input-text" placeholder="Search Product Series">
      </div>
      <div class="mt-2 text-left">
        <select class="select2" id="product-product" name="product_id"> </select>
      </div>
      <div class="mt-2 text-left">
        <select class="select2" id="product-type" name="type_id"> </select>
      </div>
      <div class="mt-2 text-left">
        <select class="select2" id="product-brand" name="brand_id"> </select>
      </div>
    </div>
    <div class="col-lg-9">
      <div class="row">
        <div class="col-12" id="product-list">
          <table class="basic-table table-bordered-bottom">
            <tr>
              <th></th>
              <th>Name</th>
              <th>Type</th>
              <th>Brand</th>
              <th class="text-right"><a href="{{url('admin/product/series/add')}}" class="badge-info pointer mr-2"><i class="icon-line-awesome-plus mr-1"></i>Add Series</a></th>
            </tr>
            <?php foreach ($series as $sr): ?>
              <tr>
                <td>
                  <div class="square-50">
                    <img src="{{url('public')}}/images/series/{{$sr->image ?? '../image.png'}}?{{time()}}" class="border border-2 radius-10 p-1 dash h-100 w-auto">
                  </div>
                </td>
                <td class="text-nowrap" data-tippy-placement="top" title="{{ucwords($sr->name)}}">
                  <p class="m-0 bold text-capitalize">{{limit($sr->name, 5)}}</p>
                  <small class="m-0 text-capitalize bold text-danger">{{$sr->product->name}}</small>
                </td>
                <td class="text-uppercase bold text-warning font-12">{{$sr->product->type->name ?? 'OTHER'}}</td>
                <td><span class="badge-info text-uppercase">{{$sr->product->brand->name ?? 'OTHER'}}</span></td>
                <td class="text-right text-nowrap">
                  <?php if ($sr->product->brand->child): ?>
                    <a href="{{url('admin/product/model')}}?product_id={{$sr->product->product_id}}&series_id={{$sr->series_id}}" class="badge-success pointer radius-5 mr-1">Model</a>
                  <?php else: ?>
                    <a href="{{url('admin/product/spec')}}?product_id={{$sr->product->product_id}}&series_id={{$sr->series_id}}" class="badge-info pointer radius-5 mr-1">Spec</a>
                  <?php endif; ?>
                  <a href="{{url('admin/product/series/edit')}}/{{$sr->series_id}}" class="badge-warning pointer radius-5 mr-1 icon-line-awesome-pencil py-2 radius-20"></a>
                  <a href="#series-delete" class="badge-danger pointer radius-5 icon-line-awesome-trash py-2 radius-20 popup-with-zoom-anim" onclick="remove({{$sr->series_id}})"></a>
                </td>
              </tr>
            <?php endforeach; ?>
          </table>
          <div class="float-right mt-2">
            {{$series->appends(['q' => $q, 'type_id' => $type_id, 'brand_id' => $brand_id, 'product_id' => $product_id])->links()}}
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- MODAL DELETE -->
<div id="series-delete" class="zoom-anim-dialog mfp-hide dialog-with-tabs modal">
  <h4 class="m-0 pl-3 py-2 text-center bg-gradient text-white">DELETE CONFIRMATION</h4>
  <div class="popup-tabs-container">
    <div class="popup-tab-content px-2 pb-2 pt-3" id="tab">
      <form class="" action="{{url('admin/product/series/delete')}}" method="post">
        @csrf
        <input type="hidden" name="series_id" value="">
        <div class="container">
          <div class="row">
            <div class="col-12 text-center" id="delete-title"> </div>
          </div>
          <hr class="my-2">
          <div class="row">
            <div class="col-12 text-right">
              <button type="submit" class="btn btn-danger radius-5 px-md-4">Delete</button>
            </div>
          </div>
        </div>
      </form>
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
    $("#navigation").find('li a[href="{{url("admin/product")}}"]:first').addClass('current');
    $("title").text("SERIES");
  });
</script>
<!-- INIT SELECT -->
<script type="text/javascript">
  function exist(){
    var q = '{{$q ?? ''}}';
    var product_id = parseInt('{{$product_id ?? 0}}');
    var type_id = parseInt('{{$type_id ?? 0}}');
    var brand_id = parseInt('{{$brand_id ?? 0}}');
    if (q) { $('#product-search').val(q); }
    if (product_id) { $.get('{{url("ajax_product_detail")}}/'+product_id, function(data){ $('#product-product').html('<option value="'+data.product_id+'" selected>'+(data.name).toUpperCase()+'</option>'); }); }
    if (type_id) { $.get('{{url("ajax_type_detail")}}', {type_id:type_id}, function(data){ $('#product-type').html('<option value="'+data.type_id+'" selected>'+(data.name).toUpperCase()+'</option>'); }); }
    if (brand_id) { $.get('{{url("ajax_brand_detail")}}', {brand_id:brand_id}, function(data){ $('#product-brand').html('<option value="'+data.brand_id+'" selected>'+(data.name).toUpperCase()+'</option>'); }); }
  }
  $(document).on('click', '.popup-with-zoom-anim', function(e) {
    var $this = $(e.target);
    $.magnificPopup.instance._onFocusIn = function(e) {
      return true;
    };
    $.magnificPopup.open({
      items: { src: $this.attr('href') },
      type: 'inline',
      fixedContentPos: false,
      fixedBgPos: true,
      overflowY: 'auto',
      closeBtnInside: true,
      preloader: false,
      midClick: true,
      removalDelay: 300,
      mainClass: 'my-mfp-zoom-in'
    });
  });
  $(document).ready(function() {
    $(".select2").select2();
    exist();
    // PRODUCT
    $("select[name='product_id']").select2({
      'placeholder': 'All Product',
      ajax: {
        url: "{{url('ajax_product_select2?all=true')}}",
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
  $(document).on('click', '.popup-with-zoom-anim', function(e) {
    var $this = $(e.target);
    $.magnificPopup.open({
      items: { src: $this.attr('href') },
      type: 'inline',
      fixedContentPos: false,
      fixedBgPos: true,
      overflowY: 'auto',
      closeBtnInside: true,
      preloader: false,
      midClick: true,
      removalDelay: 300,
      mainClass: 'my-mfp-zoom-in'
    });
  });
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
    var product_id = $('#product-product').val() || '';
    var type_id = $('#product-type').val() || '';
    var brand_id = $('#product-brand').val() || '';
    history.replaceState({},'','{{url()->current()}}?q='+q+'&product_id='+product_id+'&type_id='+type_id+'&brand_id='+brand_id);
    $.get("{{url()->current()}}", {
      q: q,
      product_id: product_id,
      type_id: type_id,
      brand_id: brand_id,
    }, function(data){
      var html = $($.parseHTML(data));
      var item = html.find("#product-list").html();
      $("#product-list").html(item);
    });
  }
  $(document).on('keyup change', '#product-search', function(e) {
    query();
  });
  $(document).on('change', '#product-product, #product-type, #product-brand', function(e) {
    query();
  });
</script>
<!-- DELETE -->
<script type="text/javascript">
  function remove(series_id){
    $("#series-delete").find('input[name="series_id"]').val(series_id);
    $.get("{{url('ajax_series_detail')}}/"+series_id, function(data){
      console.log(data);
      var delete_title = 'This Series has <strong class="text-danger">'+data.spec.length+' Specification</strong>. <p>Are you sure want to delete this Series ?</p>';
      $("#delete-title").html(delete_title);
    });
  }
</script>
@endsection
