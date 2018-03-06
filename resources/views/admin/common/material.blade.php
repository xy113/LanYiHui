@extends('admin.default')

@section('content')
    <div class="navigation">
        <a>后台管理</a>
        <span>></span>
        <a>素材管理</a>
        <span>></span>
        <a>素材列表</a>
    </div>
    <script src="/DatePicker/WdatePicker.js" type="text/javascript"></script>
    <div class="search-container" id="search-container">
        <form method="get" id="searchFrom">
            <input type="hidden" name="type" value="{{$type}}">
            <div class="row">
                <div class="cell">
                    <label>用户ID:</label>
                    <div class="field"><input type="text" title="" class="input-text" name="uid" value="{{$uid}}"></div>
                </div>
                <div class="cell">
                    <label>用户名:</label>
                    <div class="field"><input type="text" title="" class="input-text" name="username" value="{{$username}}"></div>
                </div>
                <div class="cell">
                    <label>名称:</label>
                    <div class="field"><input type="text" title="" class="input-text" name="name" value="{{$name}}"></div>
                </div>
            </div>
            <div class="row">
                <div class="cell">
                    <label>上传时间:</label>
                    <div class="field">
                        <input type="text" title="" class="input-text" name="time_begin" value="{{$time_begin}}" onclick="WdatePicker()" style="width: 100px;"> -
                        <input type="text" title="" class="input-text" name="time_end" value="{{$time_end}}" onclick="WdatePicker()" style="width: 100px;">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="cell">
                    <label></label>
                    <div class="field">
                        <button type="submit" class="button">搜索</button>
                        <button type="button" class="button button-cancel" id="addMaterial">添加素材</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="tabs-container">
        <div class="tabs">
            @foreach($material_types as $k=>$v)
                <div class="tab @if($type==$k)on @endif"><a href="{{action('Admin\MaterialController@index',['type'=>$k])}}">{{$v}}</a><span>|</span></div>
            @endforeach
        </div>
    </div>
    <div class="content-div">
        <form method="post" autocomplete="off" id="listForm">
            {{csrf_field()}}
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="listtable">
                <thead>
                <tr>
                    <th width="50" class="center">选?</th>
                    <th width="60">图片</th>
                    <th>名称</th>
                    <th>所属用户</th>
                    <th width="120">大小</th>
                    <th width="140">上传时间</th>
                </tr>
                </thead>
                <tbody>
                @foreach($itemlist as $id=>$item)
                    <tr>
                        <td class="center"><input type="checkbox" title="" class="checkbox checkmark itemCheckBox" name="materials[]" value="{{$id}}"></td>
                        <td>
                            @if($type === 'image')
                            <img src="{{image_url($item['thumb'])}}" width="50" height="50">
                            @elseif($type === 'video')
                            <img src="{{asset('images/common/video.png')}}" width="50" height="50">
                            @elseif($type === 'voice')
                            <img src="{{asset('images/common/audio.png')}}" width="50" height="50">
                            @elseif($type === 'doc')
                            <img src="{{asset('images/common/doc.png')}}" width="50" height="50">
                            @else
                            <img src="{{asset('images/common/file.png')}}" width="50" height="50">
                            @endif
                        </td>
                        <td>{{$item['name']}}</td>
                        <td>{{$item['username']}}</td>
                        <td>{{formatSize($item['size'])}}</td>
                        <td>{{@date('Y-m-d H:i:s', $item['created_at'])}}</td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <td colspan="10">
                        <span class="float-right">{!! $pagination !!}</span>
                        <label><input type="checkbox" class="checkbox checkall"> {{trans('common.selectall')}}</label>
                        <label><button type="button" class="btn" id="deleteButton">删除</button></label>
                        <label><button type="button" class="btn" onclick="DSXUtil.reFresh()">刷新</button></label>
                    </td>
                </tr>
                </tfoot>
            </table>
        </form>
    </div>

    <script type="text/javascript">
        var spinner;
        $(function () {
            $("#deleteButton").on('click', function () {
                if ($(".itemCheckBox:checked").length === 0){
                    DSXUI.error('请选择项目');
                    return false;
                }
                DSXUI.showConfirm('删除素材', '确认要删除所选素材吗?', function () {
                    $("#listForm").ajaxSubmit({
                        url:"/admin/material/delete",
                        dataType:'json',
                        beforeSend:function () {
                            spinner = DSXUI.showSpinner();
                        },success:function (response) {
                            setTimeout(function () {
                                spinner.close();
                                if (response.errcode === 0){
                                    DSXUtil.reFresh();
                                }else {
                                    DSXUI.error('删除失败');
                                }
                            }, 500);
                        }
                    });
                });
            });
        });
    </script>
    @if($type === 'image')
    <script type="text/javascript">
        $("#addMaterial").on('click', function () {
            DSXUI.showImagePicker(function () {
                DSXUtil.reFresh();
            });
        });
    </script>
    @endif
@stop
