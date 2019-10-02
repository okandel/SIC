<!doctype html>
<html class="no-js " lang="en">
<head>
<meta charset="utf-8">
    <title> SIC - @yield('title') </title>
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="description" content="SIC">
    <title>{!! env('SITE_NAME', '') !!} - @yield('title')</title>
      
    <!-- Favicon-->
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <!-- Custom Css -->
    <link rel="stylesheet" href='{{ url("/assets/plugins/bootstrap/css/bootstrap.min.css") }}'>
    <link rel="stylesheet" href='{{ url("/assets/css/main.css") }}'>
    <link rel="stylesheet" href='{{ url("/assets/css/authentication.css") }}'>
    <link rel="stylesheet" href='{{ url("/assets/css/color_skins.css") }}'>
</head>

<body class="theme-orange">
    
    <div class="authentication">
        
        <div class="card">
            <div class="body">
                
            

                <div class="row">
                    <div class="col-lg-12">
                        <div class="header slideDown">
                            <div class="logo"><img src='{{ url("assets/images/logo.png") }}' alt="SIC - Firm Admin"></div>
                            <h1>SIC - Firm Admin Dashboard</h1> 
                        </div>
                        @yield('content')                 
                    </div>
                                    
                </div>
            </div>
        </div>
    </div>

<!-- Jquery Core Js -->
<script src='{{ url("assets/bundles/libscripts.bundle.js") }}'></script>    
<script src='{{ url("assets/bundles/vendorscripts.bundle.js") }}'></script>
<script src='{{ url("assets/bundles/mainscripts.bundle.js") }}'></script>

@yield('scripts') 
</body>
</html>