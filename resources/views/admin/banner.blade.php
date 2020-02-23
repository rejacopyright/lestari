@extends('layouts.admin')
@section('css')
<link href="{{url('public/cropper')}}/cropper.css" rel="stylesheet">
<link href="{{url('public/cropper')}}/main.css" rel="stylesheet">
@endsection
@section('content')
<?php
  function limit($a, $b){ $limit = ucfirst(implode(' ', array_slice(explode(' ', $a),0,$b))); if (count(explode(' ', $a)) <= $b) { $dot = ""; }else { $dot = "..."; } return $limit.$dot; }
?>
<a href="#add" onclick="add()" class="btn px-4 py-3 bg-white shadow-md radius-30 position-fixed add-main r-1 b-5 text-info z-50 lh-0 popup-with-zoom-anim"> <i class="icon-feather-plus mr-2 font-14 border radius-20 border-info"></i> Add Banner </a>
<div class="container pt-3" id="banner-list">
  <div class="row el-element-overlay">
    <?php foreach ($banner as $bn): ?>
      <div class="col-md-4 col-6 item mb-3">
        <div class="card radius-10 shadow-xs">
          <div class="d-flex align-items-center oh pointer">
            <img class="w-100" src="{{url('public')}}/images/banner/{{$bn->image}}?{{time()}}">
          </div>
          <div class="card-body py-2 px-2">
            <?php if ($bn->link): ?>
              <h6 class="card-title text-truncate mb-1 text-capitalize">Banner Link</h6>
            <?php endif; ?>
            <div class="d-flex align-items-center">
              <div class="switches-list">
                <div class="switch-container w-auto">
                  <label class="switch text-info"><input type="checkbox" class="input-switch" data-banner-id="{{$bn->banner_id}}" {{$bn->status ? 'checked' : ''}}><span class="switch-button"></span>Aktif</label>
                </div>
              </div>
              <div class="w-100 text-right">
                <span class="badge-warning pointer mr-1 icon-line-awesome-pencil py-2 radius-20 popup-with-zoom-anim" href="#add" onclick="edit({{$bn->banner_id}})"></span>
                <span class="badge-danger pointer mr-1 icon-line-awesome-trash py-2 radius-20 popup-with-zoom-anim" href="#delete" onclick="remove({{$bn->banner_id}})"></span>
              </div>
            </div>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
  <div class="row mt-1">
    <div class="col-12 text-right">{{$banner->links()}}</div>
  </div>
</div>
<!-- MODAL ADD BANNER -->
<div id="add" class="zoom-anim-dialog mfp-hide dialog-with-tabs modal">
  <h4 class="m-0 pl-3 py-2 text-center bg-gradient text-white">Update Banner</h4>
  <div class="popup-tabs-container">
    <div class="popup-tab-content px-0 pb-0 pt-4" id="tab">
      <form id="add-form"  action="{{url('admin/master/banner/store')}}" method="post">
          @csrf
          <input type="hidden" name="type" value="home">
          <input type="hidden" name="banner_id" value="">
          <div class="row">
            <div class="col-12 text-center">
              <div class="w-100 mb-3">
                <input type="hidden" name="image" value="">
                <img class="w-100" id="image" src="" style="display: none;">
                <img class="hpx-100 pointer" id="image-placeholder" src="{{url('public')}}/images/add-image.png">
              </div>
              <div class="col-12">
                <div class="docs-buttons w-100 mb-2" style="display: none;">
                  <button type="button" class="btn btn-xs radius-20 btn-white mr-2 p-0" data-method="zoom" data-option="-0.3"> <i class="icon-feather-minus-circle text-info font-18"></i> </button>
                  <button type="button" class="btn btn-xs radius-20 btn-white mr-2 p-0" data-method="zoom" data-option="0.3"> <i class="icon-feather-plus-circle text-info font-18"></i> </button>
                  <button type="button" class="btn btn-xs radius-20 btn-white mr-2 p-0" data-method="rotate" data-option="-90"> <i class="icon-material-outline-undo text-info font-18"></i></button>
                  <button type="button" class="btn btn-xs radius-20 btn-white mr-2 p-0" data-method="rotate" data-option="90"> <i class="icon-material-outline-redo text-info font-18"></i></button>
                  <button type="button" class="btn btn-xs radius-20 btn-white p-0" data-method="reset"> <i class="icon-line-awesome-refresh text-info font-18"></i></button>
                </div>
                <!-- btn btn-white border border-2 dash radius-10 -->
                <label class="btn-block pointer mb-3" for="inputImage"> <input type="file" class="sr-only" id="inputImage" name="file" accept=".jpg,.jpeg,.png" style="display: none;"> <span id="upload-btn-title"></span> </label>
                <button type="button" class="btn btn-block btn-info" id="btn-submit" style="display: none;"> Process </button>
              </div>
            </div>
          </div>
        </form>
    </div>
  </div>
