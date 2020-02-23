@extends('layouts.admin')
@section('css')
<link rel="stylesheet" href="{{url('public')}}/select2/select2.min.css">
<link href="{{url('public')}}/summernote/summernote-lite.css" rel="stylesheet">
@endsection
@section('content')
<form class="" action="{{url('admin/product/series/store')}}" method="post" enctype="multipart/form-data">
  @csrf
  <div class="container pt-3">
    <div class="row">
      <div class="col-lg-3 text-center">
        <div class="dashboard-box m-0 p-3">
          <div class="avatar-wrapper d-inline-block" data-tippy-placement="bottom" title="Upload Image">
            <img class="profile-pic" src="{{url('public')}}/images/add-image.png" alt="" />
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
            <input type="text" class="flat" name="name" placeholder="Series Name" required>
          </div>
          <div class="mb-2">
            <textarea name="description" class="flat" rows="8" placeholder="Series Description" required></textarea>
          </div>
          <div class="submit-field mb-2">
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
          <div class="switches-list position-absolute mt-1" style="display: none;">
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
    $("title").text("ADD SERIES");
  });
</script>
<!-- INIT -->
<script type="text/javascript">
  $(document).ready(function() {
    $(".select2").select2();
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
@endsection
