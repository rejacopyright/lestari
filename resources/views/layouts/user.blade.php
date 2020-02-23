<!doctype html>
<html lang="en">
<?php $company = App\setting::first(); ?>
<head>
<title>@yield('title')</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<link rel="icon" type="image/*" href="{{url('public')}}/images/logo.png" />
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-151132437-1"></script>
<script data-ad-client="ca-pub-8246673022396118" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', 'UA-151132437-1');
</script>
<!-- CSS -->
<link rel="stylesheet" href="{{url('public')}}/css/style-admin.css">
<link rel="stylesheet" href="{{url('public')}}/css/rj-custom.css">
<link rel="stylesheet" href="{{url('public')}}/css/colors/blue.css">
@yield('css')
</head>
<body>
<div id="wrapper">
  <header id="header-container" class="fullwidth">
    <div id="header" class="px-0 pb-0">
      <div class="container">
        <div class="row px-lg-5 px-2">
          <div class="col d-none d-md-block">
            <div id="logo" class="d-flex align-items-center">
              <a href="{{url('/')}}">
                <img src="{{url('public')}}/images/logo.png?{{time()}}" class="mr-1">
                <h6 class="text-uppercase d-none d-md-inline bold text-info m-0">{{$company->alias}}</h6>
              </a>
            </div>
          </div>
          <div class="col text-center">
            <div class="input-with-icon-left no-border">
              <i class="icon-material-outline-search"></i>
              <input type="text" id="search-here" class="input-text w-100" placeholder="Search brand or product">
              <div class="icon-container" style="display: none;">
                <span class="loader"></span>
              </div>
            </div>
            <div id="search-card" class="text-left shadow-md font-14 position-absolute z-1 bg-white radius-5" style="display: none;">
            </div>
          </div>
          <div class="col-md ml-3 ml-md-0 col-auto text-right">
            <div class="right-side header-notifications user-menu">
              <?php if (auth::guard('web')->check() == true): ?>
                <?php $user = auth::guard('web')->user(); ?>
                <div class="header-notifications-trigger">
                  <a href="#"><div class="user-avatar status-online"><img src="{{url('public')}}/images/user.png" alt=""></div></a>
                </div>
                <div class="header-widget">
                  <div class="header-notifications user-menu">
                    <div class="header-notifications-dropdown">
                      <div class="user-status">
                        <div class="user-details">
                          <div class="user-avatar status-online"><img src="{{url('public')}}/images/user.png" alt=""></div>
                          <div class="user-name">
                            {{$user->name ? ucwords($user->username) : strtolower($user->username)}} <span>{{$user->name ? strtolower($user->username) : strtolower($user->email)}}</span>
                          </div>
                        </div>
                      </div>
                      <ul class="user-menu-small-nav">
                        <li><a href="{{url('user/logout')}}"><i class="icon-material-outline-power-settings-new"></i> Logout</a></li>
                      </ul>
                    </div>
                  </div>
                </div>
              <?php else: ?>
                <a href="#login-dialog" class="btn btn-info-light radius-5 px-md-4 popup-with-zoom-anim">Login</a>
              <?php endif; ?>
            </div>
          </div>
          <div class="col-auto text-center pt-2 pr-1 pl-3 d-inline d-lg-none">
            <a href="javascript:void(0)" class="icon-feather-menu font-24 text-info" id="menu-mobile"></a>
          </div>
        </div>
      </div>
      <div class="container mt-2 bg-img-1 d-none d-lg-flex pt-2 pb-1">
        <div class="left-side">
          <nav id="navigation">
            <ul id="responsive">
              <li><a href="{{url('/')}}" class="current">Home</a> </li>
              <li><a href="javascript:void(0)" class="product-li">Product</a>
                <ul class="dropdown-nav">
                  <?php foreach (App\product_brand::get() as $br): ?>
                    <li><a href="{{url('product')}}?brand_id={{$br->brand_id}}" class="text-uppercase">{{$br->name}}</a></li>
                  <?php endforeach; ?>
                </ul>
              </li>
              <!-- <li><a href="{{url('product')}}">Product</a> </li> -->
              <li><a href="{{url('about')}}">About Us</a> </li>
              <li><a href="{{url('news')}}">News</a> </li>
              <li><a href="{{url('promo')}}">Promo</a> </li>
              <li><a href="{{url('contact')}}">Contact</a> </li>
            </ul>
          </nav>
          <div class="clearfix"></div>
        </div>
        <div class="right-side d-none">
          <span class="mmenu-trigger">
            <button class="hamburger hamburger--collapse" type="button">
              <span class="hamburger-box"> <span class="hamburger-inner"></span> </span>
            </button>
          </span>
        </div>
      </div>
    </div>
  </header>
  <div class="clearfix"></div>
  <div class="content pb-3" id="html">
    <div id="page-loading" style="display: none;">
      <div class="three-balls">
        <div class="ball-text">Sending Message</div>
        <div class="ball ball1"></div>
        <div class="ball ball2"></div>
        <div class="ball ball3"></div>
      </div>
    </div>
    @yield('content')
  </div>
  <div id="footer">
    <div class="footer-middle-section">
      <div class="container">
        <div class="row">
          <div class="col-lg col-md-3 col-6">
            <div class="footer-links">
              <h3>Support</h3>
              <ul>
                <li><a href="{{url('contact')}}"><span>Contact</span></a></li>
                <li><a href="https://api.whatsapp.com/send?phone={{'62'.ltrim(App\setting::first()->whatsapp, '0')}}" target="_blank"><span>Whatsapp</span></a></li>
              </ul>
            </div>
          </div>
          <div class="col-lg col-md-3 col-6">
            <div class="footer-links">
              <h3>Privacy</h3>
              <ul>
                <li><a href="{{url('privacy')}}" target="_blank"><span>Privacy Policy</span></a></li>
                <li><a href="{{url('terms')}}" target="_blank"><span>Terms of Use</span></a></li>
              </ul>
            </div>
          </div>
          <div class="col-lg col-md-3 col-6">
            <div class="footer-links">
              <h3>Account</h3>
              <ul>
                <?php if (auth::guard('web')->check() == true): ?>
                  <li><a href="javascript:void(0)" data-tippy-placement="left" title="{{auth::guard('web')->user()->username}}<hr class='m-0'>{{auth::guard('web')->user()->email}}"><span>You logged in</span></a></li>
                  <li><a href="{{url('user/logout')}}"><span>Log Out</span></a></li>
                <?php else: ?>
                  <li><a href="#login-dialog" class="popup-with-zoom-anim"><span>Log In</span></a></li>
                <?php endif; ?>
              </ul>
            </div>
          </div>
          <div class="col-lg-auto col-12">
            <h3><i class="icon-feather-mail"></i> Sign Up For a Newsletter</h3>
            <!-- <p>Weekly breaking news, analysis and cutting edge advices on job searching.</p> -->
            <form action="#" method="get" class="newsletter subscribe-form">
  						<input type="email" name="email" class="text-white subscribe-input" placeholder="Enter your email address">
  						<button type="button" class="subscribe-btn"><i class="icon-feather-arrow-right"></i></button>
  					</form>
          </div>
        </div>
      </div>
    </div>
    <div class="footer-bottom-section">
      <div class="container">
        <div class="row">
          <div class="col-xl-12">
            © {{date('Y')}} <strong>Corporation</strong>. All Rights Reserved.
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- LOGIN MODAL -->
<div id="login-dialog" class="zoom-anim-dialog mfp-hide dialog-with-tabs modal">
  <h4 class="m-0 pl-3 py-2 text-center bg-gradient text-white" id="login-title">Login</h4>
  <div class="popup-tabs-container">
    <div class="popup-tab-content pb-3 pt-3" id="tab">
      <form id="login-form" class="form-auth-small mb-0 animated swing" method="POST" action="{{ url('user/login') }}">
        @csrf
        <div class="input-with-icon-left no-border">
          <i class="icon-material-outline-email"></i>
          <input type="email" name="email" class="mb-2" placeholder="Email" style="display: none;">
        </div>
        <div class="input-with-icon-left no-border">
          <i class="icon-line-awesome-user"></i>
          <input type="text" name="username" class="mb-2" placeholder="Username" required>
        </div>
        <div class="input-with-icon-left no-border">
          <i class="icon-line-awesome-unlock-alt"></i>
          <input type="password" name="password" class="mb-2" placeholder="Password" required>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-button text-center">
              <button type="button" id="register-btn" class="btn bg-transparent mt-1 w-100 button-sliding-icon text-info">Register <i class="icon-feather-arrow-right ml-2"></i></button>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-button text-center">
              <button type="submit" id="login-btn" class="btn btn-info mt-1 w-100 button-sliding-icon text-white">Login <i class="icon-feather-check ml-2"></i></button>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- Scripts -->
