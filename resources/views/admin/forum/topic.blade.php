@extends('layouts.admin')

@section('title', '话题管理')

@section('content')
    <div class="console-title">
        <div class="float-right">
            <form name="search" method="get">
                <input type="hidden" name="searchType" value="0">
                <input type="text" title="" class="input-text" name="q" value="{{$q or ''}}" placeholder="关键字">
                <label><button type="submit" class="button">搜索</button></label>
            </form>
        </div>
        <h2>讨论区->话题列表</h2>
    </div>

    <div class="content-div">
        <form method="post" id="listForm">
            {{csrf_field()}}
            <input type="hidden" name="eventType" id="J_eventType" value="">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="listtable">
                <thead>
                <tr>
                    <th width="40" class="center"><input title="全选" type="checkbox" class="checkbox checkall checkmark"></th>
                    <th>话题</th>
                    <th>用户</th>
                    <th>发表时间</th>
                    <th>回复数</th>
                    <th>浏览数</th>
                </tr>
                </thead>
                <tbody>
                @foreach($itemlist as $aid=>$item)
                    <tr>
                        <td class="center"><input title="" type="checkbox" class="checkbox checkmark itemCheckBox" name="items[]" value="{{$item['tid']}}"></td>
                        <th>{{$item['title']}}</th>
                        <td>{{$item['username']}}</td>
                        <td>{{@date('Y-m-d H:i', $item['created_at'])}}</td>
                        <td>{{$item['replies']}}</td>
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
                    DSXUI.error('请选择话题');
                    return false;
                }
                var action = $(this).attr('data-action');
                if (action === 'delete'){
                    DSXUI.showConfirm('删除确认', '确认要删除所选话题吗?', function () {
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
