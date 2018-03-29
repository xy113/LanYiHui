@extends('layouts.admin')

@section('scripts')
    <script src="/DatePicker/WdatePicker.js" type="text/javascript"></script>
@stop

@section('content')
    <div class="console-title">
        <div class="float-right">
            <form name="search" method="get">
                <input type="hidden" name="searchType" value="0">
                <input type="text" title="" class="input-text" name="q" value="{{$q or ''}}" placeholder="关键字">
                <label><button type="submit" class="button">快速搜索</button></label>
                <label><button type="button" class="button" onclick="$('#search-container').toggle()">高级搜索</button></label>
            </form>
        </div>
        <h2>文章管理->文章列表</h2>
    </div>

    <div class="search-container" id="search-container"@if(!$searchType) style="display: none;"@endif>
    <form method="get" id="searchFrom" action="/admin/post/index">
        <input type="hidden" name="searchType" value="1">
        <div class="row">
            <div class="cell">
                <label>文章标题:</label>
                <div class="field"><input type="text" title="" class="input-text" name="title" value="{{$title or ''}}"></div>
            </div>
            <div class="cell">
                <label>用户:</label>
                <div class="field"><input type="text" title="" class="input-text" name="username" value="{{$username}}"></div>
            </div>
            <div class="cell">
                <label>目录分类:</label>
                <div class="field">
                    <select name="catid" class="select" title="">
                        <option value="">全部</option>
                        @foreach($catloglist[0] as $catid1=>$cat1)
                        <option value="{{$catid1}}"@if($catid==$catid1) selected="selected"@endif>{{$cat1['name']}}</option>
                            @if(isset($catloglist[$catid1]))
                            @foreach($catloglist[$catid1] as $catid2=>$cat2)
                            <option value="{{$catid2}}"@if($catid==$catid2) selected="selected"@endif>|--{{$cat2['name']}}</option>
                                @if(isset($catloglist[$catid2]))
                                @foreach($catloglist[$catid2] as $catid3=>$cat3)
                                <option value="{{$catid3}}"@if($catid==$catid3) selected="selected"@endif>|--|--{{$cat3['name']}}</option>
                                @endforeach
                                @endif
                            @endforeach
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="cell">
                <label>审核状态:</label>
                <div class="field">
                    <select name="status" class="select" title="">
                        <option value="">全部</option>
                        @foreach($post_status as $k=>$v)
                        <option value="{{$k}}"@if($status=="$k") selected="selected"@endif>{{$v}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="cell">
                <label>形式:</label>
                <div class="field">
                    <select name="type" class="select" title="">
                        <option value="">全部</option>
                        @foreach($post_types as $k=>$v)
                        <option value="{{$k}}"@if($type==$k) selected="selected"@endif>{{$v}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="cell">
                <label>发布时间:</label>
                <div class="field">
                    <input type="text" title="" class="input-text" name="time_begin" value="{{$time_begin or ''}}" onclick="WdatePicker()" style="width: 100px;"> -
                    <input type="text" title="" class="input-text" name="time_end" value="{{$time_end or ''}}" onclick="WdatePicker()" style="width: 100px;">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="cell">
                <label></label>
                <div class="field">
                    <button type="submit" class="button">搜索</button>
                    <button type="reset" class="button button-cancel">重置</button>
                </div>
            </div>
        </div>
    </form>
    </div>

    <div class="content-div">
        <form method="post" id="listForm">
            {{csrf_field()}}
            <input type="hidden" name="eventType" id="J_eventType" value="">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="listtable">
                <thead>
                <tr>
                    <th width="40" class="center"><input title="全选" type="checkbox" class="checkbox checkall checkmark"></th>
                    <th width="60">图片</th>
                    <th>标题</th>
                    <th>用户</th>
                    <th>分类</th>
                    <th>形式</th>
                    <th>点击</th>
                    <th>时间</th>
                    <th>状态</th>
                    <th width="45">编辑</th>
                </tr>
                </thead>
                <tbody>
                @foreach($itemlist as $aid=>$item)
                <tr>
                    <td class="center"><input title="" type="checkbox" class="checkbox checkmark itemCheckBox" name="items[]" value="{{$aid}}"></td>
                    <td><img src="{{image_url($item['image'])}}" width="50" height="50" rel="pickimage" data-id="{{$aid}}"></td>
                    <th><a href="{{post_url($aid)}}" target="_blank">{{$item['title']}}</a></th>
                    <td>{{$item['username']}}</td>
                    <td>{{$item['cat_name']}}</td>
                    <td>{{$post_types[$item['type']]}}</td>
                    <td>{{$item['view_num']}}</td>
                    <td>{{date('Y-m-d H:i:s', $item['created_at'])}}</td>
                    <td>{{$post_status[$item['status']]}}</td>
                    <td><a href="/admin/post/publish?aid={{$aid}}">编辑</a></td>
                </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <td colspan="10">
                        <div class="float-right">{{$pagination}}</div>
                        <label><input type="checkbox" class="checkbox checkall checkmark"> {{trans('common.selectall')}}</label>
                        <label><button type="button" class="btn btn-action" data-action="delete">删除</button></label>
                        <label><button type="button" class="btn btn-action" data-action="move">移动</button></label>
                        <label><button type="button" class="btn btn-action" data-action="review" data-value="pass">审核通过</button></label>
                        <label><button type="button" class="btn btn-action" data-action="review" data-value="refuse">审核不过</button></label>
                    </td>
                </tr>
                </tfoot>
            </table>
        </form>
    </div>
    <script type="text/template" id="targetTpl">
        <span style="float: left; line-height: 28px;">选择目标分类：</span>
        <select name="target" class="select" title="" id="moveTarget">
            {loop $catloglist[0] $catid1 $cat1}
            <option value="{$catid1}">{$cat1[name]}</option>
            {loop $catloglist[$catid1] $catid2 $cat2}
            <option value="{$catid2}">|--{$cat2[name]}</option>
            {loop $catloglist[$catid2] $catid3 $cat3}
            <option value="{$catid3}">|--|--{$cat3[name]}</option>
            {/loop}
            {/loop}
            {/loop}
        </select>
    </script>
    <script type="text/javascript">
        $(function () {
            var spinner;
            $("img[rel=pickimage]").on('click', function () {
                var self = this;
                var aid = $(this).attr('data-id');
                DSXUI.showImagePicker(function (data) {
                    $(self).attr('src', data.imageurl);
                    $.post("{{url('/admin/post/setimage')}}", {aid:aid,image:data.image});
                });
            });
            $(".btn-action").on('click', function () {
                if ($(".itemCheckBox:checked").length === 0){
                    DSXUI.error('请选择文章');
                    return false;
                }
                var action = $(this).attr('data-action');
                if (action === 'delete'){
                    DSXUI.showConfirm('删除文章', '确认要删除所选文章吗?', function () {
                        $("#listForm").ajaxSubmit({
                            url:"{{url('/admin/post/delete')}}",
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
                if (action === 'move'){
                    DSXUI.dialog({
                        content:$("#targetTpl").html(),
                        title:'移动文章',
                        onConfirm:function (dlg) {
                            var target = $("#moveTarget").val();
                            dlg.close();
                            $("#listForm").ajaxSubmit({
                                url:"{URL:('/admin/post/move')}",
                                dataType:'json',
                                data:{target:target},
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
                        }
                    });
                }
                if (action === 'review'){
                    $("#listForm").ajaxSubmit({
                        url:"/admin/post/review",
                        dataType:'json',
                        data:{event:$(this).attr('data-value')},
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
                }
            });
        });
    </script>
@stop
