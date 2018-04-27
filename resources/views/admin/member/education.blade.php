@extends('layouts.admin')

@section('title', '联谊会会员')

@section('content')
    <div class="navigation">
        <a>后台管理</a>
        <span>></span>
        <a>联谊会会员</a>
        <span>></span>
        <a>会员列表</a>
        <span>></span>
        <a>教育经历</a>
    </div>
    <div class="search-container">
        <form method="get" id="searchFrom">
            <div class="row">
                <input style="display: none;" name="id" value="{{$id}}">
                <div class="cell">
                    <label>学校名称：</label>
                    <div class="field"><input type="text" title="" class="input-text" name="university" value="{{$university}}"></div>
                </div>
                <div class="cell">
                    <label>专业名称:</label>
                    <div class="field"><input type="text" title="" class="input-text" name="major" value="{{$major}}"></div>
                </div>
                <div class="cell">
                    <label>状态:</label>
                    <div class="field">
                        <select class="select" name="status" title="">
                            <option value="all">不限</option>
                            <option value="-1"@if($status==='-1') selected="selected"@endif>未通过</option>
                            <option value="0"@if($status==='0') selected="selected"@endif>待审核</option>
                            <option value="1"@if($status==='1') selected="selected"@endif>修改待审核</option>
                            <option value="2"@if($status==='2') selected="selected"@endif>已审核</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="cell">
                    <label>学历:</label>
                    <div class="field">
                        <select class="select" name="degree" title="">
                            <option value="all">不限</option>
                            <option value="7"@if($degree==='7') selected="selected"@endif>博士</option>
                            <option value="6"@if($degree==='6') selected="selected"@endif>硕士</option>
                            <option value="5"@if($degree==='5') selected="selected"@endif>本科</option>
                            <option value="4"@if($degree==='4') selected="selected"@endif>专科</option>
                            <option value="3"@if($degree==='3') selected="selected"@endif>高中</option>
                            <option value="2"@if($degree==='2') selected="selected"@endif>初中</option>
                            <option value="1"@if($degree==='1') selected="selected"@endif>小学</option>
                            <option value="0"@if($degree==='0') selected="selected"@endif>其他</option>
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
                    <th width="40">头像</th>
                    <th>姓名</th>
                    <th>学校</th>
                    <th>学历</th>
                    <th>专业</th>
                    <th>入学时间</th>
                    <th>毕业时间</th>
                    <th width="80">认证状态</th>
                </tr>
                </thead>
                <tbody id="members">
                @foreach($itemlist as $id=>$item)
                    <tr>
                        <td><input title="" type="checkbox" class="checkbox checkmark" name="members[]" value="{{$id}}" /></td>
                        <td><img src="{{avatar($item->archive['uid'], 'middle')}}" width="30" height="30" style="border-radius:100%;"></td>
                        <th><a>{{$item->archive['fullname']}}</a></th>
                        <td>{{$item['school']}}</td>
                        <td>@switch($item->degree)
                                @case('1')
                                小学
                                @break
                                @case('2')
                                初中
                                @break
                                @case('3')
                                高中
                                @break
                                @case('4')
                                专科
                                @break
                                @case('5')
                                本科
                                @break
                                @case('6')
                                硕士
                                @break
                                @case('7')
                                博士
                                @break
                                @default
                                其他
                            @endswitch</td>
                        <td class="self-btn">{{$item['major']}}</td>
                        <td class="self-btn">{{date('Y-m-d',$item['start_time'])}}</td>
                        <td class="self-btn">{{date('Y-m-d',$item['end_time'])}}</td>
                        <td>
                            @if ($item['status'] == -1)
                                <span style="color: #FF0000">未通过</span>
                            @elseif($item['status'] == 1)
                                <span>修改待审核</span>
                            @elseif($item['status'] == 2)
                                <span style="color: #578936">已通过</span>
                            @else
                                <span>未审核</span>
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
