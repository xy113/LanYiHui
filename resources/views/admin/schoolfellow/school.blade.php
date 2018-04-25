@extends('layouts.admin')

@section('title', '学校管理')

@section('content')
    <div class="console-title">
        <div class="float-right">
            <form name="search" method="get">
                <input type="hidden" name="searchType" value="0">
                <input type="text" title="" class="input-text" name="q" placeholder="关键字">
                <label><button type="submit" class="button">快速搜索</button></label>
            </form>
        </div>
        <h2>校友录->学校管理</h2>
    </div>

    <div class="content-div">
        <form method="post" id="listForm">
            {{csrf_field()}}
            <input type="hidden" name="formsubmit" value="yes">
            <input type="hidden" name="eventType" id="J_eventType" value="">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="listtable">
                <thead>
                <tr>
                    <th width="40" class="center"><input title="全选" type="checkbox" class="checkbox checkall checkmark"></th>
                    <th width="200">学校名称</th>
                    <th>校友人数</th>
                    <th>申请人数</th>
                    <th>认证状态</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach($school as $item)
                    <tr>
                        <td class="center"><input title="" type="checkbox" class="checkbox checkmark itemCheckBox" name="items[]" value="{{$item['id']}}"></td>
                        <td><a href="{{url('admin/schoolfellow/detail?id='.$item['id'])}}">{{$item['name']}}</a></td>
                        <th>{{$item->members()->count()}}</th>
                        <td><a href="{{url('admin/schoolfellow/application?id='.$item['id'])}}">{{$item->apply()->count()}}</a></td>
                        <td>@if($item['status']=='0')未认证@else已认证@endif</td>
                        <td>
                            <input type="button" value="查看" onclick="check({{$item['id']}})">
                            <input type="button" value="修改" onclick="edit('{{$item['id']}}','{{$item['name']}}')">
                            <input type="button" value="申请列表" onclick="application({{$item['id']}})">
                            @if($item['status'] == 0)
                                <input type="button" value="认证" onclick="rz({{$item['id']}},'1')">
                            @else
                                <input type="button" value="取消认证" onclick="rz({{$item['id']}},'0')">
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <td colspan="10">
                        <div class="float-right">{{$school->links()}}</div>
                        <label><input type="checkbox" class="checkbox checkall checkmark"> {{trans('common.selectall')}}</label>
                        <label><button type="button" class="btn btn-action" data-action="delete">删除</button></label>
                        <label><button type="button" class="btn" onclick="DSXUtil.reFresh()">刷新</button></label>
                        {{--{{$itemlist->currentPage()}}--}}
                    </td>
                </tr>
                </tfoot>
            </table>
        </form>
    </div>
    <script type="text/javascript">
        function check(id) {
            window.location = '{{url('/admin/schoolfellow/detail')}}'+'?id='+id;
        }
        function application(id) {
            window.location = '{{url('/admin/schoolfellow/application')}}'+'?id='+id;
        }
        function rz(id,pass) {
            var text = pass=='1'?'通过':'取消';
            if (confirm('是否'+text+'该学校的认证？')){
                $.ajax({
                    type:'POST',
                    url:'{{url('/admin/schoolfellow/school/deal')}}',
                    dataType: 'json',
                    data:{
                        id:id,
                        pass:pass,
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    success:function (res) {
                        if (res.errcode == 0){
                            alert('修改成功！');
                            DSXUtil.reFresh();
                        }
                    },
                    error:function (err) {
                        alert('修改失败，请稍后重试！');
                    }
                })
            }
        }
        function edit(id,n) {
            var name = prompt('学校名称',n);
            if(name!=null&&name!=''&&name!=n){
                if (confirm('是否确认将"'+n+'"修改为"'+name+'"?')){
                    console.log('querenle');
                    $.ajax({
                        type:'POST',
                        url:'{{url('/admin/schoolfellow/school/edit')}}',
                        dataType: 'json',
                        data:{
                            id:id,
                            name:name,
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        },
                        success:function (res) {
                            if (res.errcode == 0){
                                alert('修改成功！');
                                DSXUtil.reFresh();
                            }
                        },
                        error:function (err) {
                            alert('修改失败，请稍后重试！');
                        }
                    })
                }
            }
        }
    </script>
@stop