<script src="{{url('public')}}/js/jquery-3.3.1.min.js"></script>
<script src="{{url('public')}}/js/jquery-migrate-3.0.0.min.js"></script>
<script src="{{url('public')}}/js/mmenu.min.js"></script>
<script src="{{url('public')}}/js/tippy.all.min.js"></script>
<script src="{{url('public')}}/js/simplebar.min.js"></script>
<script src="{{url('public')}}/js/bootstrap-slider.min.js"></script>
<script src="{{url('public')}}/js/bootstrap-select.min.js"></script>
<script src="{{url('public')}}/js/snackbar.js"></script>
<script src="{{url('public')}}/js/clipboard.min.js"></script>
<script src="{{url('public')}}/js/counterup.min.js"></script>
<script src="{{url('public')}}/js/magnific-popup.min.js"></script>
<script src="{{url('public')}}/js/slick.min.js"></script>
<script src="{{url('public')}}/js/custom.js"></script>
@yield('js')
<script type="text/javascript">
  $(document).ready(function() { $("#wrapper").css('padding-top', ($("#header").height() + 5)); });
  $(window).resize(function() { $("#wrapper").css('padding-top', ($("#header").height() + 5)); });
  $(document).ready(function(){ $(".bg-img-1, #footer").css({'background-image': 'url("{{url("public")}}/images/bg/h2.jpg")', 'background-size': 'cover', 'background-repeat': 'no-repeat'}); });
  $('[bg]').each(function(e){ $(this).css({'background-color': $(this).attr('bg')}); });
  $(document).on('mouseover', function() { tippy('[data-tippy-placement]', {arrow:true}); });
