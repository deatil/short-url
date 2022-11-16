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
    
    <!-- App CSS -->  
    <link id="theme-style" rel="stylesheet" href="{{ assets('css/portal.css') }}">
    
    @yield('style')
</head> 

<body class="app app-login p-0">
    <div class="row g-0 app-auth-wrapper">
        <div class="col-12 col-md-7 col-lg-6 auth-main-col text-center p-5">
            <div class="d-flex flex-column align-content-end">
                <div class="app-auth-body mx-auto">	
                    <div class="app-auth-branding mb-4">
                        <a class="app-logo" href="{{ route('index.index') }}"><img class="logo-icon mr-2" src="{{ assets('images/app-logo.svg') }}" alt="logo"></a>
                    </div>
                    
                    @yield('content')

                </div><!--//auth-body-->
            
                <footer class="app-auth-footer">
                    <div class="container text-center py-3">
                         <!--/* This template is free as long as you keep the footer attribution link. If you'd like to use the template without the attribution link, you can buy the commercial license via our website: themes.3rdwavemedia.com Thank you for your support. :) */-->
                        <small class="copyright">Copyright &copy; {{ date('Y')}}. Deatil All rights reserved.</a></small>
                       
                    </div>
                </footer><!--//app-auth-footer-->	
            </div><!--//flex-column-->   
        </div><!--//auth-main-col-->
        
        <div class="col-12 col-md-5 col-lg-6 h-100 auth-background-col">
            <div class="auth-background-holder">
            </div>
            <div class="auth-background-mask"></div>
            <div class="auth-background-overlay p-3 p-lg-5">
                <div class="d-flex flex-column align-content-end h-100">
                    <div class="h-100"></div>
                    <div class="overlay-content p-3 p-lg-4 rounded">
                        <h5 class="mb-3 overlay-title">Short Url System</h5>
                        <div>Short-url 是使用 webman 和 bootstrap 开发的短链接系统.</div>
                    </div>
                </div>
            </div><!--//auth-background-overlay-->
        </div><!--//auth-background-col-->
    
    </div><!--//row-->

    <script src='{{ assets("plugins/jquery-3.4.1.min.js") }}' type="text/javascript"></script>
    <script src='{{ assets("plugins/layer/layer.js") }}' type="text/javascript"></script>
    
    @yield('script')

</body>
</html> 

