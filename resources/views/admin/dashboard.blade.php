@extends('layouts.admin')
@section('css')
@endsection
@section('content')
<div class="container mx-auto pt-3">
  <!-- PRODUCT -->
  <div class="row mx-0 align-items-center mt-2 mb-3"> <div class="col px-0"><hr/></div> <div class="col-auto"><h4 class="badge-warning px-5">Amount Information</h4></div> <div class="col px-0"><hr/></div> </div>
  <div class="row">
    <div class="col-md-3 text-center">
      <a href="{{url('admin/product/brand')}}" class="shadow-xs card p-2 pointer d-flex align-items-center">
        <div class="col text-left">
          <h5 class="lh-12 bold text-nowrap">Brand</h5>
          <h1 class="lh-12 bold text-info">{{$count['brand']}}</h1>
        </div>
        <div class="col text-center pr-0">
          <div class="badge-info p-3">
            <i class="icon-line-awesome-flag font-35"></i>
          </div>
        </div>
      </a>
    </div>
    <div class="col-md-3 text-center">
      <a href="{{url('admin/product')}}" class="shadow-xs card p-2 pointer d-flex align-items-center">
        <div class="col text-left">
          <h5 class="lh-12 bold text-nowrap">Product</h5>
          <h1 class="lh-12 bold text-warning">{{$count['product']}}</h1>
        </div>
        <div class="col text-center pr-0">
          <div class="badge-warning p-3">
            <i class="icon-feather-package font-35"></i>
          </div>
        </div>
      </a>
    </div>
    <div class="col-md-3 text-center">
      <a href="{{url('admin/product/series')}}" class="shadow-xs card p-2 pointer d-flex align-items-center">
        <div class="col text-left">
          <h5 class="lh-12 bold text-nowrap">Product Series</h5>
          <h1 class="lh-12 bold text-danger">{{$count['product_series']}}</h1>
        </div>
        <div class="col text-center pr-0">
          <div class="badge-danger p-3">
            <i class="icon-brand-pied-piper font-35"></i>
          </div>
        </div>
      </a>
    </div>
    <div class="col-md-3 text-center">
      <a href="{{url('admin/product/spec')}}" class="shadow-xs card p-2 pointer d-flex align-items-center">
        <div class="col text-left">
          <h5 class="lh-12 bold text-nowrap">Product Type</h5>
          <h1 class="lh-12 bold text-success">{{$count['product_type']}}</h1>
        </div>
        <div class="col text-center pr-0">
          <div class="badge-success p-3">
            <i class="icon-line-awesome-adjust font-35"></i>
          </div>
        </div>
      </a>
    </div>
  </div>
  <!-- MISC -->
  <div class="row mt-3">
    <div class="col-md-3 text-center">
      <a href="javascript:void(0)" class="shadow-xs card p-2 pointer d-flex align-items-center">
        <div class="col text-left">
          <h5 class="lh-12 bold text-nowrap">User</h5>
          <h1 class="lh-12 bold text-danger">{{$count['user']}}</h1>
        </div>
        <div class="col text-center pr-0">
          <div class="badge-danger p-3">
            <i class="icon-feather-user font-35"></i>
          </div>
        </div>
      </a>
    </div>
    <div class="col-md-3 text-center">
      <a href="{{url('admin/marketing/contact/email')}}" class="shadow-xs card p-2 pointer d-flex align-items-center">
        <div class="col text-left">
          <h5 class="lh-12 bold text-nowrap">Email Contact</h5>
          <h1 class="lh-12 bold text-success">{{$count['email_contact']}}</h1>
        </div>
        <div class="col text-center pr-0">
          <div class="badge-success p-3">
            <i class="icon-feather-mail font-35"></i>
          </div>
        </div>
      </a>
    </div>
    <div class="col-md-3 text-center">
      <a href="javascript:void(0)" class="shadow-xs card p-2 pointer d-flex align-items-center">
        <div class="col text-left">
          <h5 class="lh-12 bold">Visitor Last Month</h5>
          <h1 class="lh-12 bold text-info visitor">0</h1>
        </div>
        <div class="col text-center pr-0">
          <div class="badge-info p-3">
            <i class="icon-feather-users font-35"></i>
          </div>
        </div>
      </a>
    </div>
    <div class="col-md-3 text-center">
      <a href="javascript:void(0)" class="shadow-xs card p-2 pointer d-flex align-items-center">
        <div class="col text-left">
          <h5 class="lh-12 bold">Page View Last Month</h5>
          <h1 class="lh-12 bold text-warning pageView">0</h1>
        </div>
        <div class="col text-center pr-0">
          <div class="badge-warning p-3">
            <i class="icon-feather-eye font-35"></i>
          </div>
        </div>
      </a>
    </div>
  </div>
</div>
@endsection
@section('js')
<!-- MENU -->
<script type="text/javascript">
  $(document).ready(function() {
    $("#navigation").find('.current').removeClass('current');
    $("#navigation").find('li a[href="{{url("admin")}}"]:first').addClass('current');
    $("title").text("MARKETING");
  });
</script>
<!-- ANALYTICS -->
<script type="text/javascript">
  function analytics(){
    $.get('{{url("ajax_analytics")}}', function(data){
      var visitor = data.view.map(function(i){ return i[0]; }).reduce(function(a,b){return a+b});
      var pageView = data.view.map(function(i){ return i[1]; }).reduce(function(a,b){return a+b});
      $('.visitor').text(visitor || 0);
      $('.pageView').text(pageView || 0);
    });
  }
  $(document).ready(function() {
    analytics();
  });
  setInterval(function () {
    analytics();
    // console.log("OK");
  }, 5000);
</script>
@endsection
