@extends('layouts.admin')
@section('css')
<link rel="stylesheet" href="{{url('public')}}/select2/select2.min.css">
<link href="{{url('public')}}/summernote/summernote-lite.css" rel="stylesheet">
@endsection
@section('content')
<div id="page-loading" style="display: none;">
  <div class="three-balls">
    <div class="ball-text">Updating</div>
    <div class="ball ball1"></div>
    <div class="ball ball2"></div>
    <div class="ball ball3"></div>
  </div>
</div>
<form class="" action="#" method="post">
  @csrf
  <div class="px-5 pt-3">
    <div class="row">
      <div class="col-md-6 offset-md-3">
        <div class="d-block text-center radius-0 badge-info bold font-16"> <i class="icon-line-awesome-user mr-1"></i> Profile </div>
        <div class="dashboard-box m-0 px-3 py-2">
          <div class="row">
            <div class="col-md-6">
              <div class="mb-2">
                <small class="bold">Name</small>
                <input type="text" class="flat" name="nama" value="{{$admin->nama}}" placeholder="Name" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-2">
                <small class="bold">Username</small>
                <input type="text" class="flat text-lowercase" name="username" value="{{$admin->username}}" placeholder="Alias" required>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="mb-2">
                <small class="bold">Email</small>
                <input type="text" class="flat text-lowercase" name="email" value="{{$admin->email}}" placeholder="Name" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-2">
                <small class="bold">Whatsapp</small>
                <input type="text" class="flat" name="wa" value="{{$admin->wa}}" placeholder="Alias" required>
              </div>
            </div>
          </div>
          <hr>
          <div class="float-right">
            <button type="button" class="btn btn-info radius-5 px-md-4" id="profile-btn">Update</button>
          </div>
          <div class="clearfix"></div>
        </div>
      </div>
    </div>
    <div class="row mt-3">
      <div class="col-md-6 offset-md-3">
        <div class="d-block text-center radius-0 badge-warning bold font-16"> <i class="icon-line-awesome-lock mr-1"></i> Password </div>
        <div class="dashboard-box m-0 px-3 py-2">
          <div class="row">
            <div class="col-12">
              <div class="mb-2">
                <small class="bold">Old Password</small>
                <div class="input-with-icon no-border mb-2">
                  <input type="hidden" name="check_old_password" value="0">
                  <input type="password" name="old_password" class="flat" placeholder="Old Password">
                  <i class="icon-line-awesome-close bg-danger text-white radius-30 p-1" style="display: none;"></i>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-2">
                <small class="bold">New Password</small>
                <div class="input-with-icon no-border mb-2">
                  <input type="password" name="new_password" class="flat" placeholder="New Password" disabled>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-2">
                <small class="bold">Confirm Password</small>
                <div class="input-with-icon no-border mb-2">
                  <input type="hidden" name="check_new_password" value="0">
                  <input type="password" name="confirm_password" class="flat" placeholder="Confirm Password" disabled>
                  <i class="icon-line-awesome-close bg-danger text-white radius-30 p-1" style="display: none;"></i>
                </div>
              </div>
            </div>
          </div>
          <hr>
          <div class="float-right">
            <button type="button" class="btn btn-warning radius-5 px-md-4 bold" id="password-btn">Change Password</button>
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
<!-- Old Password Checker -->
<script type="text/javascript">
  var timeout = null;
  $(document).on('keyup change', 'input[name="old_password"]', function() {
    var val = $(this).val();
    if (val) { $('input[name="old_password"]').parent().find('i').show(); }else { $('input[name="old_password"]').parent().find('i').hide(); }
    clearTimeout(timeout);
    timeout = setTimeout(function () {
      $.post('{{url("ajax_old_password_admin")}}', {
        _token:'{{csrf_token()}}',
        password:val
      }, function(data) {
        if (data == 'match') {
          $('input[name="old_password"]').parent().find('i').removeClass('icon-line-awesome-close bg-danger').addClass('icon-feather-check bg-success');
          $('input[name="old_password"]').parent().find('input[name="check_old_password"]').val(1);
          $('input[name="new_password"], input[name="confirm_password"]').prop('disabled', false);
          $('input[name="new_password"]').trigger('focus');
        }else {
          $('input[name="old_password"]').parent().find('i').removeClass('icon-feather-check bg-success').addClass('icon-line-awesome-close bg-danger');
          $('input[name="old_password"]').parent().find('input[name="check_old_password"]').val(0);
          $('input[name="new_password"], input[name="confirm_password"]').prop('disabled', true);
        }
      });
    }, 200);
  });
  function newPassword(){
    var new_password = $('input[name="new_password"]').val();
    var confirm_password = $('input[name="confirm_password"]').val();
    if (confirm_password) { $('input[name="confirm_password"]').parent().find('i').show(); }else { $('input[name="confirm_password"]').parent().find('i').hide(); }
    clearTimeout(timeout);
    timeout = setTimeout(function () {
      if (new_password == confirm_password) {
        $('input[name="confirm_password"]').parent().find('i').removeClass('icon-line-awesome-close bg-danger').addClass('icon-feather-check bg-success');
        $('input[name="confirm_password"]').parent().find('input[name="check_new_password"]').val(1);
      }else {
        $('input[name="confirm_password"]').parent().find('i').removeClass('icon-feather-check bg-success').addClass('icon-line-awesome-close bg-danger');
        $('input[name="confirm_password"]').parent().find('input[name="check_new_password"]').val(0);
      }
    }, 100);
  }
  function resetPassword(){
    $('input[name="check_old_password"], input[name="check_new_password"]').val(0);
    $('input[name="old_password"], input[name="new_password"], input[name="confirm_password"]').val('');
    $('input[name="old_password"]').parent().find('i').hide();
    $('input[name="confirm_password"]').parent().find('i').hide();
  }
  $(document).on('keyup change', 'input[name="new_password"], input[name="confirm_password"]', function() {
    newPassword();
  });
  $(document).on('click', '#password-btn', function() {
    var old_password = parseInt($('input[name="check_old_password"]').val());
    var new_password = parseInt($('input[name="check_new_password"]').val());
    var password = $('input[name="new_password"]').val();
    if (old_password && new_password) {
      $('#page-loading').fadeIn();
      $.post('{{url("ajax_change_password_admin")}}', {
        _token:'{{csrf_token()}}',
        password:password
      }, function(data) {
        resetPassword();
        $('#page-loading').fadeOut();
        Snackbar.show({ text: "The password has been changed", textColor: '#fff', backgroundColor: 'blue' });
        // console.log(data);
      });
    }else {
      Snackbar.show({ text: "Make sure the password is filled in correctly", textColor: '#fff', backgroundColor: '#e82a2a' });
    }
  });
</script>
<!-- Profile -->
<script type="text/javascript">
  function profile(){
    var req = {'_token':'{{csrf_token()}}'};
    req['nama'] = $('input[name="nama"]').val();
    req['username'] = $('input[name="username"]').val();
    req['email'] = $('input[name="email"]').val();
    req['wa'] = $('input[name="wa"]').val();
    return req;
  }
  $(document).on('click', '#profile-btn', function() {
    $('#page-loading').fadeIn();
    $.post('{{url("ajax_change_profile_admin")}}', profile(), function(data) {
      $('#page-loading').fadeOut();
      Snackbar.show({ text: "Profile has been updated", textColor: '#fff', backgroundColor: 'blue' });
    });
  });
</script>
@endsection
