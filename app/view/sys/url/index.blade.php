@extends('common.base')

@section('title', '链接管理')

@section('style')
    @parent
@endsection

@section('content')
    <div class="row g-3 mb-4 align-items-center justify-content-between">
        <div class="col-auto">
            <h1 class="app-page-title mb-0">链接管理</h1>
        </div>
    
        <div class="col-auto">
             <div class="page-utilities">
                <div class="row g-2 justify-content-start justify-content-md-end align-items-center">
                    <div class="col-auto">
                        <form class="table-search-form row gx-1 align-items-center" method="get">
                            <div class="col-auto">
                                <select class="form-select w-auto" name="type">
                                      <option value="">全部</option>
                                      <option value="1"
                                        @if ($type == 1)
                                        selected=""
                                        @endif
                                        >临时链接</option>
                                      <option value="2"
                                        @if ($type == 2)
                                        selected=""
                                        @endif
                                        >永久链接</option>
                                </select>
                            </div>
                            <div class="col-auto">
                                <input type="text" id="search-keyword" name="keyword" value="{{ $keyword }}" class="form-control search-orders" placeholder="搜索关键字">
                            </div>
                            <div class="col-auto">
                                <button type="submit" class="btn app-btn-secondary">搜索</button>
                            </div>
                            <div class="col-auto">
                                <a href="{{ route('my.url.create') }}" class="btn app-btn-primary">添加</a>
                            </div>
                        </form>
                        
                    </div><!--//col-->

                </div><!--//row-->
            </div><!--//table-utilities-->
        </div><!--//col-auto-->
    </div><!--//row-->
    
    <hr class="mb-4">
    
    <div class="tab-content" id="orders-table-tab-content">
        <div class="tab-pane active" id="orders-all" role="tabpanel" aria-labelledby="orders-all-tab">
            <div class="app-card app-card-orders-table shadow-sm mb-5">
                <div class="app-card-body">
                    <div class="table-responsive">
                        <table class="table app-table-hover mb-0 text-left">
                            <thead>
                                <tr>
                                    <th class="cell">访问链接</th>
                                    <th class="cell">短链接</th>
                                    <th class="cell">类型</th>
                                    <th class="cell">所属账号</th>
                                    <th class="cell">添加时间</th>
                                    <th class="cell">状态</th>
                                    <th class="cell">操作</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($list as $item)
                                <tr>
                                    <td class="cell">
                                        <span class="truncate" 
                                            data-container="body" 
                                            data-toggle="popover" 
                                            data-trigger="hover" 
                                            data-placement="top" 
                                            data-content="{{ $item['url'] }}"
                                        >
                                            {{ $item['url'] }}
                                        </span>
                                    </td>
                                    <td class="cell">
                                        <span class="truncate" 
                                            data-container="body" 
                                            data-toggle="popover" 
                                            data-trigger="hover" 
                                            data-placement="top" 
                                            data-content="{{ share_url($item['url_id']) }}"
                                        >
                                            {{ share_url($item['url_id']) }}
                                        </span>
                                    </td>
                                    <td class="cell">
                                        @if ($item['type'] == 1)
                                            <span class="badge bg-success">临时链接</span>
                                        @else
                                            <span class="badge bg-info">永久链接</span>
                                        @endif
                                    </td>
                                    <td class="cell">
                                        {{ $item['user']['username'] }}
                                    </td>
                                    <td class="cell">
                                        <span>{{ date('Y-m-d', $item['add_time']) }}</span>
                                        <span class="note">
                                            {{ date('H:i:s', $item['add_time']) }}
                                        </span>
                                    </td>
                                    <td class="cell">
                                        @if ($item['status'] == 1)
                                            <span class="badge bg-success js-disable-btn"
                                                data-url="{{ route('sys.url.disable', ['id' => $item['id']]) }}"
                                                >启用</span>
                                        @else
                                            <span class="badge bg-danger js-enable-btn"
                                                data-url="{{ route('sys.url.enable', ['id' => $item['id']]) }}"
                                                >禁用</span>
                                        @endif
                                    </td>
                                    <td class="cell" style="width: 160px;">
                                        <a class="btn-sm app-btn-secondary" 
                                            href="{{ route('sys.url.update', ['id' => $item['id']]) }}">编辑</a>
                                        <a class="btn-sm btn-danger text-white js-delete-btn" 
                                            data-url="{{ route('sys.url.delete', ['id' => $item['id']]) }}"
                                            href="javascript:;">删除</a>
                                    </td>
                                </tr>
                                @endforeach
                                
                                @if (empty($list))
                                    <tr>
                                        <td class="cell" colspan="4">
                                            <div class="text-center py-3 text-muted">
                                                无数据
                                            <div>
                                        </td>
                                    </tr>
                                @endif
                                
                            </tbody>
                        </table>
                    </div><!--//table-responsive-->
                   
                </div><!--//app-card-body-->		
            </div><!--//app-card-->
            
            <nav class="app-pagination">
                {!! $pageHtml !!}
            </nav><!--//app-pagination-->
            
        </div><!--//tab-pane-->
        
    </div><!--//tab-content-->
    
@endsection

@section('script')
    @parent
    
    <script>
    ;(function($) {
        $(".nav-item.nav-settings .nav-link").addClass("active").attr("aria-expanded", "true");
        $(".nav-item.nav-settings .submenu").addClass("show");
        $(".submenu-item.nav-settings-url .submenu-link").addClass("active");
        
        // 禁用
        $('.js-disable-btn').click(function() {
            var url = $(this).data('url');
            
            layer.confirm('您确定要禁用该条数据吗？', {
                btn: ['确定', '取消']
            }, function(index){
                $.post(url, {}, function(data) {
                    if (data.code == 0) {
                        layer.msg(data.msg, {
                            icon: 1
                        });

                        setTimeout(function() {
                            location.reload();
                        }, 2000);
                    } else {
                        layer.msg(data.msg, {
                            icon: 2
                        });
                    }
                });
            });
        });
        
        // 启用
        $('.js-enable-btn').click(function() {
            var url = $(this).data('url');
            
            layer.confirm('您确定要启用该条数据吗？', {
                btn: ['确定', '取消']
            }, function(index){
                $.post(url, {}, function(data) {
                    if (data.code == 0) {
                        layer.msg(data.msg, {
                            icon: 1
                        });

                        setTimeout(function() {
                            location.reload();
                        }, 2000);
                    } else {
                        layer.msg(data.msg, {
                            icon: 2
                        });
                    }
                });
            });
        });
        
        // 删除
        $('.js-delete-btn').click(function() {
            var url = $(this).data('url');
            
            layer.confirm('您确定要删除该条数据吗？', {
                btn: ['确定', '取消']
            }, function(index){
                $.post(url, {}, function(data) {
                    if (data.code == 0) {
                        layer.msg(data.msg, {
                            icon: 1
                        });

                        setTimeout(function() {
                            location.reload();
                        }, 2000);
                    } else {
                        layer.msg(data.msg, {
                            icon: 2
                        });
                    }
                });
            });
        });
    })(jQuery);
    </script> 

@endsection
