@extends('layouts.admin')

@section('title', '联谊会会员')

@section('content')
    <style>
        .tplink{
            text-overflow: ellipsis;
            white-space: nowrap;
            overflow: hidden;
            max-width: 100px;
        }
        #tplink{
            position: absolute;
            max-width: 180px;
            background-color: #f0f0f0;
            padding: 1rem;
            border: 1px solid #dddddd;
        }
    </style>
    <div class="navigation">
        <a>后台管理</a>
        <span>></span>
        <a>联谊会会员</a>
        <span>></span>
        <a>会员列表</a>
        <span>></span>
        <a>会员经历</a>
    </div>
    <div class="search-container">
        <form method="get" id="searchFrom">
            <div class="row">
                <input style="display: none;" name="id" value="{{$id}}">
                <div class="cell">
                    <label>类型:</label>
                    <div class="field">
                        <select name="part" class="select" title="">
                            <option value="all">不限</option>
                            <option value="0"@if($part==='0') selected="selected"@endif>部门</option>
                            <option value="1"@if($part==='1') selected="selected"@endif>活动</option>
                            <option value="2"@if($part==='2') selected="selected"@endif>分会</option>
                        </select>
                    </div>
                </div>
                <div class="cell">
                    <label>部门/活动:</label>
                    <div class="field"><input type="text" title="" class="input-text" name="department" value="{{$department}}"></div>
                </div>
                <div class="cell">
                    <label>职务:</label>
                    <div class="field"><input type="text" title="" class="input-text" name="role" value="{{$role}}"></div>
                </div>
            </div>
            <div class="row">
                <div class="cell">
                    <label>年份:</label>
                    <div class="field"><input type="text" title="" class="input-text" name="year" value="{{$year}}"></div>
                </div>
                <div class="cell">
                    <label>假期:</label>
                    <div class="field">
                        <select name="vacation" class="select" title="">
                            <option value="all">不限</option>
                            <option value="0"@if($vacation==='0') selected="selected"@endif>寒假</option>
                            <option value="1"@if($vacation==='1') selected="selected"@endif>暑假</option>
                        </select>
                    </div>
                </div>
                <div class="cell">
                    <label>状态:</label>
                    <div class="field">
                        <select name="status" class="select" title="">
                            <option value="all">不限</option>
                            <option value="0"@if($status=='-1') selected="selected"@endif>未通过</option>
                            <option value="0"@if($status=='0') selected="selected"@endif>未审核</option>
                            <option value="1"@if($status=='1') selected="selected"@endif>修改待审核</option>
                            <option value="1"@if($status=='1') selected="selected"@endif>已通过</option>
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
                    <th>类型</th>
                    <th>部门/活动</th>
                    <th>职务</th>
                    <th>年份</th>
                    <th>假期</th>
                    <th width="100">详情</th>
                    <th width="80">认证状态</th>
                </tr>
                </thead>
                <tbody id="members">
                @foreach($itemlist as $id=>$item)
                    <tr>
                        <td><input title="" type="checkbox" class="checkbox checkmark" name="members[]" value="{{$id}}" /></td>
                        <td><img src="{{avatar($item['uid'], 'middle')}}" width="30" height="30" style="border-radius:100%;"></td>
                        <th><a>{{$item->archive->name}}</a></th>
                        <td>@if($item['part']=='0')部门@elseif($item['part']==1)活动@else分会@endif</td>
                        <td>{{$item['department']}}</td>
                        <td>{{$item['role']}}</td>
                        <td>{{$item['year']}}</td>
                        <td>@if($item['vacation']=='0')寒假@else暑假@endif</td>
                        <td title="{{$item['description']}}" class="tplink">
                            {{$item['description']}}
                        </td>
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

        $(function(){
            var x=5;
            var y=5;
            $(".tplink").mouseover(function(e){
                this.myTitle=this.title;
                this.title="";
                var tooltip="<div id='tplink'>"+this.myTitle+"</div>";   //创建DIV元素
                $('.content-div').append(tooltip);//追加到文档中
                $("#tplink").css({"top": (e.pageY+y) + "px","left": (e.pageX+x) + "px"}).show();    //设置X  Y坐标， 并且显示
            }).mouseout(function(){
                this.title=this.myTitle;
                $("#tplink").remove();    //移除
            }).mousemove(function(e){
                $("#tplink").css({"top": (e.pageY+y) + "px","left": (e.pageX+x) + "px"});
            })
        })
    </script>
@stop
