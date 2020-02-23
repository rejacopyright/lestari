@extends('layouts.admin')
@section('css')
<link href="{{url('public')}}/summernote/summernote-lite.css" rel="stylesheet">
@endsection
@section('content')
<form class="" action="{{url('admin/promo/put')}}" method="post" enctype="multipart/form-data">
  @csrf
  <input type="hidden" name="promo_id" value="{{$promo->promo_id}}">
  <div class="px-4 pt-3">
    <div class="row">
      <div class="col-auto text-center">
        <div class="dashboard-box m-0 p-3">
          <div class="avatar-wrapper d-inline-block" data-tippy-placement="bottom" title="Upload Image">
            <img class="profile-pic" src="{{url('public')}}/images/promo/{{$promo->image ?? '../add-image.png'}}?{{time()}}" alt="" />
            <div class="upload-button"></div>
            <input class="file-upload" name="image" type="file" accept=".jpg, .png"/>
          </div>
          <div class="text-center mt-2 text-muted"><hr> Promo Image </div>
        </div>
      </div>
      <div class="col">
        <div class="dashboard-box m-0 p-3">
          <div class="mb-2">
            <input type="text" class="flat" name="title" value="{{$promo->title}}" placeholder="Promo Title" required>
          </div>
          <div class="mb-2">
            <p class="m-0 text-muted">Promo Description</p>
            <textarea name="description" class="flat summernote" placeholder="Promo Description">{{$promo->description}}</textarea>
          </div>
          <div class="float-right">
            <a href="{{url()->previous()}}" class="btn btn-light radius-5 px-md-4 mr-2">Back</a>
            <button type="submit" class="btn btn-info radius-5 px-md-5">Update</button>
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
    $("title").text("EDIT PROMOTION");
  });
</script>
<!-- INIT -->
<script type="text/javascript">
  $(document).ready(function() {
    $(".summernote").summernote({
      height: 250, // set editor height
      minHeight: 150, // set minimum height of editor
      maxHeight: 500, // set maximum height of editor
      focus: true, // set focus to editable area after initializing summernote
      toolbar: [
        ['misc', ['codeview', 'fullscreen', 'undo', 'redo']],
        ['style', ['style', 'bold', 'italic', 'underline', 'clear', 'fontname', 'fontsize']],
        ['para', ['ul', 'ol', 'paragraph']],
        ['color', ['color']],
        ['height', ['height']],
        ['Insert', ['hr', 'table', 'picture', 'link']],
      ]
    });
  });
</script>
@endsection