@extends('layouts.admin')

@section('title', '联谊会会员')

@section('content')
    <div class="navigation">
        <a>后台管理</a>
        <span>></span>
        <a>联谊会会员</a>
        <span>></span>
        <a>会员列表</a>
    </div>
    <div class="search-container">
        <form method="get" id="searchFrom">
            <div class="row">
                <div class="cell">
                    <label>姓名:</label>
                    <div class="field"><input type="text" title="" class="input-text" name="fullname" value="{{$fullname}}"></div>
                </div>
                <div class="cell">
                    <label>手机号:</label>
                    <div class="field"><input type="text" title="" class="input-text" name="phone" value="{{$phone}}"></div>
                </div>
                <div class="cell">
                    <label>所在大学:</label>
                    <div class="field"><input type="text" title="" class="input-text" name="university" value="{{$university}}"></div>
                </div>
            </div>
            <div class="row">
                <div class="cell">
                    <label>性别:</label>
                    <div class="field">
                        <select class="select" name="sex" title="">
                            <option value="all">不限</option>
                            <option value="0"@if($sex==='0') selected="selected"@endif>女</option>
                            <option value="1"@if($sex==='1') selected="selected"@endif>男</option>
                        </select>
                    </div>
                </div>
                <div class="cell">
                    <label>入学年份:</label>
                    <div class="field"><input type="text" title="" class="input-text" name="enrollyear" value="{{$enrollyear}}"></div>
                </div>
                <div class="cell">
                    <label>认证状态:</label>
                    <div class="field">
                        <select name="status" class="select" title="">
                            <option value="all">不限</option>
                            <option value="0"@if($status==='0') selected="selected"@endif>等待认证</option>
                            <option value="1"@if($status==='1') selected="selected"@endif>认证通过</option>
                            <option value="-1"@if($status==='-1') selected="selected"@endif>审核不过</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="cell">
                    <label></label>
                    <div class="field">
                        <button type="submit" class="button" id="btn-search">搜索</button>
                        <button type="button" class="button button-cancel" id="btn-export">重置</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="content-div">
        <form method="post" id="listForm">
            {{csrf_field()}}
            <input type="hidden" name="formsubmit" value="yes">
            <input type="hidden" name="eventType" id="eventType" value="">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="listtable">
                <thead>
                <tr>
                    <th width="20">选</th>
                    <th width="40">照片</th>
                    <th>姓名</th>
                    <th>手机号</th>
                    <th>性别</th>
                    <th>所在大学</th>
                    <th>入学年份</th>
                    <th>籍贯</th>
                    <th>所在地</th>
                    <th width="80">认证状态</th>
                </tr>
                </thead>
                <tbody id="members">
                @foreach($itemlist as $id=>$item)
                    <tr>
                        <td><input title="" type="checkbox" class="checkbox checkmark" name="members[]" value="{{$id}}" /></td>
                        <td><img src="{{avatar($item['uid'], 'middle')}}" width="30" height="30" style="border-radius:100%;"></td>
                        <th><a>{{$item['fullname']}}</a></th>
                        <td>{{$item['phone']}}</td>
                        <td>@if($item['sex'])男@else女@endif</td>
                        <td>{{$item['university']}}</td>
                        <td>{{$item['enrollyear']}}</td>
                        <td>{{$item['birthplace']}}</td>
                        <td>{{$item['location']}}</td>
                        <td>
                            @if ($item['status'] === -1)
                                <span style="color: #FF0000">{{$item['status_title']}}</span>
                            @elseif($item['status'] === 1)
                                <span style="color: #578936">{{$item['status_title']}}</span>
                            @else
                                <span>{{$item['status_title']}}</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <td colspan="12">
                        <div class="pagination float-right">{{$pagination}}</div>
                        <label><input type="checkbox" class="checkbox checkall" /> 全选</label>
                        <label><button type="button" class="btn btn-action" data-action="delete">删除</button></label>
                        <label><button type="button" class="btn btn-action" data-action="pass">审核通过</button></label>
                        <label><button type="button" class="btn btn-action" data-action="refuse">审核不过</button></label>
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
                $("#eventType").val(action);
                if (action === 'delete'){
                    DSXUI.showConfirm('删除会员', '确认要删除所选会员吗?', function () {
                        submitForm();
                    });
                }else {
                    submitForm();
                }
            });
        });
    </script>
@stop
