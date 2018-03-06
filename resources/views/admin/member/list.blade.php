@extends('admin.default')

@section('scripts')
    <script src="/DatePicker/WdatePicker.js" type="text/javascript"></script>
@stop

@section('content')
    <div class="navigation">
        <a>后台管理</a>
        <span>></span>
        <a>会员管理</a>
        <span>></span>
        <a>会员列表</a>
    </div>
    <div class="search-container">
        <form method="get" id="searchFrom" action="/admin/member/index">
            <div class="row">
                <div class="cell">
                    <label>用户名:</label>
                    <div class="field"><input type="text" title="" class="input-text" name="username" value="{{$username or ''}}"></div>
                </div>
                <div class="cell">
                    <label>手机号:</label>
                    <div class="field"><input type="text" title="" class="input-text" name="mobile" value="{{$mobile}}"></div>
                </div>
                <div class="cell">
                    <label>邮箱:</label>
                    <div class="field"><input type="text" title="" class="input-text" name="email" value="{{$email}}"></div>
                </div>
            </div>
            <div class="row">
                <div class="cell">
                    <label>会员ID:</label>
                    <div class="field"><input type="text" title="" class="input-text" name="uid" value="{{$uid}}"></div>
                </div>
                <div class="cell">
                    <label>注册日期:</label>
                    <div class="field">
                        <input type="text" title="" class="input-text" name="reg_time_begin" onclick="WdatePicker()" value="{{$reg_time_begin}}" style="width: 100px;"> -
                        <input type="text" title="" class="input-text" name="reg_time_end" onclick="WdatePicker()" value="{{$reg_time_end}}" style="width: 100px;">
                    </div>
                </div>
                <div class="cell">
                    <label>最后登录:</label>
                    <div class="field">
                        <input type="text" title="" class="input-text" name="last_visit_begin" onclick="WdatePicker()" value="{{$last_visit_begin}}" style="width: 100px;"> -
                        <input type="text" title="" class="input-text" name="last_visit_end" onclick="WdatePicker()" value="{{$last_visit_end}}" style="width: 100px;">
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
        <form method="post" id="listForm" action="">
            {{csrf_field()}}
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="listtable">
                <thead>
                <tr>
                    <th width="20">选</th>
                    <th width="30">头像</th>
                    <th>姓名</th>
                    <th>手机号</th>
                    <th>电子邮箱</th>
                    <th>用户组</th>
                    <th>注册日期</th>
                    <th>最后登录</th>
                    <th>状态</th>
                </tr>
                </thead>
                <tbody id="members">
                @foreach($memberlist as $uid=>$member)
                <tr>
                    <td><input title="" type="checkbox" class="checkbox checkmark" name="members[]" value="{{$uid}}" /></td>
                    <td><img src="{avatar:$uid|small}" width="30" height="30" style="border-radius:100%;"></td>
                    <th><a>{{$member->username}}</a></th>
                    <td>{{$member->mobile}}</td>
                    <td>{{$member->email}}</td>
                    <td>{{$member->grouptitle}}</td>
                    <td><a href="http://ip.taobao.com/?ip={{$member->regip}}" target="_blank">{{date('Y-m-d H:i:s', $member->regdate)}}</a></td>
                    <td><a href="http://ip.taobao.com/?ip={{$member->lastvisitip}}" target="_blank">{{date('Y-m-d H:i:s', $member->lastvisit)}}</a></td>
                    <td>{{$status_name or ''}}</td>
                </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <td colspan="12">
                        <div class="pagination float-right">{{$pagination}}</div>
                        <label><input type="checkbox" class="checkbox checkall" /> 全选</label>
                        <label><button type="button" class="btn btn-action" data-action="delete">删除</button></label>
                        <label><button type="button" class="btn btn-action" data-action="allow">允许登录</button></label>
                        <label><button type="button" class="btn btn-action" data-action="forbiden">禁止登录</button></label>
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
                if (action === 'delete'){
                    DSXUI.showConfirm('删除会员', '确认要删除所选会员吗?', function () {
                        $form.attr('action','{{url('/admin/member/delete')}}');
                        submitForm();
                    });
                }
            });
        });
    </script>
@stop
