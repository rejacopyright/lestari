@extends('layouts.user')
@section('title') CONTACT @endsection
@section('css')
<meta http-equiv="Content-Language" content="id" />
<meta property="og:title" content="CONTACT"/>
<meta property="og:description" content="CONTACT"/>
<meta name="description" content="CONTACT"/>
<meta property="og:type" content="image/jpeg"/>
<meta property="og:url" content="{{url()->full()}}"/>
<meta property="og:site_name" content="{{url('/')}}"/>
@endsection
@section('content')
<div class="container mt-5">
  <!-- WHATSAPP -->
  <div class="position-fixed r-1 b-1 pointer z-999">
    <a href="https://api.whatsapp.com/send?phone=62{{ltrim(App\setting::first()->whatsapp, '0')}}" target="_blank" class="btn square-50 radius-50" bg="#4bc25a" data-tippy-placement="left" title="Ask Something"><i class="icon-brand-whatsapp text-white font-24 lh-13"></i></a>
  </div>
  <h2 class="mb-3 bg-gray py-2 px-3">Contact Us</h2>
	<div class="row">
		<div class="col-12">
			<div class="contact-location-info mb-2 shadow-lg">
				<div class="contact-address border-0">
					<ul class="text-dark font-16">
						<li class="contact-address-headline text-dark bold">Our Office</li>
						<li>{{$setting->address}}</li>
						<li><a href="tel:{{$setting->contact}}">{{$setting->contact}}</a></li>
						<li><a href="https://mail.google.com/mail/?view=cm&fs=1&to={{$setting->email}}" target="_blank" class="text-info">{{$setting->email}}</a></li>
						<li>
              <div class="freelancer-socials">
                <ul>
                  <li><a href="{{$setting->facebook ?? 'javascript:void(0)'}}" target="{{$setting->facebook ? '_blank' : '_self'}}" title="Facebook" data-tippy-placement="top" class="pl-md-0"><i class="icon-brand-facebook"></i></a></li>
                  <li><a href="{{$setting->twitter ?? 'javascript:void(0)'}}" target="{{$setting->twitter ? '_blank' : '_self'}}" title="Twitter" data-tippy-placement="top"><i class="icon-brand-twitter"></i></a></li>
                  <li><a href="{{$setting->instagram ?? 'javascript:void(0)'}}" target="{{$setting->instagram ? '_blank' : '_self'}}" title="Instagram" data-tippy-placement="top"><i class="icon-brand-instagram"></i></a></li>
                  <li><a href="{{$setting->youtube ?? 'javascript:void(0)'}}" target="{{$setting->youtube ? '_blank' : '_self'}}" title="Youtube" data-tippy-placement="top"><i class="icon-brand-youtube"></i></a></li>
                </ul>
              </div>
						</li>
					</ul>
				</div>
				<div id="single-job-map-container">
          <iframe class="w-100 h-100" frameborder="0" style="border:0" src="https://www.google.com/maps/embed/v1/place?key=AIzaSyDh-NAgEaJdCHZKt5CjzUV4BFuQs8B2XAk &q=Lestari Electric. CV" allowfullscreen> </iframe>
				</div>
			</div>
		</div>
    <div class="col-12 mt-3 text-center">
      @include('layouts.ads.horizontal')
    </div>
		<div class="col-lg-8 offset-lg-2">
			<section id="contact" class="mb-2">
				<h3 class="headline my-3">Any questions? Feel free to contact us!</h3>
				<form method="post" name="contactform" id="contactform" autocomplete="on">
					<div class="row">
						<div class="col-md-6">
							<div class="input-with-icon-left">
								<input class="with-border" name="name" type="text" id="name" placeholder="Your Name" required="required" />
								<i class="icon-material-outline-account-circle"></i>
							</div>
						</div>
						<div class="col-md-6">
							<div class="input-with-icon-left">
								<input class="with-border" name="email" type="email" id="email" placeholder="Email Address" pattern="^[A-Za-z0-9](([_\.\-]?[a-zA-Z0-9]+)*)@([A-Za-z0-9]+)(([\.\-]?[a-zA-Z0-9]+)*)\.([A-Za-z]{2,})$" required="required" />
								<i class="icon-material-outline-email"></i>
							</div>
						</div>
					</div>
					<div class="input-with-icon-left">
						<input class="with-border" name="subject" type="text" id="subject" placeholder="Subject" required="required" />
						<i class="icon-material-outline-assignment"></i>
					</div>
					<div>
						<textarea class="with-border" name="message" cols="40" rows="5" id="message" placeholder="Message" spellcheck="true" required="required"></textarea>
					</div>
					<input type="button" class="submit button text-white mt-3 float-right d-inline-block w-auto" id="submit" value="Submit Message" />
				</form>
			</section>
		</div>
	</div>
</div>
@endsection
@section('js')
<script type="text/javascript">
  $(document).ready(function() {
    $("#navigation").find('.current').removeClass('current');
    $("#navigation").find('li a[href="{{url("contact")}}"]:first').addClass('current');
  });
</script>
<!-- Contact Form -->
<script type="text/javascript">
  function param(){
    var name = $('#name').val();
    var email = $('#email').val();
    var subject = $('#subject').val();
    var message = $('#message').val();
    var request = {'_token':'{{csrf_token()}}'}
    if (name) { request['name'] = name; }
    if (email) { request['email'] = email; }
    if (subject) { request['subject'] = subject; }
    if (message) { request['message'] = message; }
    if (!name || !email || !subject || !message) {
      Snackbar.show({ text: 'All field must be filled', textColor: '#fff', backgroundColor: '#e82a2a' });
    }
    return request;
  }
  $(document).on('click', '#submit', function(e) {
    var newsletter = param();
    if (newsletter.name && newsletter.email && newsletter.subject && newsletter.message) { $('#page-loading').fadeIn(); }
    $.post('{{url("contact/submit")}}', param(), function(data) {
      $('#name, #email, #subject, #message').val('');
      $('#page-loading').fadeOut();
      Snackbar.show({ text: 'Message Sent', textColor: '#fff', backgroundColor: '#2a41e8' });
    });
  });
</script>
@endsection