</script>
<script type="text/javascript">
  $('#snackbar-user-status label').click(function() {
  	Snackbar.show({
  		text: 'Your status has been changed!',
  		pos: 'bottom-center',
  		showAction: false,
  		actionText: "Dismiss",
  		duration: 3000,
  		textColor: '#fff',
  		backgroundColor: '#383838'
  	});
  });
  $(document).on('click', '#menu-mobile', function() {
    $(".hamburger-box").trigger('click');
  });
</script>
<!-- AUTH -->
<script type="text/javascript">
  $(document).on('click', '#register-btn', function(e) {
    var $this = $(e.target);
    $('#register-btn').closest('.col-md-6').appendTo($this.closest('.row')).find('button').removeClass('bg-transparent text-info').addClass('btn-info text-white').attr('type', 'submit');
    $('#login-btn').removeClass('btn-info text-white').addClass('btn-transparent text-info').attr('type', 'button');
    $('#login-form').find('input[name="email"]').show().prop('required', true);
    $('#login-title').text('Register');
    $('#login-form').attr('action', "{{ url('user/register') }}");
  });
  $(document).on('click', '#login-btn', function(e) {
    var $this = $(e.target);
    $('#login-btn').closest('.col-md-6').appendTo($this.closest('.row')).find('button').removeClass('bg-transparent text-info').addClass('btn-info text-white').attr('type', 'submit');
    $('#register-btn').removeClass('btn-info text-white').addClass('btn-transparent text-info').attr('type', 'button');
    $('#login-form').find('input[name="email"]').hide().prop('required', false);
    $('#login-title').text('Login');
    $('#login-form').attr('action', "{{ url('user/login') }}");
  });
</script>
<!-- SEARCH -->
<script type="text/javascript">
  var timeout = null;
  $(document).on('keyup focus', '#search-here', function(e) {
    var q = $(this).val();
    if (q) { $('#search-here').parent().find('.icon-container').show(); }
    clearTimeout(timeout);
    timeout = setTimeout(function () {
      $.get('{{url("ajax_search")}}', {q}, function(data){
        $('#search-here').parent().find('.icon-container').hide();
        var template = '';
        if (q && data.length) {
          var product_name = brand_name = series_name = '';
          for (var i = 0; i < data.length; i++) {
            if (data[i].brand_name) {
              brand_name = '<span class="text-info">'+data[i].brand_name+'</span>' || '';
            }
            if (data[i].product_name) {
              product_name = '<span class="icon-line-awesome-arrow-circle-right mx-1"></span> <span class="text-success">'+data[i].product_name+'</span>' || '';
            }
            if (data[i].series_name) {
              series_name = '<span class="icon-line-awesome-arrow-circle-right mx-1"></span> <span class="text-dark bold">'+data[i].series_name+'</span>' || '';
            }
            template +=
            '<a class="d-flex align-items-center search-item border-bottom py-1 px-3" href="'+data[i].link+'">'+
              '<div class="col-auto wpx-50 p-1 mr-2"> <img src="'+data[i].img+'" alt="" class="w-100 radius-5"> </div>'+
              '<div class="col px-0">'+brand_name+product_name+series_name+'</div>'+
            '</a>';
          }
          $('#search-card').html(template);
        }else if(q) {
          var empty = '<div class="row search-item"><div class="col-12 text-center py-3"> Unable to find seacrh result </div></div>';
          $('#search-card').html(empty);
        }else {
          $('#search-card').html('').hide();
        }
        $('#search-card').show();
      });
    }, 150);
  });
  $(document).on('blur', '#search-here', function(e) {
    if ($(e.originalEvent.relatedTarget).hasClass('search-item') == false) {
      $('#search-card').hide();
    }
  });
</script>
<!-- SUBSCRIBE -->
<script type="text/javascript">
  function capitalize(str){
    return str.replace(/\b[a-z]/g, function(i) { return i.toUpperCase()});
  }
  $(document).on('click', '.subscribe-btn', function(e) {
    var form = $(this).closest('.subscribe-form');
    var email = form.find('.subscribe-input').val();
    var name = email.split('@')[0];
    name = name.replace(/[^A-Za-z]/g, ' ');
    name = capitalize(name);
    if (email) {
      $.post('{{url("admin/marketing/contact/email/store")}}', {
        _token:'{{csrf_token()}}',
        name:name,
        email:email
      }, function(data) {
        if (data.email) {
          Snackbar.show({ text: 'Thank you for subscribing', textColor: '#fff', backgroundColor: '#2a41e8' });
        }else {
          Snackbar.show({ text: data, textColor: '#fff', backgroundColor: '#e82a2a' });
        }
      });
    }else {
      Snackbar.show({ text: 'Email must be filled', textColor: '#fff', backgroundColor: '#e82a2a' });
    }
  });
</script>
</body>
</html>
