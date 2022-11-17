@extends('common.base')

@section('title', '链接记录')

@section('style')
    @parent
@endsection

@section('content')
    <div class="row g-3 mb-4 align-items-center justify-content-between">
        <div class="col-auto">
            <h1 class="app-page-title mb-0">链接记录</h1>
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
                                <input type="text" id="search-keywords" name="keyword" value="{{ $keyword }}" class="form-control search-orders" placeholder="搜索关键字">
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
                                    <th class="cell">链接地址</th>
                                    <th class="cell">短链接</th>
                                    <th class="cell">类型</th>
                                    <th class="cell">添加时间</th>
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
                                        {{ date('Y-m-d H:i:s', $item['add_time']) }}
                                    </td>
                                    <td class="cell">
                                        <a class="btn-sm app-btn-secondary" href="{{ $item['url'] }}" target="_blank">访问链接</a>
                                        <a href="javascript:;" 
                                            data-id="{{ $item['id'] }}"
                                            class="btn-sm btn-danger text-white js-delete-btn">删除</a>
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
        $(".nav-item.my-url-index .nav-link").addClass("active");
        
        // 删除
        $('.js-delete-btn').click(function() {
            var id = $(this).data('id');
            var url = "{{ route('my.url.delete') }}";
            
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
