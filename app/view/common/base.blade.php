<!DOCTYPE html>
<html lang="en"> 
<head>
    <title>@yield('title')</title>
    
    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <meta name="description" content="">
    <meta name="author" content="short-url">    
    <link rel="shortcut icon" href="favicon.ico"> 
    
    @section('style')
        <!-- App CSS -->  
        <link id="theme-style" rel="stylesheet" href="{{ assets('css/portal.css') }}">
        
        <!-- Fonts and icons -->
        <script src='{{ assets("plugins/webfont/webfont.min.js") }}'></script>
        <script>
            WebFont.load({
                google: {"families":["Open+Sans:300,400,600,700"]},
                custom: {"families":["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands"], urls: ['{{ assets("plugins/webfont/webfont.css") }}']},
                active: function() {
                    sessionStorage.fonts = true;
                }
            });
        </script>
    @show
</head> 

<body class="app">
    <header class="app-header fixed-top">
        @include('common.header')
        
        @include('common.sidepanel')
    </header><!--//app-header-->
    
    <div class="app-wrapper">
        
        <div class="app-content pt-3 p-md-3 p-lg-4">
            <div class="container-xl">
                @yield('content')
            </div><!--//container-fluid-->
        </div><!--//app-content-->
        
        @include('common.footer')
        
    </div><!--//app-wrapper--> 

    @section('script')
        <!-- Javascript -->          
        <script src="{{ assets('plugins/popper.min.js') }}"></script>
        <script src="{{ assets('plugins/bootstrap/js/bootstrap.min.js') }}"></script>  
        
        <script src='{{ assets("plugins/jquery-3.4.1.min.js") }}' type="text/javascript"></script>
        <script src='{{ assets("plugins/layer/layer.js") }}' type="text/javascript"></script>
        
        <!-- Page Specific JS -->
        <script src="{{ assets('js/app.js') }}"></script> 
    @show
</body>
</html> 

