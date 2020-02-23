<!doctype html>
<html lang="en">
<head>
<title>Lestari Electric</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<link rel="icon" type="image/*" href="{{url('public')}}/images/logo.png" />
</head>
<body style="background-color: #f5f5f5;margin: 0;font-family: 'Roboto';">
  <div style="padding: 0 5%;">
    <!-- Header -->
    @include('mail.header')
    <?php if (in_array('image', $element)): ?>
      @include('mail.image')
    <?php endif; ?>
    <?php if (in_array('gallery', $element)): ?>
      @include('mail.gallery')
    <?php endif; ?>
    <div style="display: -webkit-box; display: -ms-flexbox; display: flex; -ms-flex-wrap: wrap; flex-wrap: wrap;-ms-align-items: center;align-items: center;background: #fff;padding: 1rem;">
      <div style="width: 100%;-webkit-box-sizing: border-box;box-sizing: border-box;position: relative;-webkit-flex: 0;-ms-flex: 0 0 100%;flex: 0 0 100%;">
        {!! $content !!}
      </div>
    </div>
    <!-- FOOTER -->
    @include('mail.footer')
  </div>
</body>
</html>
