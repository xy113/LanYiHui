@extends('layouts.admin')

@section('title', '职位列表')

@section('content')
    <div class="console-title">
        <div class="navigation">
            <a>后台管理</a>
            <span>></span>
            <a>职位管理</a>
            <span>></span>
            <a>职位列表</a>
        </div>
        <div class="search-container">
            <form name="search" method="get">
                <div class="row">
                    <div class="cell">
                        <label>职位名称</label>
                        <div class="field">
                            <input type="text" title="" class="input-text" name="q" value="{{$q or ''}}" placeholder="关键字">
                        </div>
                    </div>
                    <div class="cell">
                        <label>状态:</label>
                        <div class="field">
                            <select name="status" class="select" title="">
                                <option value="all">不限</option>
                                <option value="-1"@if($status==='-1') selected="selected"@endif>不通过</option>
                                <option value="0"@if($status==='0') selected="selected"@endif>审核中</option>
                                <option value="1"@if($status==='1') selected="selected"@endif>隐藏</option>
                                <option value="2"@if($status==='2') selected="selected"@endif>已发布</option>
                            </select>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="searchType" value="0">
                <label><button type="submit" class="button">搜索</button></label>
                <label><a href="/admin/job/publish" class="button">发布职位</a></label>
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
                    <th>职位名称</th>
                    <th>企业名称</th>
                    <th>招聘人数</th>
                    <th>薪资范围</th>
                    <th>状态</th>
                    <th>点击</th>
                    <th>发布时间</th>
                    <th width="45">编辑</th>
                </tr>
                </thead>
                <tbody>
                @foreach($itemlist as $job_id=>$item)
                    <tr>
                        <td class="center"><input title="" type="checkbox" class="checkbox checkmark itemCheckBox" name="items[]" value="{{$job_id}}"></td>
                        <td><img src="{{image_url($item['company_logo'])}}" width="50" height="50" rel="pickimage" data-id="{{$job_id}}"></td>
                        <th><a href="{{job_url($job_id)}}" target="_blank">{{$item['title']}}</a></th>
                        <td>{{$item['company_name']}}</td>
                        <td>{{$item['num']}}</td>
                        <td>{{$salary_ranges[$item['salary']]}}</td>
                        @switch($item['status'])
                            @case('-1')<td class="error" title="{{$item['status']}}">审核失败</td>@break
                            @case('1')<td class="info">已隐藏</td>@break
                            @case('2')<td class="success">已发布</td>@break
                            @default<td class="primary">等待审核</td>
                        @endswitch
                        <td>{{$item['view_num']}}</td>
                        <td>{{date('Y-m-d H:i:s', $item['created_at'])}}</td>
                        <td><a href="{{url('/admin/job/publish?job_id='.$job_id)}}">编辑</a></td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <td colspan="10">
                        <div class="float-right">{{$pagination}}</div>
                        <label><input type="checkbox" class="checkbox checkall checkmark"> {{trans('common.selectall')}}</label>
                        <label><button type="button" class="btn btn-action" data-action="delete">删除</button></label>
                        <label><button type="button" class="btn btn-action" data-action="show">发布</button></label>
                        <label><button type="button" class="btn btn-action" data-action="hidden">隐藏</button></label>
                        <label><button type="button" class="btn btn-action" data-action="refuse">不通过</button></label>
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
                    DSXUI.showConfirm('删除确认', '你确认要删除所选职位信息吗?', function () {
                        submitForm();
                    });
                }else {
                    submitForm();
                }
            });
        });
//        $("[data-action=delete]").on('click', function () {
//            if ($(".checkmark:checked").length === 0){
//                DSXUI.error('请选择选项');
//                return false;
//            }
//            DSXUI.showConfirm('删除确认', '你确认要删除所选企业信息吗?', function () {
//                var spinner = null;
//                $("#listForm").ajaxSubmit({
//                    dataType:'json',
//                    beforeSend:function () {
//                        spinner = DSXUI.showSpinner();
//                    },
//                    success:function (response) {
//                        spinner.close();
//                        setTimeout(function () {
//                            if (response.errcode === 0) {
//                                DSXUtil.reFresh();
//                            }else {
//                                DSXUI.error(response.errmsg);
//                            }
//                        }, 500);
//                    }
//                })
//            });
//        });
    </script>
@stop
