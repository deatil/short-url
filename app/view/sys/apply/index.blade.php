@extends('common.base')

@section('title', '申请管理')

@section('style')
    @parent
@endsection

@section('content')
    <div class="row g-3 mb-4 align-items-center justify-content-between">
        <div class="col-auto">
            <h1 class="app-page-title mb-0">申请管理</h1>
        </div>
    
        <div class="col-auto">
             <div class="page-utilities">
                <div class="row g-2 justify-content-start justify-content-md-end align-items-center">
                    <div class="col-auto">
                        <form class="table-search-form row gx-1 align-items-center" method="get">
                            <div class="col-auto">
                                <input type="text" id="search-keyword" name="keyword" value="{{ $keyword }}" class="form-control search-orders" placeholder="搜索关键字">
                            </div>
                            <div class="col-auto">
                                <button type="submit" class="btn app-btn-secondary">搜索</button>
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
                                    <th class="cell">#</th>
                                    <th class="cell">AppId</th>
                                    <th class="cell">申请账号</th>
                                    <th class="cell">申请时间</th>
                                    <th class="cell">申请状态</th>
                                    <th class="cell">状态</th>
                                    <th class="cell">操作</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($list as $item)
                                <tr>
                                    <td class="cell">
                                        {{ $item['id'] }}
                                    </td>
                                    <td class="cell">
                                        <span>{{ $item['app_id'] }}</span>
                                        <span class="note">{{ $item['app_secret'] }}</span>
                                    </td>
                                    <td class="cell">
                                        <span class="truncate">{{ $item['user']['username'] }}</span>
                                    </td>
                                    <td class="cell">
                                        {{ date('Y-m-d H:i:s', $item['add_time']) }}
                                    </td>
                                    <td class="cell">
                                        @if ($item['is_apply'] == 2)
                                            <span class="badge bg-success">已通过</span>
                                        @elseif ($item['is_apply'] == 1)
                                            <span class="badge bg-warning">申请中</span>
                                        @elseif ($item['is_apply'] == 0)
                                            <span class="badge bg-danger">未通过</span>
                                        @endif
                                    </td>
                                    <td class="cell">
                                        @if ($item['status'] == 1)
                                            <span class="badge bg-success">启用</span>
                                        @else
                                            <span class="badge bg-danger">禁用</span>
                                        @endif
                                    </td>
                                    <td class="cell">
                                        <a class="btn-sm app-btn-secondary" 
                                            href="{{ route('apply.check', ['id' => $item['id']]) }}">审核</a>
                                        <a class="btn-sm btn-danger text-white js-delete-btn" 
                                            data-id="{{ $item['id'] }}"
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
        $(".submenu-item.nav-settings-apply .submenu-link").addClass("active");
        
        // 删除
        $('.js-delete-btn').click(function() {
            var id = $(this).data('id');
            var url = "{{ route('apply.delete') }}";
            
            layer.confirm('您确定要删除该条数据吗？', {
                btn: ['确定', '取消']
            }, function(index){
                $.post(url, {
                    id: id,
                }, function(data) {
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
