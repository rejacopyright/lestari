@extends('layouts.admin')
@section('css')
@endsection
@section('content')
<div class="container pt-3">
  <div class="row">
    <div class="col-md-4">
      <div class="border border-2 dash p-2 radius-5 mb-2">
        <div class="input-with-icon-left no-border">
          <i class="icon-material-outline-search"></i>
          <input type="text" class="input-text" id="email-search" placeholder="Search Contact Here">
        </div>
      </div>
      <div class="border border-2 dash p-2 radius-5" id="email-form">
        <h4 class="d-block bg-light py-2 mb-2 text-center">Add Email Contact</h4>
        <div class="input-with-icon-left no-border mb-2">
          <i class="icon-feather-user"></i>
          <input type="text" class="input-text" name="name" placeholder="Name">
        </div>
        <div class="input-with-icon-left no-border mb-2">
          <i class="icon-feather-mail"></i>
          <input type="text" class="input-text" name="email" placeholder="Email">
        </div>
        <a href="javascript:void(0)" class="btn btn-block btn-info radius-5" id="email-submit">Add To Contact</a>
      </div>
    </div>
    <div class="col-md-8" id="email-list">
      <div class="row">
        <?php foreach ($email as $mail): ?>
          <div class="glyph fs1 mt-0 mb-2 col-md col-6">
            <div class="clearfix bshadow0 pbs">
              <span class="icon-line-awesome-close pointer" onclick="remove({{$mail->email_id}})"></span>
              <span class="mls">
                <p class="m-0 lh-1 bold text-capitalize text-nowrap">{{$mail->name}}</p>
                <p class="m-0 lh-1 text-nowrap">{{$mail->email}}</p>
              </span>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
      <div class="row">
        <div class="col-12 mt-2 text-right">
          {{$email->appends(['q' => $q])->links()}}
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
<!-- Paginate -->
<script type="text/javascript">
  $(document).on('click', '#email-list li.page-item:not(".disabled")', function(event) {
    event.preventDefault();
    var url = $(this).find("a:first").attr("href");
    window.history.replaceState({},"",url);
    $.get(url, function(data){
      var html = $($.parseHTML(data));
      var item = html.find("#email-list").html();
      $("#email-list").html(item);
    });
  });
</script>
<!-- SEARCH -->
<script type="text/javascript">
  $(document).on('keyup change', '#email-search', function(e) {
    var val = $(e.target).val();
    $.get("{{url()->current()}}", {
      q:val
    }, function(data){
      var html = $($.parseHTML(data));
      var item = html.find("#email-list").html();
      $("#email-list").html(item);
    });
  });
</script>
<!-- Init -->
<script type="text/javascript">
  function el(){
    $.get("{{url()->current()}}", function(data){
      var item = $(data).find("#email-list").html();
      $("#email-list").html(item);
      $('#email-form input[name="name"], #email-form input[name="email"]').val('');
      $('#email-form input[name="name"]').trigger('focus');
    });
  }
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
        el();
      }else {
        Snackbar.show({ text: data, textColor: '#fff', backgroundColor: '#e82a2a' });
      }
    });
  });
</script>
<!-- Remove Email -->
<script type="text/javascript">
  function remove(email_id){
    $.post('{{url("admin/marketing/contact/email/delete")}}', {
      _token:'{{csrf_token()}}',
      email_id:email_id
    }, function(data) {
      el();
      Snackbar.show({
        text: data,
        textColor: '#fff',
        backgroundColor: '#2a41e8'
      });
    });
  }
</script>
@endsection
