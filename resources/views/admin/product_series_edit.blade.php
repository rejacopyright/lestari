@extends('layouts.admin')
@section('css')
<link rel="stylesheet" href="{{url('public')}}/select2/select2.min.css">
<link href="{{url('public')}}/summernote/summernote-lite.css" rel="stylesheet">
@endsection
@section('content')
<form class="" action="{{url('admin/product/series/update')}}" method="post" enctype="multipart/form-data">
  @csrf
  <input type="hidden" name="series_id" value="{{$series->series_id}}">
  <div class="container pt-3">
    <div class="row">
      <div class="col-lg-3 text-center">
        <div class="dashboard-box m-0 p-3">
          <div class="avatar-wrapper d-inline-block" data-tippy-placement="bottom" title="Upload Image">
            <div class="w-100 h-100 position-absolute drop d-flex align-items-center" bg="rgba(0,0,0,.5)" style="opacity: 0;">
              <div class="mx-auto text-white font-16">Drop Image Here</div>
            </div>
            <img class="profile-pic" src="{{url('public')}}/images/series/{{$series->image ?? '../add-image.png'}}?{{time()}}" alt="" />
            <div class="upload-button"></div>
            <input class="file-upload" name="image" type="file" accept=".jpg, .png"/>
          </div>
          <div class="mt-2 text-left">
            <select class="select2" name="product_id" required> </select>
          </div>
        </div>
      </div>
      <div class="col-lg-9">
        <div class="dashboard-box m-0 p-3">
          <div class="mb-2">
            <input type="text" class="flat" name="name" placeholder="Series Name" value="{{$series->name}}" required>
          </div>
          <div class="mb-2">
            <textarea name="description" class="flat" rows="8" placeholder="Series Description" required>{{$series->description}}</textarea>
          </div>
          <div class="submit-field mb-2">
            <div class="uploadButton margin-top-30">
              <input class="uploadButton-input" type="file" name="catalog" accept="application/pdf" id="upload" />
              <label class="uploadButton-button ripple-effect" for="upload">{{$series->catalog ? 'Change Catalog' : 'Upload Catalog'}}</label>
              <span class="uploadButton-file-name">{{$series->catalog ?? 'PDF Document is accepted'}}</span>
            </div>
            <div class="switches-list" style="display: {{$series->catalog ? 'unset' : 'none'}};">
              <div class="switch-container">
                <label class="switch"><input type="checkbox" name="download_access" {{$series->download_access ? 'checked' : ''}}><span class="switch-button"></span> Required Login</label>
              </div>
            </div>
          </div>
          <div class="switches-list position-absolute mt-1" style="display: {{$series->catalog ? 'unset' : 'none'}};">
            <div class="switch-container">
              <label class="switch text-danger"><input type="checkbox" name="delete_catalog"><span class="switch-button"></span> Delete Catalog</label>
            </div>
          </div>
          <div class="float-right">
            <a href="{{url()->previous()}}" class="btn btn-light radius-5 px-md-4 mr-2">Back</a>
            <button type="submit" class="btn btn-info radius-5 px-md-4">Process</button>
          </div>
          <div class="clearfix"></div>
        </div>
      </div>
    </div>
  </div>
</form>
@endsection
@section('js')
<script src="{{url('public')}}/select2/select2.min.js"></script>
<script src="{{url('public')}}/summernote/summernote-lite.js"></script>
<!-- MENU -->
<script type="text/javascript">
  $(document).ready(function() {
    $("#navigation").find('.current').removeClass('current');
    $("#navigation").find('li a[href="{{url("admin/product")}}"]:first').addClass('current');
    $("title").text("EDIT SERIES");
  });
</script>
<!-- INIT -->
<script type="text/javascript">
  $(document).ready(function() {
    $(".select2").select2();
    $.get("{{url('ajax_series_detail')}}/{{$series->series_id}}", function(data){
      var product = '<option value="'+data.product.product_id+'" selected>'+(data.product.name).toUpperCase()+'</option>';
      $("select[name='product_id']").html(product);
    });
    // PRODUCT
    $("select[name='product_id']").select2({
      'placeholder': 'Choose Product',
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
  });
</script>
<!-- DOWNLOAD ACCESS -->
<script type="text/javascript">
  $("input[name='catalog']").on('change', function() {
    $(".switches-list").fadeIn();
  });
  $("input[name='delete_catalog']").on('change', function() {
    if ($(this).is(':checked')) {
      $(".submit-field").fadeOut(200);
    }else {
      $(".submit-field").fadeIn();
    }
  });
</script>
<!-- DRAG & DROP -->
<script type="text/javascript">
  $(document).on('dragover', 'body', function(e) {
    e.preventDefault();
    e.stopPropagation();
    $('.drop').css('opacity', 1);
  });
  $(document).on('drop', 'body', function(e) {
    e.preventDefault();
    e.stopPropagation();
    var dt = e.originalEvent.dataTransfer;
    var files = dt.files;
    if (dt.files.length > 0) {
      var file = dt.files[0];
      // SHOW IMG
      var reader = new FileReader();
      reader.onload = function(e){
        var dataURL = e.target.result;
        $('.avatar-wrapper').find('img').attr('src', dataURL);
        // console.log(dataURL);
      };
      reader.readAsDataURL(file);
      // FORM
      var formData = new FormData();
      formData.append('_token', '{{csrf_token()}}');
      formData.append('image', file);
      formData.append('series_id', '{{$series->series_id}}');
      $.ajax({
        url: "{{url('admin/product/series/update')}}",
        type: 'POST',
        contentType:false,
        cache: false,
        processData: false,
        data: formData
      });
    }
    $('.drop').css('opacity', 0);
  });
</script>
@endsection
