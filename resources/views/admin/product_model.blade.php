@extends('layouts.admin')
@section('css')
<link rel="stylesheet" href="{{url('public')}}/select2/select2.min.css">
@endsection
@section('content')
<?php
 function limit($a, $b){ $arr = explode(' ', $a); if (count($arr) <= $b) { $dot = ""; }else { $dot = "..."; } $limit = implode(' ', array_slice($arr,0,$b)); return $limit.$dot; }
 ?>
<div class="px-5 pt-3">
  <div class="row">
    <div class="col-lg-3 section gray py-3">
      <div class="input-with-icon-left no-border">
        <i class="icon-material-outline-search"></i>
        <input type="text" name="search" id="product-search" class="input-text" placeholder="Search Series Model">
      </div>
      <div class="mt-2 text-left">
        <select class="select2" id="product-product" name="product_id"> </select>
      </div>
      <div class="mt-2 text-left">
        <select class="select2" id="product-series" name="series_id"> </select>
      </div>
    </div>
    <div class="col-lg-9">
      <div class="row">
        <div class="col-12" id="product-list">
          <table class="basic-table table-bordered-bottom">
            <tr>
              <th></th>
              <th>Name</th>
              <th>Brand</th>
              <th>Product</th>
              <th>Series</th>
              <th class="text-right"><a class="badge-info pointer mr-2 popup-with-zoom-anim" href="#model-add"><i class="icon-line-awesome-plus mr-1"></i>Add model</a></th>
            </tr>
            <?php foreach ($model as $mdl): ?>
              <tr>
                <td>
                  <div class="square-50">
                    <img src="{{url('public')}}/images/model/{{$mdl->image ?? '../image.png'}}?{{time()}}" class="border border-2 radius-10 p-1 dash h-100 w-auto">
                  </div>
                </td>
                <td class="text-nowrap">
                  <p class="m-0 bold text-capitalize">{{limit($mdl->name, 3)}}</p>
                  <!-- <small class="m-0 text-capitalize bold text-danger">{{limit($mdl->series->name, 3)}}</small> -->
                </td>
                <td><span class="badge-info text-uppercase font-10 bold">{{$mdl->series->product->brand->name ?? 'OTHER'}}</span></td>
                <td class="text-uppercase bold text-info font-10">{{limit($mdl->series->product->name, 3)}}</td>
                <td class="text-uppercase bold text-warning font-10">{{$mdl->series->name ?? 'OTHER'}}</td>
                <td class="text-right text-nowrap">
                  <a href="{{url('admin/product/spec')}}?product_id={{$mdl->series->product->product_id}}&series_id={{$mdl->series->series_id}}&model_id={{$mdl->model_id}}" class="badge-info px-3 pointer radius-5 mr-1">Spec</a>
                  <span class="badge-warning pointer mr-1 icon-line-awesome-pencil py-2 radius-20 popup-with-zoom-anim" href="#model-edit" onclick="edit({{$mdl->model_id}})"></span>
                  <span class="badge-danger pointer mr-1 icon-line-awesome-trash py-2 radius-20 popup-with-zoom-anim" href="#model-delete" onclick="remove({{$mdl->model_id}})"></span>
                </td>
              </tr>
            <?php endforeach; ?>
          </table>
          <div class="float-right mt-2">
            {{$model->appends(['q' => $q, 'product_id' => $product_id, 'series_id' => $series_id])->links()}}
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- MODAL ADD -->
<div id="model-add" class="zoom-anim-dialog mfp-hide dialog-with-tabs modal">
  <h4 class="m-0 pl-3 py-2 text-center bg-gradient text-white">ADD MODEL'S SERIES</h4>
  <div class="popup-tabs-container">
    <div class="popup-tab-content px-2 pb-2 pt-3" id="tab">
      <form class="" action="{{url('admin/product/model/store')}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row">
          <div class="col-12 text-center">
            <div class="avatar-wrapper d-inline-block" data-tippy-placement="top" title="Upload Image">
              <img class="profile-pic" src="{{url('public')}}/images/add-image.png" alt="" />
              <div class="upload-button"></div>
              <input class="file-upload" name="image" type="file" accept=".jpg, .png"/>
            </div>
          </div>
        </div>
        <div class="container mt-3">
          <div class="row mb-2">
            <div class="col-lg-6">
              <select class="select2" name="product_id" style="width: 100%;"> </select>
            </div>
            <div class="col-lg-6">
              <select class="select2" name="series_id" style="width: 100%;" required> </select>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <input type="text" class="flat mb-2" name="name" placeholder="Model Name" required>
              <textarea name="description" class="flat" rows="3" placeholder="Model Description" required></textarea>
            </div>
          </div>
          <hr class="mt-2">
          <div class="row">
            <div class="col-12 text-right">
              <button type="submit" class="btn btn-info radius-5 px-md-4">Proccess</button>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- MODAL EDIT -->
