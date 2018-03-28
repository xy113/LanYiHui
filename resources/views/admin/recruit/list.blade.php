@extends('layouts.admin')

@section('title', '联谊会招聘')

@section('content')
    <div class="console-title">
        <div class="float-right">
            <form name="search" method="get">
                <input type="hidden" name="searchType" value="0">
                <input type="text" title="" class="input-text" name="q" value="{{$q or ''}}" placeholder="关键字">
                <label><button type="submit" class="button">搜索</button></label>
                <label><a href="{{url('/admin/recruit/catlog')}}" class="button">分类管理</a></label>
                <label><a href="{{url('/admin/recruit/publish')}}" class="button">发布信息</a></label>
            </form>
        </div>
        <h2>联谊会招聘->职务列表</h2>
    </div>

    <div class="content-div">
        <form method="post" id="listForm">
            {{csrf_field()}}
            <input type="hidden" name="formsubmit" value="yes">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="listtable">
                <thead>
                <tr>
                    <th width="40" class="center"><input title="全选" type="checkbox" class="checkbox checkall checkmark"></th>
                    <th width="60">图片</th>
                    <th>职位名称</th>
                    <th>招募人数</th>
                    <th>目录分类</th>
                    <th>发布时间</th>
                    <th>浏览数</th>
                    <th>报名人数</th>
                    <th width="50">选项</th>
                </tr>
                </thead>
                <tbody>
                @foreach($itemlist as $item)
                    <tr>
                        <td class="center"><input title="" type="checkbox" class="checkbox checkmark itemCheckBox" name="items[]" value="{{$item['id']}}"></td>
                        <td><img src="{{avatar($item['uid'], 'small')}}" width="50" height="50"></td>
                        <th><a href="{{url('/recruit/detail/'.$item['id'].'.html')}}" target="_blank">{{$item['title']}}</a></th>
                        <td>{{$item['num']}}</td>
                        <td>{{$item['typename']}}</td>
                        <td>{{@date('Y-m-d H:i', $item['created_at'])}}</td>
                        <td>{{$item['views']}}</td>
                        <td>{{$item['enrolment']}}</td>
                        <td><a href="{{url('/admin/recruit/publish?id='.$item['id'])}}">编辑</a></td>
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
                    DSXUI.showConfirm('删除确认', '确认要删除所选信息吗?', function () {
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
