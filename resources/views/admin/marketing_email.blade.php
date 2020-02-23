@extends('layouts.admin')
@section('css')
<link rel="stylesheet" href="{{url('public')}}/select2/select2.min.css">
<link href="{{url('public')}}/summernote/summernote-lite.css" rel="stylesheet">
<style media="screen">
  .note-group-select-from-files{
    display: none !important;
  }
  .note-modal-body{
    padding: 10px 20px !important;
  }
</style>
@endsection
@section('content')
<div id="page-loading" style="display: none;">
  <div class="three-balls">
    <div class="ball-text">Sending Email</div>
    <div class="ball ball1"></div>
    <div class="ball ball2"></div>
    <div class="ball ball3"></div>
  </div>
</div>
<form id="form" action="{{url('admin/marketing/email/store')}}" method="post" enctype="multipart/form-data">
  @csrf
  <div class="px-5 pt-3">
    <div class="row">
      <div class="col-md-3">
        <div class="btn btn-block btn-light mb-1 bold"> <i class="icon-line-awesome-user"></i> Receiver </div>
        <div class="border border-2 dash m-0 p-3">
          <div class="switches-list">
            <div class="switch-container w-auto">
              <label class="switch text-info"><input type="checkbox" name="user" checked><span class="switch-button"></span> All User</label>
            </div>
          </div>
          <hr>
          <div class="switches-list">
            <div class="switch-container w-auto">
              <label class="switch text-info"><input type="checkbox" name="contact" checked><span class="switch-button"></span> All Contact</label>
            </div>
          </div>
        </div>
        <div class="btn btn-block btn-light mb-1 bold mt-4"> <i class="icon-line-awesome-image"></i> Header </div>
        <div class="border border-2 dash m-0 p-3">
          <div class="switches-list">
            <div class="switch-container w-auto">
              <label class="switch text-info"><input type="checkbox" name="header_img"><span class="switch-button"></span> Header Image</label>
            </div>
          </div>
          <div class="row mt-3" style="display: none;">
            <div class="col-12 text-center" id="header_img">
              <input type="hidden" name="banner_id" value="">
              <img id="image-placeholder" src="" alt="" class="w-100 mb-2" style="display: none;">
              <div class="badge-info py-2 pointer popup-with-zoom-anim" href="#select-img" onclick="selectImg()">
                Click to Select Image
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-9">
        <div class="dashboard-box m-0 p-3">
          <div class="mb-2" id="contact-select2" style="display: none;">
            <div class="input-with-icon-left no-border mb-0">
              <i class="icon-line-awesome-user bg-transparent m-1 font-18"></i>
              <select class="select2" name="email_id[]" multiple style="width: 100%;"></select>
            </div>
            <u class="float-right mb-2 font-12 text-info pointer popup-with-zoom-anim" href="#contact-add">Add Missing Contact</u>
          </div>
          <div class="mb-2">
            <input type="text" class="flat text-capitalize" name="subject" placeholder="Subject" required>
          </div>
          <div class="mb-2">
            <textarea name="message" class="summernote" placeholder="Message" required></textarea>
          </div>
          <hr class="mb-3">
          <div class="float-right">
            <a href="{{url()->previous()}}" class="btn btn-light radius-5 px-md-4 mr-2">Back</a>
            <button type="button" name="button" value="preview" class="btn btn-warning bold radius-5 px-md-4 mr-2">Preview</button>
            <button type="button" name="button" value="submit" class="btn btn-info radius-5 px-md-4">Process</button>
          </div>
          <div class="clearfix"></div>
        </div>
      </div>
    </div>
  </div>
</form>
<!-- MODAL CONTACT ADD -->
<div id="contact-add" class="zoom-anim-dialog mfp-hide dialog-with-tabs modal">
  <h4 class="m-0 pl-3 py-2 text-center bg-gradient text-white">Add Contact</h4>
  <div class="popup-tabs-container">
    <div class="popup-tab-content px-2 pb-2 pt-3" id="tab">
      <div class="px-4 pb-2" id="email-form">
        <div class="input-with-icon-left no-border">
          <i class="icon-feather-user"></i>
          <input type="text" class="input-text mb-3" name="name" placeholder="Name">
        </div>
        <div class="input-with-icon-left no-border">
          <i class="icon-feather-mail"></i>
          <input type="text" class="input-text mb-3" name="email" placeholder="Email">
        </div>
        <hr class="mb-3">
        <div class="row">
          <div class="col-12 text-right">
            <a href="javascript:void(0)" class="btn btn-transparent radius-5 text-dark mr-3 close-modal">Close</a>
            <a href="javascript:void(0)" class="btn btn-info radius-5" id="email-submit">Add To Contact</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- MODAL SELECT IMAGE -->
<div id="select-img" class="zoom-anim-dialog mfp-hide dialog-with-tabs modal">
  <!-- <h4 class="m-0 pl-3 py-2 text-center bg-gradient text-white">Add Contact</h4> -->
  <div class="popup-tabs-container">
    <div class="popup-tab-content px-0 py-2" id="tab">
    </div>
  </div>
</div>
<!-- MODAL PREVIEW -->
<div id="preview-modal" class="zoom-anim-dialog mfp-hide dialog-with-tabs modal">
  <!-- <h4 class="m-0 pl-3 py-2 text-center bg-gradient text-white">Add Contact</h4> -->
  <div class="popup-tabs-container">
    <div class="popup-tab-content px-0 pb-0 pt-4" id="tab">
    </div>
  </div>
