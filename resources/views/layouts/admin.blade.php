<!doctype html>
<html lang="en">
<?php $company = App\setting::first(); ?>
<head>
<title>LESTARI ELECTRIC</title>
<meta charset="utf-8">
<meta name="google" content="notranslate">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<link rel="icon" type="image/*" href="{{url('public')}}/images/logo.png" />
<!-- CSS -->
<link rel="stylesheet" href="{{url('public')}}/css/style-admin.css">
<link rel="stylesheet" href="{{url('public')}}/css/rj-custom.css">
<link rel="stylesheet" href="{{url('public')}}/css/colors/blue.css">
<script data-ad-client="ca-pub-8246673022396118" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
@yield('css')
</head>
<body>
<div id="wrapper">
  <header id="header-container" class="fullwidth">
    <div id="header" class="px-0 pb-0">
      <div class="container">
        <div class="row px-lg-5">
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
                          {{auth::guard('admin')->user()->nama}} <span>{{auth::guard('admin')->user()->username}}</span>
                        </div>
                      </div>
                      <!-- <div class="status-switch" id="snackbar-user-status">
                        <label class="user-online current-status">Online</label>
                        <label class="user-invisible">Invisible</label>
                        <span class="status-indicator" aria-hidden="true"></span>
                      </div> -->
                    </div>
                    <ul class="user-menu-small-nav">
                      <li><a href="{{url('admin/company')}}"><i class="icon-material-outline-settings"></i> Company</a></li>
                      <li><a href="{{url('admin/profile')}}"><i class="icon-feather-user"></i> Profile</a></li>
                      <li><a href="{{url('admin/logout')}}"><i class="icon-material-outline-power-settings-new"></i> Logout</a></li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-auto text-center pt-2 pr-1 pl-3 d-block d-lg-none">
            <a href="javascript:void(0)" class="icon-feather-menu font-24 text-info" id="menu-mobile"></a>
          </div>
        </div>
      </div>
      <div class="container mt-2 bg-img-1 d-none d-lg-flex pt-2 pb-1">
        <div class="left-side">
          <nav id="navigation">
            <ul id="responsive">
              <li><a href="{{url('admin')}}">Home</a> </li>
              <li><a href="javascript:void(0)" class="master-li">Master</a>
                <ul class="dropdown-nav">
                  <li><a href="{{url('admin/product/type')}}">Type</a></li>
                  <li><a href="{{url('admin/product/brand')}}">Brand</a></li>
                  <li><a href="{{url('admin/product/master/spec')}}">Spec Master</a></li>
                  <li><a href="{{url('admin/master/banner')}}">Banner</a></li>
                </ul>
              </li>
              <li><a href="{{url('admin/product')}}">Product</a>
                <ul class="dropdown-nav">
                  <li><a href="{{url('admin/product')}}">Product</a></li>
                  <li><a href="{{url('admin/product/series')}}">Series</a></li>
                  <li><a href="{{url('admin/product/spec')}}">Spec</a></li>
                </ul>
              </li>
              <li><a href="javascript:void(0)" class="setting-li">Settings</a>
                <ul class="dropdown-nav">
                  <li><a href="{{url('admin/about')}}">About Us</a></li>
                  <li><a href="{{url('admin/vision')}}">Vision</a></li>
                  <li><a href="{{url('admin/mission')}}">Mission</a></li>
                </ul>
              </li>
              <li><a href="{{url('admin/news')}}">News</a> </li>
              <li><a href="{{url('admin/promo')}}">Promo</a> </li>
              <li><a href="{{url('admin/marketing')}}">Marketing</a> </li>
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
  <div class="content pb-3">
    @yield('content')
  </div>
  <div id="footer">
    <div class="footer-bottom-section">
      <div class="container">
        <div class="row">
          <div class="col-xl-12">
            © {{date('Y')}} <strong>{{$company->name}}</strong>. All Rights Reserved.
          </div>
        </div>
      </div>
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
  $(document).on('click', '.close-modal', function() {
    $.magnificPopup.close();
  });
</script>
<!-- Snackbar // documentation: https://www.polonel.com/snackbar/ -->
<script>
  // Snackbar for user status switcher
  $('#snackbar-user-status label').click(function() {
  	Snackbar.show({
  		text: 'Your status has been changed!',
  		pos: 'bottom-center',
  		showAction: false,
  		actionText: "Dismiss",
  		duration: 3000,
  		textColor: '#fff',
  		backgroundColor: '#2a41e8'
  	});
  });
  $(document).on('click', '#menu-mobile', function() {
    $(".hamburger-box").trigger('click');
  });
</script>
<!-- POPUP -->
<script type="text/javascript">
  $(document).on('click', '.popup-with-zoom-anim', function(e) {
    var $this = $(e.target);
    $.magnificPopup.instance._onFocusIn = function(e) {
      return true;
    };
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
</script>
<!-- TIPPY -->
<script type="text/javascript">
  $(document).on('mouseover', function() {
    tippy('[data-tippy-placement]', {arrow:true});
  });
</script>
<!-- Summernote Image Upload -->
<script type="text/javascript">
  // $(document).on('click', ".note-Insert button[aria-label='Picture']", function() {
  //   $(".note-image-input").trigger('click');
  // });
</script>
</body>
<!-- SEARCH -->
<script type="text/javascript">
  var timeout = null;
  $(document).on('keyup focus', '#search-here', function(e) {
    var q = $(this).val();
    if (q) { $('#search-here').parent().find('.icon-container').show(); }
    clearTimeout(timeout);
    timeout = setTimeout(function () {
      $.get('{{url("ajax_search_admin")}}', {q}, function(data){
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
</body>
</html>
