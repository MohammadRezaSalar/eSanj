<!doctype html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="/includes/images/logo3.ico" type="image/x-icon" />
    @vite(['resources/js/app.js'])
    <title>@yield('pageTitle')</title>
    <link rel="stylesheet" href="/includes/css/toastr.min.css">
    <link rel="stylesheet" href="/includes/css/styles.css">
    <link rel="stylesheet" href="/includes/fonts/bx-fonts/css/boxicons.min.css">
    <link rel="stylesheet" href="/includes/css/material-icon.css">
    <link rel="stylesheet" href="/includes/css/bootstrap-material-datetimepicker.css">
    <link rel="stylesheet" href="/includes/css/sidebar.css">
    <link rel="stylesheet" href="/includes/css/my-styles.css">
    <livewire:styles />
</head>
<body>
<div id="my-preloader" style="display: none">
    <div id="my-loader"></div>
</div>
<div id="main-wrapper" class="show">
    @include('admin.layouts.sidebar')
    <div id="topOfPage"></div>
    <div class="content-body pt-0" style="min-height: auto !important;">
        <div class="header__toggle">
            <i class='bx bx-menu' id="header-toggle"></i>
        </div>
        <div class="container-fluid">
            @yield('content')
        </div>
    </div>
</div>

<livewire:scripts />
<script src="/includes/js/jquery.min.js"></script>
<script src="/includes/js/bootstrap.min.js"></script>
<script src="/includes/js/converter.js"></script>
<script src="/includes/js/moment.min.js"></script>
<script src="/includes/js/bootstrap-material-datetimepicker.js"></script>
<script src="/includes/js/fa-moment.min.js"></script>
<script src="/includes/js/fa-boot.min.js"></script>
<script src="/includes/js/sweetalert2.js"></script>
<script src="/includes/js/toastr.min.js"></script>
<script src="/includes/js/global-functions.js"></script>
<script src="/includes/js/scripts.js"></script>
<script src="/includes/js/sidebar.js"></script>
<script>
    // window.onload=function(){
    //     Echo.channel('tasks-channel')
    //         .listen('Admin\\Tasks\\AddNewTask', e => {
    //             console.log('successfully receive event')
    //         })
    // }
</script>
</body>
</html>
