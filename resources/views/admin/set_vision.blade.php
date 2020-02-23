@extends('layouts.admin')
@section('css')
<link href="{{url('public')}}/summernote/summernote-lite.css" rel="stylesheet">
@endsection
@section('content')
<div class="container pt-3">
  <form class="" action="{{url('admin/vision/update')}}" method="post">
    @csrf
    <div class="row">
      <div class="col-12">
        <textarea name="vision" class="flat summernote" rows="6">{{$setting->vision ?? ''}}</textarea>
      </div>
    </div>
    <hr>
    <div class="row">
      <div class="col-12 text-right">
        <button type="submit" class="btn btn-info px-4">Update</button>
      </div>
    </div>
  </form>
</div>
@endsection
@section('js')
<script src="{{url('public')}}/summernote/summernote-lite.js"></script>
<!-- MENU -->
<script type="text/javascript">
  $(document).ready(function() {
    $("#navigation").find('.current').removeClass('current');
    $("#navigation").find('.setting-li').addClass('current');
    $("title").text("VISION");
  });
</script>
<!-- INIT -->
<script type="text/javascript">
  $(document).ready(function() {
    $(".summernote").summernote({
      height: 350, // set editor height
      minHeight: 350, // set minimum height of editor
      maxHeight: 350, // set maximum height of editor
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
<!-- MODAL -->
@endsection
