<!doctype html>
<html lang="EN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Aspire</title>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <link rel="stylesheet" href="{{asset("/css/app.css")}}">

</head>
<body>
<div id="app" class="login-page">
    <div class="header">
        <img src="{{asset('images/logo-black.png')}}" class="logo" alt="Logo">
    </div>
    <div class="container">
        <form id="login-form" class="login-form" action="{{url('/login')}}" method="post">
            @csrf
            <div class="form-header text-center">
                <div>Login</div>
            </div>
            <div class="form-body">
                <div class="form-group">
                    <input name="email" id="email" class="form-control" type="text">
                    <label class="control-label" for="username">Username</label>
                </div>
                <div class="form-group">
                    <div class="unmask"><i class="fas fa-eye"></i></div>
                    <input name="password" id="password" class="form-control" type="password">
                    <label class="control-label" for="password">Password</label>
                </div>
                <div class="mt-2 mb-2">
                    <a href="#"><u>I forgot my password</u></a>
                </div>
                <button class="btn login-btn" type="submit" form="login-form" value="Submit">LOGIN</button>
            </div>
        </form>
    </div>
</div>
<script src="{{asset('/js/app.js')}}"></script>
<!-- Vendor Files -->
<link href="{{asset("vendor/select2/dist/css/select2.min.css")}}" rel="stylesheet" />
<script src="{{asset("vendor/select2/dist/js/select2.min.js")}}"></script>
<script src='{{asset("vendor/moment/moment.js")}}'></script>
<script src='{{asset("vendor/fullcalendar-3.10.0/fullcalendar.js")}}'></script>
</body>
</html>
