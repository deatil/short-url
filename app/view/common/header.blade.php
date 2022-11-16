<div class="app-header-inner">  
    <div class="container-fluid py-2">
        <div class="app-header-content"> 
            <div class="row justify-content-between align-items-center">
            
            <div class="col-auto">
                <a id="sidepanel-toggler" class="sidepanel-toggler d-inline-block d-xl-none" href="#">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" role="img"><title>菜单</title><path stroke="currentColor" stroke-linecap="round" stroke-miterlimit="10" stroke-width="2" d="M4 7h22M4 15h22M4 23h22"></path></svg>
                </a>
            </div><!--//col-->
            
            <div class="search-mobile-trigger d-sm-none col">
                <i class="search-mobile-trigger-icon fas fa-search"></i>
            </div><!--//col-->
            <div class="app-search-box col">
                <form class="app-search-form" method="get" action="{{ route('my.url') }}">   
                    <input type="text" placeholder="搜索..." name="keyword" class="form-control search-input">
                    <button type="submit" class="btn search-btn btn-primary" value="搜索"><i class="fas fa-search"></i></button> 
                </form>
            </div><!--//app-search-box-->
            
            <div class="app-utilities col-auto">
                <div class="app-utility-item">
                    <a href="{{ route('index.index') }}" target="_blank" title="首页">
                        <svg width="1.2em" height="1.2em" viewBox="0 0 16 16" class="bi bi-house-door" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M7.646 1.146a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 .146.354v7a.5.5 0 0 1-.5.5H9.5a.5.5 0 0 1-.5-.5v-4H7v4a.5.5 0 0 1-.5.5H2a.5.5 0 0 1-.5-.5v-7a.5.5 0 0 1 .146-.354l6-6zM2.5 7.707V14H6v-4a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 .5.5v4h3.5V7.707L8 2.207l-5.5 5.5z"/>
                            <path fill-rule="evenodd" d="M13 2.5V6l-2-2V2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5z"/>
                        </svg>
                    </a>
                </div>

                <div class="app-utility-item app-user-dropdown dropdown">
                    <a class="dropdown-toggle" id="user-dropdown-toggle" 
                        data-toggle="dropdown" 
                        href="#" 
                        role="button" 
                        aria-expanded="false"
                    >
                        <img src="{{ avatar_assets(user_info('avatar')) }}" alt="头像" class="rounded-circle avatar-img">
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="user-dropdown-toggle">
                        <li><a class="dropdown-item" href="{{ route('my.profile') }}">账号信息</a></li>
                        <li><a class="dropdown-item" href="{{ route('my.settings') }}">账号设置</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item js-logout-btn" 
                                href="javascript:;" 
                                data-url="{{ route('account.logout') }}">退出登录</a>
                        </li>
                    </ul>
                </div><!--//app-user-dropdown-->  
            </div><!--//app-utilities-->
        </div><!--//row-->
        </div><!--//app-header-content-->
    </div><!--//container-fluid-->
</div><!--//app-header-inner-->
