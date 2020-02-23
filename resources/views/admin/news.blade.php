@extends('layouts.admin')
@section('css')
<link rel="stylesheet" href="{{url('public')}}/select2/select2.min.css">
@endsection
@section('content')
<?php
 function limit($a, $b){ $arr = explode(' ', $a); if (count($arr) <= $b) { $dot = ""; }else { $dot = "..."; } $limit = implode(' ', array_slice($arr,0,$b)); return $limit.$dot; }
 ?>
<div class="container pt-3">
  <div class="row align-items-center mb-2">
    <div class="col">
      <div class="input-with-icon-left no-border">
        <i class="icon-material-outline-search"></i>
        <input id="news-search" type="text" class="input-text" placeholder="Search News Here...">
      </div>
    </div>
    <div class="col text-right">
      <a href="{{url('admin/news/add')}}" class="badge-info py-2 pointer"><i class="icon-line-awesome-plus mr-1"></i>Post News</a>
    </div>
  </div>
  <div class="row">
    <div class="col-12" id="news-list">
      <table class="basic-table table-bordered-bottom">
        <tr>
          <th></th>
          <th>News Title</th>
          <th>News Description</th>
          <th class="text-right"></th>
        </tr>
        <?php foreach ($news as $nw): ?>
          <tr>
            <td> <div class="hpx-50"> <img src="{{url('public')}}/images/news/{{$nw->image ?? '../image.png'}}?{{time()}}" class="border border-2 radius-10 p-1 dash h-100 w-auto"> </div> </td>
            <td class="text-nowrap bold text-capitalize" data-tippy-placement="top" title="{{ucwords($nw->title)}}">{{limit($nw->title, 5)}}</td>
            <td class="text-nowrap bold text-truncate">{{limit(strip_tags($nw->description), 7)}}</td>
            <td class="text-right text-nowrap">
              <a href="{{url('admin/news/edit')}}/{{$nw->news_id}}" class="badge-warning pointer mr-2">Edit</a>
              <span class="badge-danger pointer popup-with-zoom-anim" href="#news-delete" onclick="remove({{$nw->news_id}})">Delete</span>
            </td>
          </tr>
        <?php endforeach; ?>
      </table>
      <div class="float-right mt-2">
        {{$news->appends(['q' => $q])->links()}}
      </div>
    </div>
  </div>
</div>
<!-- MODAL DELETE -->
<div id="news-delete" class="zoom-anim-dialog mfp-hide dialog-with-tabs modal">
  <h4 class="m-0 pl-3 py-2 text-center bg-gradient text-white">DELETE CONFIRMATION</h4>
  <div class="popup-tabs-container">
    <div class="popup-tab-content px-2 pb-2 pt-3" id="tab">
      <form class="" action="{{url('admin/news/delete')}}" method="post">
        @csrf
        <input type="hidden" name="news_id" value="">
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
<!-- MENU -->
<script type="text/javascript">
  $(document).ready(function() {
    $("#navigation").find('.current').removeClass('current');
    $("#navigation").find('li a[href="{{url("admin/news")}}"]:first').addClass('current');
    $("title").text("NEWS");
  });
</script>
<!-- DELETE -->
<script type="text/javascript">
  function remove(news_id){
    $("#news-delete").find('input[name="news_id"]').val(news_id);
    $.get("{{url('ajax_news_detail')}}",{news_id:news_id},function(data){
      console.log(data);
      var delete_title = '<p class="bold">Are you sure want to delete this News ?</p>';
      $("#delete-title").html(delete_title);
    });
  }
</script>
<!-- INIT -->
<script type="text/javascript">
  $(document).on('click', '#news-list li.page-item:not(".disabled")', function(event) {
    event.preventDefault();
    var url = $(this).find("a:first").attr("href");
    window.history.replaceState({},"",url);
    $.get(url, function(data){
      var html = $($.parseHTML(data));
      var item = html.find("#news-list").html();
      $("#news-list").html(item);
    });
  });
</script>
<!-- SEARCH -->
<script type="text/javascript">
  $(document).on('keyup change', '#news-search', function(e) {
    var val = $(e.target).val();
    $.get("{{url()->current()}}", {
      q:val
    }, function(data){
      var html = $($.parseHTML(data));
      var item = html.find("#news-list").html();
      $("#news-list").html(item);
    });
  });
</script>
@endsection
