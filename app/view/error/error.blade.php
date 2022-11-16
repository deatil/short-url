<!DOCTYPE html>
<html lang="en"> 
<head>
    <title>系统提示</title>
    
    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <meta name="description" content="">
    <meta name="author" content="Xiaoying Riley at 3rd Wave Media">    
    <link rel="shortcut icon" href="favicon.ico"> 
    
    <!-- App CSS -->  
    <link id="theme-style" rel="stylesheet" href="{{ assets('css/portal.css') }}">
</head> 

<body class="app app-404-page">   	
   
    <div class="container mb-5">
        <div class="row">
            <div class="col-12 col-md-11 col-lg-7 col-xl-6 mx-auto">
                <div class="app-branding text-center mb-5">
                    <a class="app-logo" href="{{ route('index.index') }}">
                        <img class="logo-icon mr-2" src="{{ assets('images/app-logo.svg') }}" alt="logo">
                        <span class="logo-text">Short Url</span>
                    </a>
                </div><!--//app-branding-->  
                
                <div class="app-card p-5 text-center shadow-sm">
                    <h1 class="page-title mb-4">系统提示<br>
                    <span class="font-weight-light">{{ $msg }}</span></h1>
                    @if (!empty($url))
                        <div class="mb-4 jump">
                            页面将在 <b id="wait">{{ $wait }}</b> 秒后自动跳转
                        </div>
                    @endif
                    
                    <a class="btn app-btn-primary" href="{{ route('index.index') }}">返回首页</a>
                    
                    @if (!empty($url))
                        <a class="btn app-btn-secondary ml-2" id="href" href="{{ $url }}">立即跳转</a>
                    @endif
                </div>
            </div><!--//col-->
        </div><!--//row-->
    </div><!--//container-->
   
    
    <footer class="app-footer">
        <div class="container text-center py-3">
             <!--/* This template is free as long as you keep the footer attribution link. If you'd like to use the template without the attribution link, you can buy the commercial license via our website: themes.3rdwavemedia.com Thank you for your support. :) */-->
            <small class="copyright">Copyright &copy; {{ date('Y')}}. Deatil All rights reserved.</a></small>
        </div>
    </footer><!--//app-footer-->
    
    @if (!empty($url))
    <script type="text/javascript">
    ;(function(){
        var wait = document.getElementById('wait'),
            href = document.getElementById('href').href;
        var interval = setInterval(function(){
            var time = --wait.innerHTML;
            if (time <= 0) {
                location.href = href;
                clearInterval(interval);
            };
        }, 1000);
    })();
    </script>
    @endif

</body>
</html> 