<div id="model-edit" class="zoom-anim-dialog mfp-hide dialog-with-tabs modal">
  <h4 class="m-0 pl-3 py-2 text-center bg-gradient text-white">EDIT MODEL'S SERIES</h4>
  <div class="popup-tabs-container">
    <div class="popup-tab-content px-2 pb-2 pt-3" id="tab">
      <form class="" action="{{url('admin/product/model/update')}}" method="post" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="model_id" value="">
        <div class="row">
          <div class="col-12 text-center">
            <div class="avatar-wrapper d-inline-block" data-tippy-placement="top" title="Upload Image">
              <img class="profile-pic" src="{{url('public')}}/images/add-image.png" alt="" />
              <div class="upload-button"></div>
              <input class="file-upload" name="image" type="file" accept=".jpg, .png"/>
            </div>
          </div>
        </div>
        <div class="container mt-3">
          <div class="row mb-2">
            <div class="col-lg-6">
              <select class="select2" name="product_id" style="width: 100%;"> </select>
            </div>
            <div class="col-lg-6">
              <select class="select2" name="series_id" style="width: 100%;" required> </select>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <input type="text" class="flat mb-2" name="name" placeholder="Model Name" required>
              <textarea name="description" class="flat" rows="3" placeholder="Model Description" required></textarea>
            </div>
          </div>
          <hr class="mt-2">
          <div class="row">
            <div class="col-12 text-right">
              <button type="submit" class="btn btn-info radius-5 px-md-4">Proccess</button>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- MODAL DELETE -->
<div id="model-delete" class="zoom-anim-dialog mfp-hide dialog-with-tabs modal">
  <h4 class="m-0 pl-3 py-2 text-center bg-gradient text-white">DELETE CONFIRMATION</h4>
  <div class="popup-tabs-container">
    <div class="popup-tab-content px-2 pb-2 pt-3" id="tab">
      <form class="" action="{{url('admin/product/model/delete')}}" method="post">
        @csrf
        <input type="hidden" name="model_id" value="">
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
    $("title").text("MODEL");
  });
