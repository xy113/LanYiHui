@extends('layouts.admin')

@section('title', '简历管理')

@section('content')
    <div class="console-title">
        <div class="float-right">
            <form name="search" method="get">
                <input type="hidden" name="searchType" value="0">
                <input type="text" title="" class="input-text" name="q" value="{{$q or ''}}" placeholder="关键字">
                <label><button type="submit" class="button">快速搜索</button></label>
            </form>
        </div>
        <h2>简历管理->简历列表</h2>
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
                    <th width="60">照片</th>
                    <th>名称</th>
                    <th>姓名</th>
                    <th>性别</th>
                    <th>电话</th>
                    <th>毕业学校</th>
                    <th>专业</th>
                    <th>工作年限</th>
                    <th>浏览数</th>
                </tr>
                </thead>
                <tbody>
                @foreach($itemlist as $item)
                    <tr>
                        <td class="center"><input title="" type="checkbox" class="checkbox checkmark itemCheckBox" name="items[]" value="{{$item['id']}}"></td>
                        <td><img src="{{avatar($item['uid'], 'small')}}" width="50" height="50"></td>
                        <th><a href="{{url('admin/resume/detail/'.$item['id'].'.html')}}" target="_blank">{{$item['title']}}</a></th>
                        <td>{{$item['name']}}</td>
                        <td>@if($item['gender'])男@else女@endif</td>
                        <td>{{$item['phone']}}</td>
                        <td>{{$item->edus()->orderBy('id', 'ASC')->first()['school']?$item->edus()->orderBy('id', 'ASC')->first()['school']:'暂无'}}</td>
                        <td>{{$item->edus()->orderBy('id', 'ASC')->first()['major']?$item->edus()->orderBy('id', 'ASC')->first()['major']:'暂无'}}</td>
                        <td>{{$item['work_exp']}}</td>
                        <td>{{$item['views']}}</td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <td colspan="10">
                        <div class="float-right">{{$pagination}}</div>
                        <label><input type="checkbox" class="checkbox checkall checkmark"> {{trans('common.selectall')}}</label>
                        <label><button type="button" class="btn btn-action" data-action="delete">删除</button></label>
                        <label><button type="button" class="btn" onclick="DSXUtil.reFresh()">刷新</button></label>
                        {{$itemlist->currentPage()}}
                    </td>
                </tr>
                </tfoot>
            </table>
        </form>
    </div>
    <script type="text/javascript">
        $(function () {
            var spinner;
            $(".btn-action").on('click', function () {
                if ($(".itemCheckBox:checked").length === 0){
                    DSXUI.error('请选择选项');
                    return false;
                }
                var action = $(this).attr('data-action');
                if (action === 'delete'){
                    DSXUI.showConfirm('删除确认', '确认要删除所选简历吗?', function () {
                        $("#listForm").ajaxSubmit({
                            dataType:'json',
                            beforeSend:function () {
                                spinner = DSXUI.showSpinner();
                            },
                            success:function (response) {
                                setTimeout(function () {
                                    spinner.close();
                                    if (response.errcode === 0){
                                        DSXUtil.reFresh();
                                    }else {
                                        DSXUI.error(response.errmsg);
                                    }
                                }, 500);
                            }
                        });
                    });
                }
            });
        });
    </script>
@stop
