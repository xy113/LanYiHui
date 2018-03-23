@extends('layouts.admin')

@section('title', '企业列表')

@section('content')
    <div class="console-title">
        <div class="float-right">
            <form name="search" method="get">
                <input type="hidden" name="searchType" value="0">
                <input type="text" title="" class="input-text" name="q" value="{{$q or ''}}" placeholder="关键字">
                <label><button type="submit" class="button">搜索</button></label>
                <label><a href="/admin/company/add" class="button">添加企业</a></label>
            </form>
        </div>
        <h2>企业管理->企业列表</h2>
    </div>

    <div class="content-div">
        <form method="post" id="listForm">
            {{csrf_field()}}
            <input type="hidden" name="eventType" id="J_eventType" value="">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="listtable">
                <thead>
                <tr>
                    <th width="40" class="center"><input title="全选" type="checkbox" class="checkbox checkall checkmark"></th>
                    <th width="60">LOGO</th>
                    <th>企业名称</th>
                    <th>联系人</th>
                    <th>联系电话</th>
                    <th>邮箱</th>
                    <th>点击</th>
                    <th>时间</th>
                    <th width="45">编辑</th>
                </tr>
                </thead>
                <tbody>
                @foreach($itemlist as $item)
                    <tr>
                        <td class="center"><input title="" type="checkbox" class="checkbox checkmark itemCheckBox" name="items[]" value="{{$item['company_id']}}"></td>
                        <td><img src="{{image_url($item['company_logo'])}}" width="50" height="50" rel="pickimage" data-id="{{$item['company_id']}}"></td>
                        <th><a href="" target="_blank">{{$item['company_name']}}</a></th>
                        <td>{{$item['contact']}}</td>
                        <td>{{$item['tel']}}</td>
                        <td>{{$item['email']}}</td>
                        <td>{{$item['view_num']}}</td>
                        <td>{{date('Y-m-d H:i:s', $item['created_at'])}}</td>
                        <td><a href="{{url('/admin/company/add?company_id='.$item['company_id'])}}">编辑</a></td>
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
        $("[data-action=delete]").on('click', function () {
            if ($(".checkmark:checked").length === 0){
                DSXUI.error('请选择选项');
                return false;
            }
            DSXUI.showConfirm('删除确认', '你确认要删除所选企业信息吗?', function () {
                var spinner = null;
                $("#listForm").ajaxSubmit({
                    dataType:'json',
                    beforeSend:function () {
                        spinner = DSXUI.showSpinner();
                    },
                    success:function (response) {
                        spinner.close();
                        setTimeout(function () {
                            if (response.errcode === 0) {
                                DSXUtil.reFresh();
                            }else {
                                DSXUI.error(response.errmsg);
                            }
                        }, 500);
                    }
                })
            });
        });
    </script>
@stop
