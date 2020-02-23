@extends('layouts.user')
@section('title'){{strtoupper($spec->series->product->brand->name)}} {{strtoupper($spec->series->product->name)}} {{strtoupper($spec->series->name)}} {{strtoupper($spec->name)}} @endsection
@section('css')
<meta http-equiv="Content-Language" content="id" />
<meta property="og:title" content="{{strtoupper($spec->name)}}"/>
<meta property="og:description" content="{{strtoupper($spec->series->product->name)}} | {{strtoupper($spec->series->name)}} | {{strtoupper($spec->name)}}"/>
<meta name="description" content="{{strtoupper($spec->series->product->name)}} | {{strtoupper($spec->series->name)}} | {{strtoupper($spec->name)}}"/>
<meta property="og:type" content="image/jpeg"/>
<meta property="og:url" content="{{url()->full()}}"/>
<meta property="og:site_name" content="{{url('/')}}"/>
<meta property="og:image" itemprop="image" content="{{url('public')}}/images/spec/{{$spec->image ?? '../add-image.png'}}?{{time()}}"/>
<meta property="og:image:secure_url" content="{{url('public')}}/images/spec/{{$spec->image ?? '../add-image.png'}}?{{time()}}"/>
<meta property="og:image:width" content="400" />
<meta property="og:image:height" content="400" />
<meta property="og:image:alt" content="{{$spec->name}}" />
@endsection
@section('content')
<div class="container pt-3">
  <!-- Breadcrumbs -->
  <div class="row mb-3">
    <div class="col-12">
      <nav class="bg-gray p-2 w-100">
        <ol class="breadcrumb">
          <li><a href="{{url('product')}}">product</a></li>
          <li><a href="{{url('product/detail')}}/{{$spec->series->product->product_id}}">{{$spec->series->product->name}}</a></li>
          <li><a href="{{url('product/spec')}}?product_id={{$spec->series->product->product_id}}&series_id={{$spec->series->series_id}}">{{$spec->series->name}}</a></li>
          <li class="text-dark">{{$spec->name}}</li>
        </ol>
      </nav>
    </div>
  </div>
  <div class="row">
    <div class="col-lg-3 text-center">
      <div class="dashboard-box radius-10 m-0 p-3">
        <div class="avatar-wrappers border border-2 radius-10 dash p-2 d-inline-block">
          <img class="profile-pic" src="{{url('public')}}/images/spec/{{$spec->image ?? '../series/'.$spec->series->image ?? '../products/'.$spec->series->product->image ?? '../add-image.png'}}?{{time()}}" alt="" />
        </div>
        <?php if ($spec->catalog): ?>
          <div class="mt-2">
            <?php if (($spec->download_access && auth::user()) || !$spec->download_access): ?>
              <a href="{{url('public')}}/images/catalog/{{$spec->catalog}}" target="_blank" class="btn btn-info btn-block w-100 ripple-effect text-white font-12 py-2" disabled>Download Catalog</a>
            <?php else: ?>
              <span class="btn bg-light btn-block text-secondary font-12 py-2 no-drop" data-tippy-placement="bottom" title="Login Required">Download Catalog</span>
            <?php endif; ?>
          </div>
        <?php endif; ?>
      </div>
      <!-- FOR SEO GRID -->
      <div class="row mt-4">
        <div class="col text-center">
          @include('layouts.ads.square')
        </div>
      </div>
    </div>
    <div class="col-lg-9">
      <div class="badge-warning radius-0 mb-3 py-2"><i class="icon-line-awesome-info-circle font-16 mr-2"></i>GENERAL INFO</div>
      <table class="basic-table table-responsive table-bordered-bottom zebra-v text-dark bold">
        <tr>
          <td class="col-auto text-nowrap">Product Category</td>
          <td class="col-auto text-nowrap">:</td>
          <td class="col">{{$spec->series->product->type->name ?? 'OTHER'}}</td>
        </tr>
        <tr>
          <td class="col-auto text-nowrap">Product Brand</td>
          <td class="col-auto text-nowrap">:</td>
          <td class="col text-uppercase">{{$spec->series->product->brand->name ?? 'OTHER'}}</td>
        </tr>
        <tr>
          <td class="col-auto text-nowrap">Product Name</td>
          <td class="col-auto text-nowrap">:</td>
          <td class="col">{{$spec->series->product->name}}</td>
        </tr>
        <tr>
          <td class="col-auto text-nowrap">Series</td>
          <td class="col-auto text-nowrap">:</td>
          <td class="col">{{$spec->series->name}}</td>
        </tr>
        <tr>
          <td class="col-auto text-nowrap">Type Name</td>
          <td class="col-auto text-nowrap">:</td>
          <td class="col">{!! $spec->description !!}</td>
        </tr>
        <tr>
          <td class="col-auto text-nowrap">Part Number</td>
          <td class="col-auto text-nowrap">:</td>
          <td class="col">{{$spec->name}}</td>
        </tr>
      </table>
      <div class="badge-danger radius-0 my-3 py-2"><i class="icon-line-awesome-info-circle font-16 mr-2"></i>SPECIFICATION</div>
      <table class="basic-table table-responsive table-bordered-bottom zebra-v text-dark bold">
        <?php foreach ($ms as $master): ?>
          <tr>
            <td class="col-auto text-nowrap">{{$master->name}}</td>
            <td class="col-auto text-nowrap">:</td>
            <td class="col text-info">{{$spec->value()->where('ms_id', $master->ms_id)->first()->ms_value}}</td>
          </tr>
        <?php endforeach; ?>
      </table>
      <!-- FOR SEO GRID -->
      <div class="row mt-3">
        <div class="col-6 col-md-3 text-center">
          @include('layouts.ads.square_xs')
        </div>
        <div class="col-6 col-md-3 text-center">
          @include('layouts.ads.square_xs')
        </div>
        <div class="col-6 col-md-3 text-center">
          @include('layouts.ads.square_xs')
        </div>
        <div class="col-6 col-md-3 text-center">
          @include('layouts.ads.square_xs')
        </div>
      </div>
    </div>
  </div>
