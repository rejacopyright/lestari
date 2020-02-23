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
        <input type="text" name="search" id="product-search" class="input-text" placeholder="Search Series Spec">
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
              <th>Product</th>
              <th>Type</th>
              <th>Brand</th>
              <th class="text-right"><a class="badge-info pointer mr-2 popup-with-zoom-anim" href="#spec-add"><i class="icon-line-awesome-plus mr-1"></i>Add spec</a></th>
            </tr>
            <?php foreach ($spec as $spc): ?>
              <tr>
                <td>
                  <div class="square-50">
                    <img src="{{url('public')}}/images/spec/{{$spc->image ?? '../image.png'}}?{{time()}}" class="border border-2 radius-10 p-1 dash h-100 w-auto">
                  </div>
                </td>
                <td class="text-nowrap">
                  <p class="m-0 bold text-capitalize">{{limit($spc->name, 3)}}</p>
                  <small class="m-0 text-capitalize bold text-danger">{{limit($spc->series->name, 3)}}</small>
                </td>
                <td class="text-uppercase bold text-info font-10">{{limit($spc->series->product->name, 3)}}</td>
                <td class="text-uppercase bold text-warning font-10">{{$spc->series->product->type->name ?? 'OTHER'}}</td>
                <td><span class="badge-info text-uppercase font-10 bold">{{$spc->series->product->brand->name ?? 'OTHER'}}</span></td>
                <td class="text-right text-nowrap">
                  <span class="badge-info pointer mr-1 icon-material-outline-settings py-2 radius-20 popup-with-zoom-anim" href="#spec-value" onclick="value({{$spc->spec_id}})"></span>
                  <span class="badge-warning pointer mr-1 icon-line-awesome-pencil py-2 radius-20 popup-with-zoom-anim" href="#spec-edit" onclick="edit({{$spc->spec_id}})"></span>
                  <span class="badge-danger pointer mr-1 icon-line-awesome-trash py-2 radius-20 popup-with-zoom-anim" href="#spec-delete" onclick="remove({{$spc->spec_id}})"></span>
                </td>
              </tr>
            <?php endforeach; ?>
          </table>
          <div class="float-right mt-2">
            {{$spec->appends(['q' => $q, 'product_id' => $product_id, 'series_id' => $series_id, 'model_id' => $model_id])->links()}}
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- MODAL ADD -->
<div id="spec-add" class="zoom-anim-dialog mfp-hide dialog-with-tabs modal">
  <h4 class="m-0 pl-3 py-2 text-center bg-gradient text-white">ADD SPECIFICATION'S SERIES</h4>
  <div class="popup-tabs-container">
    <div class="popup-tab-content px-2 pb-2 pt-3" id="tab">
      <form class="" action="{{url('admin/product/spec/store')}}" method="post" enctype="multipart/form-data">
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
          <div class="row mb-2 model-row" style="display: none;">
            <div class="col-lg-6 text-right pt-2 pr-0"> Model : </div>
            <div class="col-lg-6">
              <select class="select2" name="model_id" style="width: 100%;"> </select>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <input type="text" class="flat mb-2" name="name" placeholder="Part Number" required>
              <textarea name="description" class="flat" rows="3" placeholder="Spec Description" required></textarea>
            </div>
          </div>
          <div class="row mt-2">
            <div class="col-12">
              <div class="submit-field mb-0">
                <div class="uploadButton margin-top-30">
                  <input class="uploadButton-input" type="file" name="catalog" accept="application/pdf" id="upload" />
                  <label class="uploadButton-button ripple-effect" for="upload">Upload Catalog</label>
                  <span class="uploadButton-file-name">PDF Document is accepted</span>
                </div>
                <div class="switches-list" style="display: none;">
          				<div class="switch-container">
          					<label class="switch"><input type="checkbox" name="download_access"><span class="switch-button"></span> Required Login</label>
          				</div>
          			</div>
              </div>
              <div class="switches-list mt-1" style="display: none;">
                <div class="switch-container">
                  <label class="switch text-danger"><input type="checkbox" name="delete_catalog"><span class="switch-button"></span> Delete Catalog</label>
                </div>
              </div>
            </div>
          </div>
          <hr class="mt-0">
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
<div id="spec-edit" class="zoom-anim-dialog mfp-hide dialog-with-tabs modal">
  <h4 class="m-0 pl-3 py-2 text-center bg-gradient text-white">EDIT SPECIFICATION'S SERIES</h4>
  <div class="popup-tabs-container">
    <div class="popup-tab-content px-2 pb-2 pt-3" id="tab">
      <form class="" action="{{url('admin/product/spec/update')}}" method="post" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="spec_id" value="">
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
          <div class="row mb-2 model-row" style="display: none;">
            <div class="col-lg-6 text-right pt-2 pr-0"> Model : </div>
            <div class="col-lg-6">
              <select class="select2" name="model_id" style="width: 100%;"> </select>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <input type="text" class="flat mb-2" name="name" placeholder="Series Name" required>
              <textarea name="description" class="flat" rows="3" placeholder="Spec Description" required></textarea>
            </div>
          </div>
          <div class="row mt-2">
            <div class="col-12">
              <div class="submit-field mb-0">
                <div class="uploadButton margin-top-30">
                  <input class="uploadButton-input" type="file" name="catalog" accept="application/pdf" id="upload" />
                  <label class="uploadButton-button ripple-effect" for="upload">Upload Catalog</label>
                  <span class="uploadButton-file-name">PDF Document is accepted</span>
                </div>
                <div class="switches-list" style="display: none;">
          				<div class="switch-container">
          					<label class="switch"><input type="checkbox" name="download_access"><span class="switch-button"></span> Required Login</label>
          				</div>
          			</div>
              </div>
              <div class="switches-list mt-1" style="display: none;">
                <div class="switch-container">
                  <label class="switch text-danger"><input type="checkbox" name="delete_catalog"><span class="switch-button"></span> Delete Catalog</label>
                </div>
              </div>
            </div>
          </div>
          <hr class="mt-0">
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
<div id="spec-delete" class="zoom-anim-dialog mfp-hide dialog-with-tabs modal">
  <h4 class="m-0 pl-3 py-2 text-center bg-gradient text-white">DELETE CONFIRMATION</h4>
  <div class="popup-tabs-container">
    <div class="popup-tab-content px-2 pb-2 pt-3" id="tab">
      <form class="" action="{{url('admin/product/spec/delete')}}" method="post">
        @csrf
        <input type="hidden" name="spec_id" value="">
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
<!-- MODAL MS VALUE -->
<div id="spec-value" class="zoom-anim-dialog mfp-hide dialog-with-tabs modal">
  <h4 class="m-0 pl-3 py-2 text-center bg-gradient text-white">EDIT SPECIFICATION VALUES</h4>
  <div class="popup-tabs-container">
    <div class="popup-tab-content px-2 pb-2 pt-3" id="tab">
      <form class="px-3" action="{{url('admin/product/spec/value')}}" method="post" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="spec_id" value="">
        <input type="hidden" name="product_id" value="">
        <div id="form-ms"></div>
        <div class="row">
          <div class="col-12 text-right">
            <button type="submit" class="btn btn-info px-3">Update</button>
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
    $("title").text("SPECIFICATION");
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
    // SERIES
    $("select[name='series_id']").select2({
      'placeholder': 'All Series',
      ajax: {
        url: "{{url('ajax_series_select2')}}",
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
  // MODEL
  function hideModel(){
    $(".model-row").hide();
    $(".model-row").find('select[name="model_id"]').prop('required', false).prop('disabled', true);
    $(".model-row").find('select[name="model_id"]').html('');
  }
  function showModel(seriesId){
    $(".model-row").show();
    $(".model-row").find('select[name="model_id"]').prop('required', true).prop('disabled', false);
    $(".model-row").find('select[name="model_id"]').html('');
    $(".model-row").find("select[name='model_id']").select2({
      'placeholder': 'All Model',
      ajax: {
        url: "{{url('ajax_model_select2')}}?series_id="+seriesId,
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
  }
  $.magnificPopup.instance.close = function () {
    $("#spec-add select[name='product_id'], #spec-add select[name='series_id']").html('');
    hideModel();
    $.magnificPopup.proto.close.call(this);
  };
  // MAIN
  $(document).on('change', '#product-product', function(e) {
    var product_id = $(e.target).val();
    $("#product-series").html('');
    $("#product-series").select2({
      'placeholder': 'All Series',
      ajax: {
        url: "{{url('ajax_series_select2')}}?product_id="+product_id,
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
  $(document).on('change', '#spec-add select[name="product_id"]', function(e) {
    hideModel();
    var $this = $(e.target);
    var product_id = $(e.target).val();
    $("#spec-add select[name='series_id']").html('');
    $("#spec-add select[name='series_id']").select2({
      'placeholder': 'All Series',
      ajax: {
        url: "{{url('ajax_series_select2')}}?product_id="+product_id,
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
  $(document).on('change', '#spec-add select[name="series_id"]', function(e) {
    var $this = $(e.target);
    var series_id = $(e.target).val();
    $.get("{{url('ajax_series_ishaschild')}}/"+series_id, function(data){
      if (data.child) {
        showModel(data.series_id);
      }else {
        hideModel();
      }
    });
  });
  // MODAL EDIT
  $(document).on('change', '#spec-edit select[name="product_id"]', function(e) {
    var $this = $(e.target);
    var product_id = $(e.target).val();
    $("#spec-edit select[name='series_id']").html('');
    $("#spec-edit select[name='series_id']").select2({
      'placeholder': 'All Series',
      ajax: {
        url: "{{url('ajax_series_select2')}}?product_id="+product_id,
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
  $(document).on('change', '#spec-edit select[name="series_id"]', function(e) {
    var $this = $(e.target);
    var series_id = $(e.target).val();
    console.log(series_id, 'xxx');
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
<!-- DOWNLOAD ACCESS - MODAL ADD -->
<script type="text/javascript">
  $(document).on('change', '#spec-add input[name="catalog"]', function(e) {
    var div = $(e.target).closest('.submit-field').parent();
    div.find(".switches-list").fadeIn();
  });
  $(document).on('change', '#spec-add input[name="delete_catalog"]', function(e) {
    var $this = $(e.target);
    if ($this.is(':checked')) {
      $(".submit-field").fadeOut(200);
    }else {
      $(".submit-field").fadeIn();
    }
  });
</script>
<!-- DOWNLOAD ACCESS - MODAL EDIT -->
<script type="text/javascript">
  $(document).on('change', '#spec-edit input[name="catalog"]', function(e) {
    var div = $(e.target).closest('.submit-field').parent();
    div.find(".switches-list").fadeIn();
  });
  $(document).on('change', '#spec-edit input[name="delete_catalog"]', function(e) {
    var $this = $(e.target);
    if ($this.is(':checked')) {
      $(".submit-field").fadeOut(200);
    }else {
      $(".submit-field").fadeIn();
    }
  });
</script>
<!-- EDIT -->
<script type="text/javascript">
  function edit(spec_id){
    $.get("{{url('ajax_spec_detail')}}/"+spec_id, function(data){
      if (data.brand.child) {
        if (data.model_id) {
          $.get('{{url("ajax_model_detail")}}/'+data.model_id, function(data){
            $('#spec-edit').find('select[name="model_id"]').html('<option value="'+data.model_id+'" selected>'+(data.name).toUpperCase()+'</option>');
          });
        }
        showModel(data.series.series_id);
      }else {
        hideModel();
      }
      if (data.image) { var img = "{{url('public')}}/images/spec/"+data.image+'?'+new Date(); }else { var img = "{{url('public')}}/images/image.png"; }
      $("#spec-edit").find('.profile-pic').attr('src', img);
      $("#spec-edit").find('input[name="spec_id"]').val(data.spec_id);
      $("#spec-edit").find('input[name="name"]').val(data.name);
      $("#spec-edit").find('textarea[name="description"]').val(data.description);
      var product_id = data.product.product_id;
      $.get('{{url("ajax_product_detail")}}/'+data.product.product_id, function(data){ $('#spec-edit').find('select[name="product_id"]').html('<option value="'+data.product_id+'" selected>'+(data.name).toUpperCase()+'</option>'); });
      $.get('{{url("ajax_series_detail")}}/'+data.series.series_id, function(data){
        $('#spec-edit').find('select[name="series_id"]').html('<option value="'+data.series_id+'" selected>'+(data.name).toUpperCase()+'</option>');
        $('#spec-edit').find('select[name="series_id"]').select2({
          'placeholder': 'All Series',
          ajax: {
            url: "{{url('ajax_series_select2')}}?product_id="+product_id,
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
      if (data.catalog) {
        $("#spec-edit").find('.uploadButton-button').text('Change Catalog');
        $("#spec-edit").find('.uploadButton-file-name').text(data.catalog);
        $("#spec-edit").find('.switches-list').show();
        if (data.download_access) {
          $("#spec-edit").find('input[name="download_access"]').prop('checked', true);
        }else {
          $("#spec-edit").find('input[name="download_access"]').prop('checked', false);
        }
      }else {
        $("#spec-edit").find('.uploadButton-button').text('Upload Catalog');
        $("#spec-edit").find('.uploadButton-file-name').text('PDF Document is accepted');
        $("#spec-edit").find('.switches-list').hide();
      }
    });
  }
</script>
<!-- DELETE -->
<script type="text/javascript">
  function remove(spec_id){
    $("#spec-delete").find('input[name="spec_id"]').val(spec_id);
    $.get("{{url('ajax_spec_detail')}}/"+spec_id, function(data){
      var delete_title = '<p class="bold">Are you sure want to delete this Spec ?</p>';
      $("#delete-title").html(delete_title);
    });
  }
</script>
<!-- MS VALUE -->
<script type="text/javascript">
  function value(spec_id){
    $.get("{{url('ajax_spec_detail')}}/"+spec_id, function(data){
      $("#spec-value").find('input[name="spec_id"]').val(data.spec_id);
      $("#spec-value").find('input[name="product_id"]').val(data.product.product_id);
      var ms = '';
      for (var i = 0; i < data.ms.length; i++) {
        ms +=
        '<div class="row">'+
          '<div class="col-auto">'+
            '<div class="checkbox mt-1">'+
              '<input type="checkbox" class="ck-ms" name="ms_name[]" value="'+data.ms[i].ms_id+'" id="ck-'+data.ms[i].ms_id+'">'+
              '<label for="ck-'+data.ms[i].ms_id+'"><span class="checkbox-icon"></span>'+data.ms[i].name+'</label>'+
            '</div>'+
          '</div>'+
          '<div class="col">'+
            '<input type="text" class="flat" name="ms_value[]" placeholder="Value" required disabled>'+
          '</div>'+
        '</div>';
      }
      $("#form-ms").html(ms);
      $(document).ready(function() {
        $.get("{{url('ajax_spec_value')}}/"+spec_id, function(data){
          for (var i = 0; i < data.length; i++) {
            $("#form-ms").find('#ck-'+data[i].ms_id).prop('checked', true);
            $("#form-ms").find('#ck-'+data[i].ms_id).closest('.row').find('input[name="ms_value[]"]').prop('disabled', false).val(data[i].ms_value);
          }
        });
      });
    });
  }
  $(document).on('change', '.ck-ms', function(e) {
    var $this = $(e.target);
    if ($this.is(':checked')) {
      $this.closest('.row').find('input[name="ms_value[]"]').prop('disabled', false).focus();
    }else {
      $this.closest('.row').find('input[name="ms_value[]"]').prop('disabled', true);
    }
    console.log($this.is(':checked'));
  });
</script>
@endsection
