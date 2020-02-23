<!doctype html>
<html lang="en">
<head>
<title>Lestari Electric</title>
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
  <div class="clearfix"></div>
  <div class="content pb-3">
    @yield('content')
  </div>
</div>
@yield('js')
</body>
</html>