</div>
@endsection
@section('js')
<script src="{{url('public')}}/select2/select2.min.js"></script>
<script src="{{url('public')}}/summernote/summernote-lite.js"></script>
<!-- MENU -->
<script type="text/javascript">
  $(document).ready(function() {
    $("#navigation").find('.current').removeClass('current');
    $("#navigation").find('li a[href="{{url("admin/marketing")}}"]:first').addClass('current');
    $("title").text("EMAIL BLAST");
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
    // MS
    $("select[name='email_id[]']").select2({
      'placeholder': 'Choose email contact',
      ajax: {
      url: "{{url('ajax_contact_email_select2')}}",
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
<!-- SWITCH CONTACT -->
<script type="text/javascript">
  $(document).on('change', 'input[name="contact"]', function(e) {
    var $this = $(e.target);
    if ($this.is(':checked')) {
      $('#contact-select2').hide();
    }else {
      $('#contact-select2').show();
      console.log($('#contact-select2'));
      $('#contact-select2').find(".select2-container").siblings('select:enabled').select2('open');
    }
  });
</script>
<!-- Add Email -->
<script type="text/javascript">
  $(document).on('click', '#email-submit', function() {
    var form = $('#email-form');
    var name = form.find('input[name="name"]').val();
    var email = form.find('input[name="email"]').val();
    $.post('{{url("admin/marketing/contact/email/store")}}', {
      _token:'{{csrf_token()}}',
      name:name,
      email:email
    }, function(data) {
      if (data.email) {
        $.magnificPopup.close();
        $('#email-form input[name="name"], #email-form input[name="email"]').val('');
        Snackbar.show({
          text: "Email contact has been added",
          textColor: '#fff',
          backgroundColor: 'blue'
        });
      }else {
        Snackbar.show({
      		text: data,
      		textColor: '#fff',
      		backgroundColor: '#e82a2a'
      	});
      }
    });
  });
</script>
<!-- Select Image -->
<script type="text/javascript">
  $(document).on('change', 'input[name="header_img"]', function(e) {
    if ($(this).is(':checked')) {
      $('#header_img').closest('.row').show();
    }else {
      $('#header_img').closest('.row').hide();
    }
  });
  function selectImg(){
    $.get('{{url("admin/master/banner/list")}}', function(data){
      $('#select-img .popup-tab-content').html($(data).find('#banner-list').get(0));
    });
  }
  $(document).on('click', '#banner-list li.page-item:not(".disabled")', function(e) {
    e.preventDefault();
    var $this = $(e.target);
    var url = $(this).find("a:first").attr("href");
    $.get(url, function(data){
      var html = $($.parseHTML(data));
      var item = html.find("#banner-list").html();
      $("#banner-list").html(item);
    });
  });
  function banner(banner_id){
    $.get("{{url('ajax_banner')}}/"+banner_id, function(data){
      var header = $('#header_img');
      header.find('input[name="banner_id"]').val(banner_id);
      header.find("#image-placeholder").attr('src', '{{url("public/images/banner")}}/'+data.image+'?{{time()}}').show();
      header.find("div[href='#select-img']").removeClass('badge-info').addClass('badge-warning').text('Change Image');
    });
    $.magnificPopup.close();
  }
</script>
<!-- SUBMIT -->
<script type="text/javascript">
  function formData(){
    var form = $('#form');
    var user = form.find('input[name="user"]').is(':checked');
    var contact = form.find('input[name="contact"]').is(':checked');
    var header_img = form.find('input[name="header_img"]').is(':checked');
    var banner_id = form.find('input[name="banner_id"]').val();
    var email_id = form.find('select[name="email_id[]"]').val();
    var subject = form.find('input[name="subject"]').val();
    var message = form.find('textarea[name="message"]').summernote('code');
    message = message.replace('<p><br></p>', '');
    var obj = {};
    obj['_token'] = '{{csrf_token()}}';
    if (user) { obj['user'] = user; }
    if (contact) { obj['contact'] = contact; }
    if (header_img && banner_id) {
      obj['image'] = banner_id;
    }
    if (email_id.length) { obj['email_id'] = email_id; }
    if (subject) { obj['subject'] = subject; }
    if (message) { obj['message'] = message; }
    return obj;
  }
  $(document).on('click', 'button[name="button"]', function(e) {
    var val = $(e.target).val();
    var request = formData();
    request['button'] = val;
    if (request.button == 'submit' && !request.subject) {
      $('#form').find('input[name="subject"]').trigger('focus');
      Snackbar.show({ text: 'Subject must be filled', textColor: '#fff', backgroundColor: '#e82a2a' });
    }else if (!request.message) {
      $('#form').find('textarea[name="message"]').parent().find('.note-editable').trigger('focus');
      Snackbar.show({ text: 'Message must be filled', textColor: '#fff', backgroundColor: '#e82a2a' });
    }
    if (request.message && request.button == 'preview') {
      $.post('{{url("admin/marketing/email/store")}}', request, function(data) {
        var html = $(data).find('div:first').parent().get(0);
        $('#preview-modal').find('.popup-tab-content').html(html);
        $.magnificPopup.open({
          items: { src: '#preview-modal' },
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
    }else if (request.subject && request.message && request.button == 'submit') {
      $('#page-loading').fadeIn();
      $.post('{{url("admin/marketing/email/store")}}', request, function(data) {
        $('#page-loading').fadeOut();
        Snackbar.show({ text: 'Email Sent', textColor: '#fff', backgroundColor: '#2a41e8' });
      });
    }
  });
</script>
@endsection
