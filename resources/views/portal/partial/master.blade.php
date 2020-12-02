<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Clinic Management System</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <!-- Vendor styles -->
        <link rel="stylesheet" href="{{asset('assets/portal-side/css/material-design-iconic-font.min.css')}}">
        <link rel="stylesheet" href="{{asset('assets/portal-side/css/animate.min.css')}}">
        <link rel="stylesheet" href="{{asset('assets/portal-side/css/jquery.scrollbar.css')}}">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

        <link rel="shortcut icon" sizes="16x16" href="{{asset('assets/portal-side/img/favicon.png')}}">
        <link rel="shortcut icon" sizes="196x196" href="{{asset('assets/portal-side/img/favicon.png')}}">
        <!-- App styles -->
        <link rel="stylesheet" href="{{asset('assets/portal-side/css/app.min.css')}}">
        <!-- Dynamic Load CSS files starts -->
        <!-- Dynamic Load CSS files ends -->
        <link rel="stylesheet" href="{{asset('assets/portal-side/css/custom.css')}}">
        <link href="{{asset('public/css/app.css')}}">
        @yield('css')
        <script type="text/javascript">
            var  image_url  ="{{asset('assets/portal-side')}}";
            var  base_url    = "{{asset('/')}}";
            var  portal_url    = "{{asset('/portal')}}";
        </script>
    </head>

    <body data-ma-theme="green">
    <main class="main" id="app">
        <div class="page-loader">
            <div class="page-loader__spinner">
                <svg viewBox="25 25 50 50">
                <circle cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
                </svg>
            </div>
        </div>
        @if(auth()->user()->type == 2)
            @include('portal.partial.header_master');
        @elseif(auth()->user()->type == 1)
            @include('portal.partial.header_reception');
        @else
            @include('portal.partial.header');
        @endif
        <div class="content">
            @yield('content')
        </div>
    </main>
    <!-- Javascript -->
    <script src="{{asset('public/js/app.js')}}"></script>
    <script src="{{asset('assets/portal-side/js/jquery.min.js')}}"></script>
    <script src="{{asset('assets/portal-side/js/jquery.validate.min.js')}}"></script>
    <script src="{{asset('assets/portal-side/js/tether.min.js')}}"></script>
    <script src="{{asset('assets/portal-side/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('assets/portal-side/js/bootstrap-notify.js')}}"></script>
    <script src="{{asset('assets/portal-side/js/jquery.scrollbar.min.js')}}"></script>
    <script src="{{asset('assets/portal-side/js/jquery-scrollLock.min.js')}}"></script>
<!--        <script src="{{asset('assets/portal-side/js/waves.min.js')}}"></script>-->
    <script src="{{asset('assets/portal-side/js/moment.min.js')}}"></script>
    <script src="{{asset('assets/portal-side/js/app.min.js')}}"></script>
    <script src="{{asset('assets/portal-side/js/jquery.dataTables.min.js')}}"></script>
    
    @yield('js')
    <script src="{{asset('assets/portal-side/js/custom.js')}}"></script>
    <script type="text/javascript">
        var errorToaster    = "{{Session::get('error')}}";
        var successToaster  = "{{Session::get('success')}}";

        if (successToaster != '') {
            showMessage('success', successToaster)
        }
        if (errorToaster != '') {
            showMessage('danger', errorToaster)
        }
    </script>        

</body>

</html>