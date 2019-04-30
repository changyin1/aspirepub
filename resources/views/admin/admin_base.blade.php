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
    <link rel='stylesheet' href='{{asset("vendor/fullcalendar-3.10.0/fullcalendar.css")}}' />
    <link rel="stylesheet" href="{{asset("vendor/jquery-ui-1.12.1/jquery-ui.css")}}">
    <link rel="stylesheet" href="{{asset("/css/app.css")}}">
    <script src="{{asset('/js/app.js')}}"></script>
</head>
<body>
<div id="app">
    <div class="header">
        @include('partials.header')
    </div>
    <div class="content-container row">
        <div class="col-2">
            @include('admin.partials.sidebar')
        </div>
        <div class="col-10">
            @yield('content')
        </div>
        @include('admin.modals.success_modal')
    </div>
</div>
<!-- Vendor Files -->
<link href="{{asset("vendor/select2/dist/css/select2.min.css")}}" rel="stylesheet" />
<script src="{{asset("vendor/select2/dist/js/select2.min.js")}}"></script>
<script src='{{asset("vendor/moment/moment.js")}}'></script>
<script src='{{asset("vendor/fullcalendar-3.10.0/fullcalendar.js")}}'></script>
<script src='{{asset("vendor/jquery-ui-1.12.1/jquery-ui.js")}}'></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">

<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
</body>
</html>