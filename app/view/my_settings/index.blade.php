@extends('common.base')

@section('title', '设置')

@section('style')
    @parent
    
    <style>
    .app-card-settings .setting-data .profile-image {
        width: 70px;
        height: 70px;
    }
    </style>
@endsection

@section('content')
    <h1 class="app-page-title">账号设置</h1>
    <hr class="mb-4">
    <div class="row g-4 settings-section">
        <div class="col-12 col-md-4">
            <h3 class="section-title">基本信息</h3>
            <div class="section-intro">在这里你可以更改账号的基本信息。</div>
        </div>
        <div class="col-12 col-md-8">
            <div class="app-card app-card-settings shadow-sm p-4">
                
                <div class="app-card-body">
                    <form class="settings-form">
                        <div class="mb-3">
                            <label for="setting-username" class="form-label">
                                登录账号
                            </label>
                            <input type="text" class="form-control" id="setting-username" value="{{ $userInfo['username'] }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="setting-email" class="form-label">邮箱</label>
                            <input type="email" class="form-control" id="setting-email" value="{{ $userInfo['email'] }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="setting-phone" class="form-label">电话</label>
                            <input type="text" class="form-control" id="setting-phone" value="{{ $userInfo['phone'] }}">
                        </div>
                        <button type="button" class="btn app-btn-primary js-profile-btn" >保存更改</button>
                    </form>
                </div><!--//app-card-body-->
                
            </div><!--//app-card-->
        </div>
    </div><!--//row-->
    <hr class="my-4">
    <div class="row g-4 settings-section">
        <div class="col-12 col-md-4">
            <h3 class="section-title">登录密码</h3>
            <div class="section-intro">更改你的登录密码。</div>
        </div>
        <div class="col-12 col-md-8">
            <div class="app-card app-card-settings shadow-sm p-4">
                
                <div class="app-card-body">
                    <form class="settings-form">
                        <div class="mb-3">
                            <label for="setting-oldpassword" class="form-label">
                                旧密码
                            </label>
                            <input type="password" class="form-control" id="setting-oldpassword" value="" placeholder="请输入账号旧密码" required>
                        </div>
                        <div class="mb-3">
                            <label for="setting-newpassword" class="form-label">
                                新密码
                            </label>
                            <input type="password" class="form-control" id="setting-newpassword" value="" placeholder="请输入新密码" required>
                        </div>
                        <div class="mb-3">
                            <label for="setting-newpassword_confirm" class="form-label">
                                确认密码
                            </label>
                            <input type="password" class="form-control" id="setting-newpassword_confirm" value="" placeholder="请输入确认密码" required>
                        </div>
                        <button type="button" class="btn app-btn-primary js-password-btn" >保存更改</button>
                    </form>
                </div><!--//app-card-body-->
                
            </div><!--//app-card-->
        </div>
    </div><!--//row-->
    
    <hr class="my-4">
    <div class="row g-4 settings-section">
        <div class="col-12 col-md-4">
            <h3 class="section-title">更改头像</h3>
            <div class="section-intro">更改你的账号头像。</div>
        </div>
        <div class="col-12 col-md-8">
            <div class="app-card app-card-settings shadow-sm p-4">
                
                <div class="app-card-body">
                    <form class="settings-form">
                        <div class="mb-3">
                            <div class="setting-data">
                                <div class="mb-2">
                                    <img class="rounded-circle profile-image" 
                                        src="{{ avatar_assets($userInfo['avatar']) }}" 
                                        alt="头像">
                                </div>

                                <span id="btn-upload-avatar"></button>
                            </div>
                        </div>
                        <input type="hidden" class="d-none" id="setting-avatar" value="{{ $userInfo['avatar'] }}">
                        
                        <hr />
                        
                        <button type="submit" class="btn app-btn-primary js-avatar-btn" >保存更改</button>
                    </form>
                </div><!--//app-card-body-->
                
            </div><!--//app-card-->
        </div>
    </div><!--//row-->
    <hr class="my-4">

@endsection

@section('script')
    @parent
    
    <script>
    $(".nav-item.my-index .nav-link").addClass("active");
    
    // 基本信息
    $(".js-profile-btn").click(function(e) {
        e.stopPropagation;
        e.preventDefault;

        var username = $("#setting-username").val();
        var email = $("#setting-email").val();
        var phone = $("#setting-phone").val();

        var url = "{{ route('my.settings.profile-save') }}";
        $.post(url, {
            username: username,
            email: email,
            phone: phone,
        }, function(data) {
            if (data.code == 0) {
                layer.msg(data.msg, {
                    icon: 1
                });
                
                setTimeout(function() {
                    location.reload();
                }, 1500);
            } else {
                layer.msg(data.msg);
            }
        }).fail(function (xhr, status, info) {
            layer.msg("请求失败");
        });
    });
    
    // 密码
    $(".js-password-btn").click(function(e) {
        e.stopPropagation;
        e.preventDefault;

        var oldpassword = $("#setting-oldpassword").val();
        var newpassword = $("#setting-newpassword").val();
        var newpassword_confirm = $("#setting-newpassword_confirm").val();

        var url = "{{ route('my.settings.password-save') }}";
        $.post(url, {
            oldpassword: oldpassword,
            newpassword: newpassword,
            newpassword_confirm: newpassword_confirm,
        }, function(data) {
            if (data.code == 0) {
                layer.msg(data.msg, {
                    icon: 1
                });
                
                setTimeout(function() {
                    location.reload();
                }, 1500);
            } else {
                layer.msg(data.msg);
            }
        }).fail(function (xhr, status, info) {
            layer.msg("请求失败");
        });
    });
    
    // 头像
    $(".js-avatar-btn").click(function(e) {
        e.stopPropagation;
        e.preventDefault;

        var avatar = $("#setting-avatar").val();

        var url = "{{ route('my.settings.avatar-save') }}";
        $.post(url, {
            avatar: avatar,
        }, function(data) {
            if (data.code == 0) {
                layer.msg(data.msg, {
                    icon: 1
                });
                
                setTimeout(function() {
                    location.reload();
                }, 1500);
            } else {
                layer.msg(data.msg);
            }
        }).fail(function (xhr, status, info) {
            layer.msg("请求失败");
        });
    });
    </script> 
    
    <link href='{{ assets("plugins/huploadify/Huploadify.css") }}' rel="stylesheet">
    <script src='{{ assets("plugins/huploadify/jquery.Huploadify.js") }}' type="text/javascript"></script>
    <script type="text/javascript">
    (function($) {
        "use strict";

        // 上传
        $('#btn-upload-avatar').Huploadify({
            auto: true,
            fileTypeExts: '*.png;*.jpg;*.JPG;*.bmp;*.gif',// 不限制上传文件请修改成'*.*'
            multi: true,
            fileSizeLimit: 5*1024*1024, // 大小限制
            uploader : "{{ route('upload.avatar') }}", // 文件上传目标地址
            buttonText : '选择文件',
            fileObjName : 'file',
            btnClass: 'btn app-btn-primary btn-sm',
            showUploadedPercent: false,
            onUploadSuccess : function(file, data) {
                data = $.parseJSON(data);
                if (data.code == 0) {
                    var avatar = data.data.avatar;
                    var url = data.data.url;
                    var $img = $('#art-preview').find('img');

                    $img.attr('src', url);
                    $img.attr('alt', file.name);

                    $('#setting-avatar').val(avatar);
                } else {
                    layer.msg("上传失败：" + data.message);
                }
            }
        });

    })(jQuery);
    </script>
@endsection
