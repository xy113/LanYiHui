@extends('layouts.admin')

@section('title', '企业列表')

@section('content')
    <div class="console-title">
        <div class="navigation">
            <a>后台管理</a>
            <span>></span>
            <a>企业管理</a>
            <span>></span>
            <a>企业列表</a>
        </div>
        <div class="search-container">
            <form name="search" method="get">
                <div class="row">
                    <div class="cell">
                        <label>企业名称</label>
                        <div class="field">
                            <input type="text" title="" class="input-text" name="q" value="{{$q or ''}}" placeholder="关键字">
                        </div>
                    </div>
                    <div class="cell">
                        <label>认证状态:</label>
                        <div class="field">
                            <select name="status" class="select" title="">
                                <option value="all">不限</option>
                                <option value="0"@if($status==='0') selected="selected"@endif>等待认证</option>
                                <option value="1"@if($status==='1') selected="selected"@endif>等待复审</option>
                                <option value="-1"@if($status==='-1') selected="selected"@endif>认证失败</option>
                                <option value="2"@if($status==='2') selected="selected"@endif>已审核</option>
                                <option value="3"@if($status==='3') selected="selected"@endif>合作伙伴</option>
                            </select>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="searchType" value="0">
                <label><button type="submit" class="button">搜索</button></label>
                <label><a href="/admin/company/add" class="button">添加企业</a></label>
            </form>
        </div>
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
                    <th width="60">LOGO</th>
                    <th>企业名称</th>
                    <th>联系人</th>
                    <th>联系电话</th>
                    <th>邮箱</th>
                    <th>认证状态</th>
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
                        @switch($item['status'])
                            @case('-1')<td class="error" title="{{$item['status']}}">审核失败</td>@break
                            @case('1')<td class="warning">等待复审</td>@break
                            @case('2')<td class="default">已认证</td>@break
                            @case('3')<td class="success">合作伙伴</td>@break
                            @default<td class="primary">等待审核</td>
                        @endswitch
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
                        <label><button type="button" class="btn btn-action" data-action="pass">普通认证</button></label>
                        <label><button type="button" class="btn btn-action" data-action="nopass">打回修改</button></label>
                        <label><button type="button" class="btn btn-action" data-action="partner">合作伙伴</button></label>
                    </td>
                </tr>
                </tfoot>
            </table>
        </form>
    </div>
    <script type="text/javascript">
        $(function () {
            $(".btn-action").on('click', function () {
                if ($(".checkmark:checked").length === 0){
                    DSXUI.error('请选择选项');
                    return false;
                }
                var spinner = null;
                var action = $(this).attr('data-action');
                var $form = $("#listForm");
                var submitForm = function () {
                    $form.ajaxSubmit({
                        dataType:'json',
                        beforeSend:function () {
                            spinner = DSXUI.showSpinner();
                        },success:function (response) {
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
                }
                $("#J_eventType").val(action);
                if (action === 'delete'){
                    DSXUI.showConfirm('删除确认', '你确认要删除所选企业信息吗?', function () {
                        submitForm();
                    });
                }else {
                    submitForm();
                }
            });
        });
    </script>
@stop