</script>
<!-- INIT SELECT -->
<script type="text/javascript">
  function exist(){
    var q = '{{$q ?? ''}}';
    var product_id = parseInt('{{$product_id ?? 0}}');
    var series_id = parseInt('{{$series_id ?? 0}}');
    if (q) { $('#product-search').val(q); }
    if (product_id) { $.get('{{url("ajax_product_detail")}}/'+product_id, function(data){ $('#product-product').html('<option value="'+data.product_id+'" selected>'+(data.name).toUpperCase()+'</option>'); }); }
    if (series_id) { $.get('{{url("ajax_series_detail")}}/'+series_id, function(data){ $('#product-series').html('<option value="'+data.series_id+'" selected>'+(data.name).toUpperCase()+'</option>'); }); }
  }
  $(document).ready(function() {
    $(".select2").select2();
    exist();
    // PRODUCT
    $("select[name='product_id']").select2({
      'placeholder': 'All Product',
      ajax: {
        url: "{{url('ajax_product_haschild_select2')}}",
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
        url: "{{url('ajax_series_haschild_select2')}}",
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
<!-- UPPERCASE -->
<script type="text/javascript">
  $(document).on('keyup change', '#form-ms input[type="text"]', function(e) {
    var $this = $(e.target);
    $this.val($this.val().toUpperCase());
  });
</script>
<!-- ON CHANGE -->
<script type="text/javascript">
  // MAIN
  $(document).on('change', '#product-product', function(e) {
    var product_id = $(e.target).val();
    $("#product-series").html('');
    $("#product-series").select2({
      'placeholder': 'All Series',
      ajax: {
        url: "{{url('ajax_series_haschild_select2')}}?product_id="+product_id,
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
  // MODAL ADD
  $(document).on('change', '#model-add select[name="product_id"]', function(e) {
    var $this = $(e.target);
    var product_id = $(e.target).val();
    $("#model-add select[name='series_id']").html('');
    $("#model-add select[name='series_id']").select2({
      'placeholder': 'All Series',
      ajax: {
        url: "{{url('ajax_series_haschild_select2')}}?product_id="+product_id,
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
  // MODAL EDIT
  $(document).on('change', '#model-edit select[name="product_id"]', function(e) {
    var $this = $(e.target);
    var product_id = $(e.target).val();
    $("#model-edit select[name='series_id']").html('');
    $("#model-edit select[name='series_id']").select2({
      'placeholder': 'All Series',
      ajax: {
        url: "{{url('ajax_series_haschild_select2')}}?product_id="+product_id,
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
    var series_id = $('#product-series').val() || '';
    history.replaceState({},'','{{url()->current()}}?q='+q+'&product_id='+product_id+'&series_id='+series_id);
    $.get("{{url()->current()}}", {
      q: q,
      product_id: product_id,
      series_id: series_id,
    }, function(data){
      var html = $($.parseHTML(data));
      var item = html.find("#product-list").html();
      $("#product-list").html(item);
    });
  }
  $(document).on('keyup change', '#product-search', function(e) {
    query();
  });
  $(document).on('change', '#product-product, #product-series', function(e) {
    query();
  });
</script>
<!-- EDIT -->
<script type="text/javascript">
  function edit(model_id){
    $.get("{{url('ajax_model_detail')}}/"+model_id, function(data){
      if (data.image) { var img = "{{url('public')}}/images/model/"+data.image+'?'+new Date(); }else { var img = "{{url('public')}}/images/image.png"; }
      $("#model-edit").find('.profile-pic').attr('src', img);
      $("#model-edit").find('input[name="model_id"]').val(data.model_id);
      $("#model-edit").find('input[name="name"]').val(data.name);
      $("#model-edit").find('textarea[name="description"]').val(data.description);
      var product_id = data.product.product_id;
      $.get('{{url("ajax_product_detail")}}/'+data.product.product_id, function(data){ $('#model-edit').find('select[name="product_id"]').html('<option value="'+data.product_id+'" selected>'+(data.name).toUpperCase()+'</option>'); });
      $.get('{{url("ajax_series_detail")}}/'+data.series.series_id, function(data){
        $('#model-edit').find('select[name="series_id"]').html('<option value="'+data.series_id+'" selected>'+(data.name).toUpperCase()+'</option>');
        $('#model-edit').find('select[name="series_id"]').select2({
          'placeholder': 'All Series',
          ajax: {
            url: "{{url('ajax_series_haschild_select2')}}?product_id="+product_id,
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
    });
  }
</script>
<!-- DELETE -->
<script type="text/javascript">
  function remove(model_id){
    $("#model-delete").find('input[name="model_id"]').val(model_id);
    $.get("{{url('ajax_model_detail')}}/"+model_id, function(data){
      var delete_title = '<p class="bold">Are you sure want to delete this Model ?</p>';
      $("#delete-title").html(delete_title);
    });
  }
</script>
@endsection
