<div id="app-sidepanel" class="app-sidepanel sidepanel-hidden"> 
    <div id="sidepanel-drop" class="sidepanel-drop"></div>
    <div class="sidepanel-inner d-flex flex-column">
        <a href="#" id="sidepanel-close" class="sidepanel-close d-xl-none">&times;</a>
        <div class="app-branding">
            <a class="app-logo" href="{{ route('index.index') }}">
                <img class="logo-icon mr-2" src="{{ assets('images/app-logo.svg') }}" alt="logo">
                <span class="logo-text">Short Url</span>
            </a>
        </div><!--//app-branding-->  
        
        <nav id="app-nav-main" class="app-nav app-nav-main flex-grow-1">
            <ul class="app-menu list-unstyled accordion" id="menu-accordion">
                <li class="nav-item my-index">
                    <a class="nav-link" href="{{ route('my.index') }}">
                         <span class="nav-icon">
                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-house-door" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                              <path fill-rule="evenodd" d="M7.646 1.146a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 .146.354v7a.5.5 0 0 1-.5.5H9.5a.5.5 0 0 1-.5-.5v-4H7v4a.5.5 0 0 1-.5.5H2a.5.5 0 0 1-.5-.5v-7a.5.5 0 0 1 .146-.354l6-6zM2.5 7.707V14H6v-4a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 .5.5v4h3.5V7.707L8 2.207l-5.5 5.5z"/>
                              <path fill-rule="evenodd" d="M13 2.5V6l-2-2V2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5z"/>
                            </svg>
                         </span>
                         <span class="nav-link-text">我的概要</span>
                    </a><!--//nav-link-->
                </li><!--//nav-item-->
                
                <li class="nav-item my-url-create">
                    <a class="nav-link" href="{{ route('my.url.create') }}">
                         <span class="nav-icon">
                            <i class="flaticon-plus" style="font-size: 1.3em;"></i>
                         </span>
                         <span class="nav-link-text">添加链接</span>
                    </a><!--//nav-link-->
                </li><!--//nav-item-->
                
                <li class="nav-item my-url-index">
                    <a class="nav-link" href="{{ route('my.url') }}">
                        <span class="nav-icon">
                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-card-list" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
<path fill-rule="evenodd" d="M14.5 3h-13a.5.5 0 0 0-.5.5v9a.5.5 0 0 0 .5.5h13a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-13z"/>
<path fill-rule="evenodd" d="M5 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 5 8zm0-2.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm0 5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5z"/>
<circle cx="3.5" cy="5.5" r=".5"/>
<circle cx="3.5" cy="8" r=".5"/>
<circle cx="3.5" cy="10.5" r=".5"/>
</svg>
                         </span>
                         <span class="nav-link-text">链接记录</span>
                    </a><!--//nav-link-->
                </li><!--//nav-item-->
                
                @if (is_admin())
                <li class="nav-item has-submenu nav-settings">
                    <a class="nav-link submenu-toggle" 
                        href="#" 
                        data-toggle="collapse" 
                        data-target="#submenu-settings" 
                        aria-expanded="false" 
                        aria-controls="submenu-settings"
                    >
                        <span class="nav-icon">
                        
                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-folder" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9.828 4a3 3 0 0 1-2.12-.879l-.83-.828A1 1 0 0 0 6.173 2H2.5a1 1 0 0 0-1 .981L1.546 4h-1L.5 3a2 2 0 0 1 2-2h3.672a2 2 0 0 1 1.414.586l.828.828A2 2 0 0 0 9.828 3v1z"/>
                            <path fill-rule="evenodd" d="M13.81 4H2.19a1 1 0 0 0-.996 1.09l.637 7a1 1 0 0 0 .995.91h10.348a1 1 0 0 0 .995-.91l.637-7A1 1 0 0 0 13.81 4zM2.19 3A2 2 0 0 0 .198 5.181l.637 7A2 2 0 0 0 2.826 14h10.348a2 2 0 0 0 1.991-1.819l.637-7A2 2 0 0 0 13.81 3H2.19z"/>
                        </svg>
                         </span>
                         <span class="nav-link-text">系统管理</span>
                         <span class="submenu-arrow">
                             <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-chevron-down" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
<path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"/>
</svg>
                         </span><!--//submenu-arrow-->
                    </a><!--//nav-link-->
                    <div id="submenu-settings" 
                        class="collapse submenu submenu-settings" 
                        data-parent="#menu-accordion"
                    >
                        <ul class="submenu-list list-unstyled">
                            <li class="submenu-item nav-settings-apply">
                                <a class="submenu-link" href="{{ route('apply.index') }}">申请管理</a>
                            </li>
                            <li class="submenu-item nav-settings-url">
                                <a class="submenu-link" href="{{ route('url.index') }}">链接管理</a>
                            </li>
                            <li class="submenu-item nav-settings-user">
                                <a class="submenu-link" href="{{ route('user.index') }}">用户管理</a>
                            </li>
                            <li class="submenu-item nav-settings-setting">
                                <a class="submenu-link" href="{{ route('setting.index') }}">网站设置</a>
                            </li>
                        </ul>
                    </div>
                </li><!--//nav-item-->
                @endif
               
            </ul><!--//app-menu-->
        </nav><!--//app-nav-->
        
        <div class="app-sidepanel-footer">
            <nav class="app-nav app-nav-footer">
                <ul class="app-menu footer-menu list-unstyled">
                    <li class="nav-item help-index">
                        <a class="nav-link" href="{{ route('help.index') }}">
                            <span class="nav-icon">
                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-question-circle" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
    <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
    <path d="M5.255 5.786a.237.237 0 0 0 .241.247h.825c.138 0 .248-.113.266-.25.09-.656.54-1.134 1.342-1.134.686 0 1.314.343 1.314 1.168 0 .635-.374.927-.965 1.371-.673.489-1.206 1.06-1.168 1.987l.003.217a.25.25 0 0 0 .25.246h.811a.25.25 0 0 0 .25-.25v-.105c0-.718.273-.927 1.01-1.486.609-.463 1.244-.977 1.244-2.056 0-1.511-1.276-2.241-2.673-2.241-1.267 0-2.655.59-2.75 2.286zm1.557 5.763c0 .533.425.927 1.01.927.609 0 1.028-.394 1.028-.927 0-.552-.42-.94-1.029-.94-.584 0-1.009.388-1.009.94z"/>
    </svg>
                             </span>
                             <span class="nav-link-text">帮助中心</span>
                        </a><!--//nav-link-->
                    </li><!--//nav-item-->

                </ul><!--//footer-menu-->
            </nav>
        </div><!--//app-sidepanel-footer-->
    </div><!--//sidepanel-inner-->
</div><!--//app-sidepanel-->
