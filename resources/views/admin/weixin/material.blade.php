@extends('admin.default')

@section('content')
    <div class="console-title">
        <div class="float-right">
            <a class="button" id="addMaterial">添加素材</a>
        </div>
        <h2>微信素材管理</h2>
    </div>
    <div class="toolbar">
        @if($type=='image')
        <span class="f-right">图片不超过2M，支持bmp/png/jpeg/jpg/gif格式</span>
        @elseif($type=='voice')
        <span class="f-right">声音不超过2M，播放长度不超过60s，mp3/wma/wav/amr格式</span>
        @else
        <span class="f-right">视频不超过10MB，支持MP4格式</span>
        @endif
    </div>
    <div class="tabs-container">
        <div class="tabs">
            @foreach($material_types as $k=>$v)
            <div class="tab @if($k==$type)on @endif"><a href="{{action('Admin\WeixinController@material', ['type'=>$k])}}">{{$v}}</a><span>|</span></div>
            @endforeach
        </div>
    </div>
    <div class="content-div">
        <form method="post" id="listForm" autocomplete="off">
            {{csrf_field()}}
            <input type="hidden" name="formsubmit" value="yes">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="listtable">
                <thead>
                <tr>
                    <th width="40">选?</th>
                    <th width="50">图片</th>
                    <th width="200">名称</th>
                    <th width="350">media_id</th>
                    <th>URL</th>
                </tr>
                </thead>
                <tbody>
                @foreach($itemlist as $item)
                <tr>
                    <td class="center"><input title="" type="checkbox" class="checkbox checkmark itemCheckBox" name="materials[]" value="{{$item['media_id']}}"></td>
                    <td>
                        @if($type=='image')
                        <div class="bg-cover lazyload" data-original="{{action('Admin\WeixinController@viewimage', ['media_id'=>$item['media_id']])}}" style="width: 50px; height: 50px;"></div>
                        @elseif ($type=='video')
                        <img src="{{asset('images/common/video.png')}}" width="50" height="50">
                        @else
                        <img src="{{asset('images/common/audio.png')}}" width="50" height="50">
                        @endif
                    </td>
                    <td>{{$item['name']}}</td>
                    <td>{{$item['media_id']}}</td>
                    <td>{{$item['url'] or ''}}</td>
                </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <td colspan="10">
                        <div class="float-right">{!! $pagination !!}</div>
                        <label><input type="checkbox" class="checkbox checkall"> {{trans('common.selectall')}}</label>
                        <label><button type="button" class="btn" id="deleteButton">删除</button></label>
                        <label><button type="button" class="btn" data-action="refresh">刷新</button></label>
                    </td>
                </tr>
                </tfoot>
            </table>
        </form>
    </div>
    <script type="text/x-template" id="J-add-video-tpl">
        <div style="padding:20px; display:block;">
            <form method="post" id="J-video-form">
                <table cellpadding="0" cellspacing="0" border="0" width="100%" class="formtable">
                    <tbody>
                    <tr>
                        <td width="40">视频</td>
                        <td><input type="hidden" name="media" id="J-video-media"><input title="" type="text" class="input-text w300" id="J-video-pick" readonly></td>
                        <td class="tips">视频不超过10MB，支持MP4格式<td>
                    </tr>
                    <tr>
                        <td>标题</td>
                        <td><input title="" type="text" class="input-text w300" name="title" id="J-video-title"></td>
                        <td class="tips">标题，不超过30个字<td>
                    </tr>
                    <tr>
                        <td>简介</td>
                        <td><textarea title="" class="textarea w300" name="introduction" id="J-video-introduction"></textarea></td>
                        <td class="tips">视频简介，不超过120个字<td>
                    </tr>
                    </tbody>
                </table>
            </form>
        </div>
    </script>
    @if($type=='image')
    <script type="text/javascript">
        $(function () {
            $("#addMaterial").on('click', function () {
                DSXUI.showImagePicker(function (data) {
                    var loading;
                    $.ajax({
                        type:'POST',
                        url:"{{action('Admin\WeixinController@add_material')}}",
                        data:{media:data.image, type:'image'},
                        beforeSend: function(){
                            loading = DSXUI.showloading('正在上传素材到微信服务器..');
                        },
                        success: function(response){
                            loading.close();
                            if(response.errcode === 0){
                                DSXUtil.reFresh();
                            }else {
                                DSXUI.error('素材添加失败');
                            }
                        }
                    });
                });
            });
        });
    </script>
    @endif
    <script type="text/javascript">
        $(function () {
            $("#deleteButton").on('click', function () {
                if ($(".itemCheckBox:checked").length === 0){
                    DSXUI.error('请选择素材');
                    return false;
                }
                var spinner = null;
                DSXUI.showConfirm('删除素材', '确认要删除所选素材吗?', function () {
                    $("#listForm").ajaxSubmit({
                        dataType:'json',
                        beforeSend:function () {
                            spinner = DSXUI.showSpinner();
                        },success:function (response) {
                            setTimeout(function () {
                                spinner.close();
                                if (response.errcode === 0){
                                    DSXUtil.reFresh();
                                }else  {
                                    DSXUI.error(response.errmsg);
                                }
                            }, 500);
                        }
                    });
                });
            });
        })
    </script>
@stop