</div>
<!-- MODAL DELETE -->
<div id="delete" class="zoom-anim-dialog mfp-hide dialog-with-tabs modal">
  <h4 class="m-0 pl-3 py-2 text-center bg-gradient text-white">Delete Banner</h4>
  <div class="popup-tabs-container">
    <div class="popup-tab-content pb-0 pt-4" id="tab">
      <form  action="{{url('admin/master/banner/delete')}}" method="post">
        @csrf
        <input type="hidden" name="delete_id" value="">
        <div class="row">
          <div class="col-12 text-center">
            <img class="delete-img hpx-100" src="" alt="">
            <hr class="my-3 mx-0">
          </div>
        </div>
        <div class="row">
          <div class="col-12 text-right">
            <a href="#" class="btn radius-30 btn-light close-modal">Close</a>
            <button type="submit" class="btn radius-30 btn-danger">Delete</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
@section('js')
<script src="{{url('public/cropper')}}/cropper.js"></script>
<script src="{{url('public/cropper')}}/jquery-cropper.js"></script>
<script src="{{url('public/cropper')}}/banner-cropper-init.js"></script>
<!-- MENU -->
<script type="text/javascript">
  $(document).ready(function() {
    $("#navigation").find('.current').removeClass('current');
    $("#navigation").find('li .master-li').addClass('current');
    $("title").text("BANNER");
  });
</script>
<!-- PAGINATION -->
<script type="text/javascript">
  $(document).on('click', '#banner-list li.page-item:not(".disabled")', function(e) {
    e.preventDefault();
    var url = $(this).find("a:first").attr("href");
    window.history.replaceState({},"",url);
    $.get(url, function(data){
      var html = $($.parseHTML(data));
      var item = html.find("#banner-list").html();
      $("#banner-list").html(item);
    });
  });
</script>
<!-- SWITCH -->
<script type="text/javascript">
  $(document).on('change', '.input-switch', function(e, state) {
    var $this = $(e.target);
    if ($this.is(':checked')) { var state = 1; }
    $.post("{{url('admin/master/banner/switch')}}", {
      _token:'{{csrf_token()}}',
      banner_id:$this.data('banner-id'),
      status:state || null
    }, function(data){
      // console.log(data);
    });
  });
</script>
<!-- CROPPER -->
<script type="text/javascript">
  $("#image-placeholder").click(function() {
    $("#inputImage").trigger('click');
  });
  $("#inputImage").change(function() {
    $("#image-placeholder").hide();
    $("#btn-submit, #image, .docs-buttons").show();
    $("#upload-btn-title").html('<span class="badge-info p-2">Change Image</span>');
  });
  $("#btn-submit").click(function() {
    var img = $("#image").cropper('getCroppedCanvas', {width:900}).toDataURL("image/jpeg");
    $("input[name='image']").val(img);
    $(this).closest('form').submit();
  });
</script>
<!-- MODAL -->
<script type="text/javascript">
  function add(){
    $("#btn-submit, #image, .docs-buttons, .cropper-container").hide();
    $("#image-placeholder").attr('src', '{{url("public/images/add-image.png")}}').show();
    $("#add-form").attr('action', "{{url('admin/master/banner/store')}}");
    $("#add-form").find('input[name="banner_id"]').val('');
    $("#image").attr('src', '').hide();
    $("#btn-submit").text('Process');
    $("#upload-btn-title").text("");
  }
  function edit(banner_id){
    $("#btn-submit, #image, .docs-buttons, .cropper-container").hide();
    $("#add-form").attr('action', "{{url('admin/master/banner/update')}}");
    $("#add-form").find('input[name="banner_id"]').val(banner_id);
    $.get("{{url('ajax_banner')}}/"+banner_id, function(data){
      $("#image-placeholder").attr('src', '{{url("public/images/banner")}}/'+data.image+'?{{time()}}').show();
      $("#btn-submit").text('Update');
      $("#upload-btn-title").html('<span class="badge-info p-2">Change Image</span>');
    });
  }
  function remove(banner_id){
    $.get("{{url('ajax_banner')}}/"+banner_id, function(data){
      $("#delete").find('.delete-img').attr('src', "{{url('public')}}/images/banner/"+data.image+'?{{time()}}');
      $("#delete").find('input[name="delete_id"]').val(data.banner_id);
    });
  }
</script>
@endsection