</div>
<!-- WHATSAPP -->
<div class="position-fixed r-1 b-1 pointer z-999">
  <div class="pop">
    <div class="pop-target">
      <a href="javascript:void(0)" bg="#3b5998" class="btn square-50 radius-50 mb-2 facebook-btn" title="Share on Facebook" data-tippy-placement="left"><i class="icon-brand-facebook-f font-16 lh-2 text-white"></i></a>
      <br>
      <a href="https://api.whatsapp.com/send?text={{urlencode(url()->full())}}" target="_blank" bg="#4bc25a" class="btn square-50 radius-50 mb-2 pt-1" title="Share on Whatsapp" data-tippy-placement="left"><i class="icon-brand-whatsapp font-20 lh-2 text-white"></i></a>
    </div>
    <div class="btn square-50 radius-50 mb-2 pop-trigger" bg="#ddd"><i class="icon-feather-share-2 text-success font-24 lh-13"></i></div>
  </div>
  <a href="https://api.whatsapp.com/send?phone={{$whatsapp}}&text={{urlencode(url()->full())}}" target="_blank" class="btn square-50 radius-50" bg="#4bc25a" data-tippy-placement="left" title="Ask Something"><i class="icon-brand-whatsapp text-white font-24 lh-13"></i></a>
</div>
@endsection
@section('js')
<!-- MENU -->
<script type="text/javascript">
  $(document).ready(function() {
    $("#navigation").find('.current').removeClass('current');
    $("#navigation").find('li>a.product-li').addClass('current');
  });
</script>
<!-- Facebook Share -->
<script type="text/javascript">
  $(document).on('click', '.facebook-btn',function() {
    var link = 'https://www.facebook.com/sharer?u={{urlencode(url()->full())}}';
    window.open(link, '', "width=1,height=1");
  });
</script>
@endsection
