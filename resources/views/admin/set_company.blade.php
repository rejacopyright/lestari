@extends('layouts.admin')
@section('css')
<link rel="stylesheet" href="{{url('public')}}/select2/select2.min.css">
<link href="{{url('public')}}/summernote/summernote-lite.css" rel="stylesheet">
@endsection
@section('content')
<form class="" action="{{url('admin/company/update')}}" method="post" enctype="multipart/form-data">
  @csrf
  <div class="px-5 pt-3">
    <div class="row">
      <div class="col-lg-3 text-center">
        <div class="dashboard-box m-0 p-3">
          <div class="avatar-wrapper border border-2 radius-10 dash p-2 d-inline-block" data-tippy-placement="bottom" title="Company Logo">
            <img class="profile-pic" src="{{url('public')}}/images/{{$setting->logo ?? 'add-image.png'}}?{{time()}}" alt="" />
            <div class="upload-button"></div>
            <input class="file-upload" name="image" type="file" accept=".jpg, .png"/>
          </div>
        </div>
      </div>
      <div class="col-lg-9">
        <div class="dashboard-box m-0 p-3">
          <div class="row">
            <div class="col-lg-4">
              <div class="mb-2">
                <small class="bold">Company Name</small>
                <input type="text" class="flat" name="name" value="{{$setting->name}}" placeholder="Company Name" required>
              </div>
            </div>
            <div class="col-lg-4">
              <div class="mb-2">
                <small class="bold">Alias</small>
                <input type="text" class="flat" name="alias" value="{{$setting->alias}}" placeholder="Alias" required>
              </div>
            </div>
            <div class="col-lg-4">
              <div class="mb-2">
                <small class="bold">Slogan / Description</small>
                <input type="text" class="flat" name="description" value="{{$setting->description}}" placeholder="Slogan / Description" required>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <div class="mb-2">
                <small class="bold">Address</small>
                <input type="text" class="flat" name="address" value="{{$setting->address}}" placeholder="Address" required>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-4">
              <div class="mb-2">
                <small class="bold">Contact</small>
                <input type="text" class="flat" name="contact" value="{{$setting->contact}}" placeholder="08123xxx" required>
              </div>
            </div>
            <div class="col-lg-4">
              <div class="mb-2">
                <small class="bold">Email</small>
                <input type="text" class="flat" name="email" value="{{$setting->email}}" placeholder="info@company.com" required>
              </div>
            </div>
            <div class="col-lg-4">
              <div class="mb-2">
                <small class="bold">Whatsapp</small>
                <input type="text" class="flat" name="whatsapp" value="{{$setting->whatsapp}}" placeholder="08123xxx" required>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-6">
              <div class="mb-2">
                <small class="bold">Facebook</small>
                <input type="text" class="flat" name="facebook" value="{{$setting->facebook}}" placeholder="https://www.facebook.com/company">
              </div>
            </div>
            <div class="col-lg-6">
              <div class="mb-2">
                <small class="bold">Twitter</small>
                <input type="text" class="flat" name="twitter" value="{{$setting->twitter}}" placeholder="https://twitter.com/company">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-6">
              <div class="mb-2">
                <small class="bold">Instagram</small>
                <input type="text" class="flat" name="instagram" value="{{$setting->instagram}}" placeholder="https://www.instagram.com/company">
              </div>
            </div>
            <div class="col-lg-6">
              <div class="mb-2">
                <small class="bold">Youtube</small>
                <input type="text" class="flat" name="youtube" value="{{$setting->youtube}}" placeholder="https://www.youtube.com/company">
              </div>
            </div>
          </div>
          <hr>
          <div class="float-right">
            <a href="{{url()->previous()}}" class="btn btn-light radius-5 px-md-4 mr-2">Back</a>
            <button type="submit" class="btn btn-info radius-5 px-md-4">Update</button>
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
    $("title").text("COMPANY SETTING");
  });
</script>
@endsection
