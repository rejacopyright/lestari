@extends('layouts.admin')
@section('css')
@endsection
@section('content')
<div class="container pt-3">
  <div class="row">
    <div class="glyph fs1 col-md-3">
      <div class="clearfix bshadow0 pbs pointer" onclick="window.location.href = '{{url('admin/marketing/contact/email')}}'">
        <span class="icon-feather-user"> </span>
        <span class="mls">Email Contact</span>
      </div>
    </div>
    <div class="glyph fs1 col-md-3">
      <div class="clearfix bshadow0 pbs pointer" onclick="window.location.href = '{{url('admin/marketing/email')}}'">
        <span class="icon-feather-mail"> </span>
        <span class="mls">Email Blast</span>
      </div>
    </div>
    <div class="glyph fs1 col-md-3">
      <div class="clearfix bshadow0 pbs pointer popup-with-zoom-anim" href="#whatsapp">
        <span class="icon-brand-whatsapp" href="#whatsapp"> </span>
        <span class="mls" href="#whatsapp">Whatsapp Blast</span>
      </div>
    </div>
  </div>
</div>
<!-- MODAL WHATSAPP -->
<div id="whatsapp" class="zoom-anim-dialog mfp-hide dialog-with-tabs modal">
  <h4 class="m-0 pl-3 py-2 text-center bg-gradient text-white">Whatsapp Blast</h4>
  <div class="popup-tabs-container">
    <div class="popup-tab-content p-2" id="tab">
      <div class="row">
        <div class="col-12">
          <textarea name="whatsapp" class="flat" rows="6" placeholder="Text Message" required></textarea>
          <hr>
          <div class="py-2 px-4 float-right text-white bold font-16 radius-30 pointer" bg="#46c156" onclick="whatsapp()"><i class="icon-brand-whatsapp mr-2"></i>Send</div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@section('js')
<!-- MENU -->
<script type="text/javascript">
  $(document).ready(function() {
    $("#navigation").find('.current').removeClass('current');
    $("#navigation").find('li a[href="{{url("admin/marketing")}}"]:first').addClass('current');
    $("title").text("MARKETING");
  });
</script>
<!-- Send Whatsapp -->
<script type="text/javascript">
  function whatsapp(){
    var msg = $('textarea[name="whatsapp"]').val();
    if (msg) {
      window.open('https://api.whatsapp.com/send?text='+msg);
    }else {
      Snackbar.show({ text: 'Message must be filled', textColor: '#fff', backgroundColor: '#e82a2a' });
    }
  }
</script>
@endsection
