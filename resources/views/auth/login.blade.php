<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin | Login</title>
  <link rel="icon" type="image/png" sizes="16x16" href="{{url('public')}}/images/favicon.png">
  <link rel="stylesheet" type="text/css" href="{{url('public/login')}}/css/iofrm-style.css">
  <link href="{{url('public')}}/css/style-admin.css" rel="stylesheet">
  <link href="{{url('public')}}/css/rj-custom.css" rel="stylesheet">
  <link href="{{url('public')}}/css/colors/gradient.css" rel="stylesheet">
  <style media="screen">
    /* input:-webkit-autofill, input:-webkit-autofill:hover, input:-webkit-autofill:focus input:-webkit-autofill, textarea:-webkit-autofill, textarea:-webkit-autofill:hover textarea:-webkit-autofill:focus, select:-webkit-autofill, select:-webkit-autofill:hover, select:-webkit-autofill:focus { /* border: none !important; */ /* -webkit-text-fill-color: white !important; */ -webkit-box-shadow: unset inset; transition: background-color 5000s ease-in-out 0s; } */
  </style>
</head>
<body>
  <div class="form-body" class="container-fluid">
    <div class="row">
      <div class="img-holder min-vh-100 col-md-6 m-0">
        <div class="bg"></div>
        <div class="info-holder">
          <img class="w-75" src="{{url('public/login')}}/images/graphic2.svg" alt="">
        </div>
      </div>
      <div class="form-holder col-md-6 m-0">
        <div class="form-content">
          <div class="form-items row">
            <div class="col-4 offset-4 text-center mb-3">
              <div class="">
                <div class="w-100 text-center">
                  <img src="{{url('public')}}/images/logo.png" alt="">
                </div>
              </div>
            </div>
            <!-- <h1>{{ltrim("TEST0000001023", "TEST0")}}</h1> -->
            <p class="text-center font-16"><a href="{{url('/')}}" class="text-purple strong">{{config('app.name')}}</a> | <span class="teks">Login</span></p>
            <form id="login-form" class="form-auth-small mb-0 animated swing" method="POST" action="{{ url('admin/login') }}">
              @csrf
              <div class="input-with-icon-left no-border mb-2">
                <i class="icon-line-awesome-user"></i>
                <input type="text" name="username" class="input-text" placeholder="Username" required>
              </div>
              <div class="input-with-icon-left no-border mb-2">
                <i class="icon-line-awesome-unlock-alt"></i>
                <input type="password" name="password" class="input-text" placeholder="Password" required>
              </div>
              <div class="form-button text-center">
                <button type="submit" class="button w-100 gray ripple-effect button-sliding-icon text-white">Login <i class="icon-feather-arrow-right ml-2"></i></button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script type="text/javascript" src="{{url('public/login')}}/js/jquery.min.js"></script>
  <script type="text/javascript">
    $(document).ready(function() {
      $("#login-form").find("input[name='username']").focus();
    });
  </script>
</body>
</html>
