@extends('layouts.member')

@section('title', '发布文章')

@section('content')
    <div class="console-title">
        <a href="{{url('member/post')}}" class="button float-right">返回列表</a>
        <h2>我的文章</h2>
    </div>
    <div class="content-div">
        <form method="post" id="postForm" autocomplete="off">
            {{csrf_field()}}
            <input type="hidden" name="formsubmit" value="yes">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="formtable">
                <tr>
                    <td width="65">文章标题</td>
                    <td><input type="text" class="input-text" placeholder="在这里输入标题" name="newpost[title]" value="{{$item['title'] or ''}}" id="title" style="width: 760px;"></td>
                </tr>
            </table>
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="formtable">
                <tr>
                    <td width="65">目录分类</td>
                    <td width="380">
                        <select name="newpost[catid]" class="select" title="">
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
                    </td>
                    <td width="80">文章来源</td>
                    <td><input type="text" title="" class="input-text" name="newpost[from]" value="{{$item['from'] or ''}}"></td>
                    <td rowspan="5" width="160">
                        <input type="hidden" id="post_image" name="newpost[image]" value="{{$item['image'] or ''}}">
                        <div class="post-image-box" title="点击更换图片">
                            <div class="bg-cover" id="post_image_preview" style="width: 140px; height: 140px; background-color: #f5f5f5; display: block; background-image: url({{image_url($item['image'])}})">
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>文章别名</td>
                    <td><input type="text" title="" class="input-text" name="newpost[alias]" value="{{$item['alias'] or ''}}"></td>
                    <td>来源地址</td>
                    <td><input type="text" title="" class="input-text" name="newpost[fromurl]" value="{{$item['fromurl'] or ''}}"></td>
                </tr>
                <tr>
                    <td>文章作者</td>
                    <td><input type="text" title="" class="input-text" name="newpost[author]" value="{{$item['author'] or ''}}"></td>
                    <td>文章标签</td>
                    <td><input type="text" title="" class="input-text" name="newpost[tags]" value="{{$item['tags'] or ''}}"></td>
                </tr>
                <tr>
                    <td>阅读价格</td>
                    <td><input type="text" title="" class="input-text" name="newpost[price]" value="{{$item['price'] or ''}}"></td>
                    <td>发布时间</td>
                    <td><input type="text" title="" class="input-text" name="newpost[created_at]" value="{{$item['created_at'] or ''}}"></td>
                </tr>
            </table>
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="formtable">
                <tr>
                    <td width="65">内容摘要</td>
                    <td><textarea title="" style="width:100%;" name="newpost[summary]">{{$item['summary'] or ''}}</textarea></td>
                </tr>
            </table>
            <!--文章内容部分-->
            <div class="swithContent" id="content-article">
                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="formtable">
                    <tr>
                        <td width="65">文章内容</td>
                        <td>
                            <div style="box-sizing:border-box">
                                @include('common.editor', ['name' => 'content', 'content'=>$content['content'], 'params'=>[]])
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="formtable">
                <tr>
                    <td width="65"></td>
                    <td><input type="submit" class="button button-long" value="发布"></td>
                </tr>
            </table>
        </form>
    </div>
    <script type="text/javascript">
        function removeItem(o){
            DSXUI.showConfirm('删除图片', '确认要删除此图片吗?', function () {
                $(o).parent().remove();
            });
        }

        $("#post_image_preview").click(function(e) {
            DSXUI.showImagePicker(function (data) {
                $("#post_image_preview").css('background-image', 'url('+data.imageurl+')');
                $("#post_image").val(data.image);
            });
        });

        ;$(function(){
            $("#postForm").on('submit',function(e) {
                var title = $.trim($("#title").val());
                if(!title){
                    DSXUI.error("{{trans('post.post title empty')}}");
                    return false;
                }
            });
            var k = 0;
            $("#addNewImg").on('click', function () {
                DSXUI.showImagePicker(function (data) {
                    $("#post-gallery").append('<div class="row">' +
                        '<input type="hidden" name="gallery['+k+'][thumb]" value="'+data.thumb+'">' +
                        '<input type="hidden" name="gallery['+k+'][image]" value="'+data.image+'">' +
                        '<div class="img bg-cover" style="background-image: url('+data.thumburl+')"></div>' +
                        '<div class="con"><textarea class="textarea" name="gallery['+k+'][description]" placeholder="图片说明文字"></textarea></div>' +
                        '<a class="delete" onclick="removeItem(this)">&times;</a></div>');
                });
                k--;
            });
            $("#post-gallery").sortable();
        });
    </script>
@stop
