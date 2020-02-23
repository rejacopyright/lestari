@extends('layouts.admin')
@section('css')
<link rel="stylesheet" href="{{url('public')}}/select2/select2.min.css">
@endsection
@section('content')
<div class="container pt-3">
  <div class="row">
    <div class="col-lg-6 offset-lg-3">
      <div class="input-with-icon-left no-border mb-2">
        <i class="icon-material-outline-search"></i>
        <input id="type-search" type="text" class="input-text" placeholder="Search type name">
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-lg-6 offset-lg-3" id="ms-list">
      <table class="basic-table table-bordered-bottom">
        <tr>
          <th>Type Name</th>
          <th class="text-right"><span class="badge-info pointer mr-2 popup-with-zoom-anim" href="#ms-add"><i class="icon-line-awesome-plus mr-1"></i>Add Type</span></th>
        </tr>
        <?php foreach ($ms as $master): ?>
          <tr>
            <td class="text-nowrap bold text-uppercase">{{$master->name}}</td>
            <td class="text-right text-nowrap">
              <span class="badge-warning pointer mr-2 popup-with-zoom-anim" href="#ms-edit" onclick="edit({{$master->ms_id}})">Edit</span>
              <span class="badge-danger pointer popup-with-zoom-anim" href="#ms-delete" onclick="remove({{$master->ms_id}})">Delete</span>
            </td>
          </tr>
        <?php endforeach; ?>
      </table>
      <div class="float-right mt-2">
        {{$ms->appends(['q' => $q])->links()}}
      </div>
    </div>
  </div>
</div>
<!-- MODAL ADD -->
<div id="ms-add" class="zoom-anim-dialog mfp-hide dialog-with-tabs modal">
  <h4 class="m-0 pl-3 py-2 text-center bg-gradient text-white">ADD TYPE</h4>
  <div class="popup-tabs-container">
    <div class="popup-tab-content px-2 pb-2 pt-3" id="tab">
      <form class="" action="{{url('admin/product/master/spec/store')}}" method="post">
        @csrf
        <div class="container mt-3">
          <div class="row">
            <div class="col-lg-9 text-center">
              <input type="text" class="flat" name="name" placeholder="Spec Name" required>
            </div>
            <div class="col-lg-3 text-center">
              <button type="submit" class="btn btn-info radius-5 px-md-4">Proccess</button>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- MODAL EDIT -->
<div id="ms-edit" class="zoom-anim-dialog mfp-hide dialog-with-tabs modal">
  <h4 class="m-0 pl-3 py-2 text-center bg-gradient text-white">EDIT TYPE</h4>
  <div class="popup-tabs-container">
    <div class="popup-tab-content px-2 pb-2 pt-3" id="tab">
      <form class="" action="{{url('admin/product/master/spec/update')}}" method="post">
        @csrf
        <input type="hidden" name="ms_id" value="">
        <div class="container mt-3">
          <div class="row">
            <div class="col-lg-9 text-center">
              <input type="text" class="flat" name="name" placeholder="Type Name" required>
            </div>
            <div class="col-lg-3 text-center">
              <button type="submit" class="btn btn-info radius-5 px-md-4">Update</button>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- MODAL DELETE -->
<div id="ms-delete" class="zoom-anim-dialog mfp-hide dialog-with-tabs modal">
  <h4 class="m-0 pl-3 py-2 text-center bg-gradient text-white">DELETE CONFIRMATION</h4>
  <div class="popup-tabs-container">
    <div class="popup-tab-content px-2 pb-2 pt-3" id="tab">
      <form class="" action="{{url('admin/product/master/spec/delete')}}" method="post">
        @csrf
        <input type="hidden" name="ms_id" value="">
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
    $("#navigation").find('li .master-li').addClass('current');
    $("title").text("MASTER SPEC");
  });
</script>
<!-- EDIT -->
<script type="text/javascript">
  function edit(msId){
    $.get("{{url('ajax_ms_detail')}}",{ms_id:msId},function(data){
      $this = $("#ms-edit");
      $this.find('input[name="ms_id"]').val(data.ms_id);
      $this.find('input[name="name"]').val(data.name);
    });
  }
</script>
<!-- DELETE -->
<script type="text/javascript">
  function remove(ms_id){
    $("#ms-delete").find('input[name="ms_id"]').val(ms_id);
    $.get("{{url('ajax_ms_detail')}}",{ms_id:ms_id},function(data){
      var delete_title = '<p class="bold">Are you sure want to delete this Spec ?</p>';
      $("#delete-title").html(delete_title);
    });
  }
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
  $(document).on('click', '#ms-list li.page-item:not(".disabled")', function(event) {
    event.preventDefault();
    var url = $(this).find("a:first").attr("href");
    window.history.replaceState({},"",url);
    $.get(url, function(data){
      var html = $($.parseHTML(data));
      var item = html.find("#ms-list").html();
      $("#ms-list").html(item);
    });
  });
</script>
<!-- SEARCH -->
<script type="text/javascript">
  $(document).on('keyup change', '#type-search', function(e) {
    var val = $(e.target).val();
    $.get("{{url()->current()}}", {
      q:val
    }, function(data){
      var html = $($.parseHTML(data));
      var item = html.find("#ms-list").html();
      $("#ms-list").html(item);
    });
  });
</script>
@endsection
