@extends('layouts.admin')

@section('title', '发布信息')

@section('content')
    <div class="console-title">
        <div class="float-right">
            <a href="/admin/recruit" class="button">信息列表</a>
        </div>
        <h2>联谊会招募->发布职位</h2>
    </div>

    <div class="content-div">
        <form method="post" id="Form">
            <input type="hidden" name="formsubmit" value="yes">
            {{csrf_field()}}
            <table cellpadding="0" cellspacing="0" width="100%" class="formtable">
                <tbody>
                <tr>
                    <td width="80">职位名称</td>
                    <td width="320"><input name="item[title]" id="title" title="" type="text" class="input-text" value="{{$item['title']}}"></td>
                    <td class="tips">职位名称，不能含有特殊字符和符号</td>
                </tr>
                <tr>
                    <td>招募人数</td>
                    <td><input name="item[num]" title="" id="num" type="text" class="input-text" value="{{$item['num']}}"></td>
                    <td class="tips">招募人数</td>
                </tr>
                <tr>
                    <td>分类目录</td>
                    <td colspan="2">
                        <select class="select" title="" name="item[catid]">
                            @foreach ($catloglist as $catlog)
                                <option value="{{$catlog['catid']}}"@if($catlog['catid']==$item['catid']) selected="selected"@endif>{{$catlog['name']}}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>配图</td>
                    <td>
                        <div class="bg-cover" id="pickImage" style="width: 100px; height: 100px; background-color: #f5f5f5;background-image: url({{image_url($item['image'])}});"></div>
                        <input name="item[image]" type="hidden" id="image" value="{{$item['image']}}">
                    </td>
                    <td class="tips">图片格式为jpg，jpeg，png，gif，大小不要超过2MB</td>
                </tr>
                <tr>
                    <td>职务描述</td>
                    <td colspan="2">@include('common.editor', ['name' => 'item[content]', 'content' => $item['content'], 'params'=>[]])</td>
                </tr>
                </tbody>
                <tfoot>
                <tr>
                    <td></td>
                    <td colspan="2">
                        <button type="submit" class="button" style="width: 120px;">提交</button>
                    </td>
                </tr>
                </tfoot>
            </table>
        </form>
    </div>

    <script type="text/javascript">
        $(function () {
            $("#pickImage").on('click', function () {
                DSXUI.showImagePicker(function (data) {
                    $("#pickImage").css({'background-image':'url('+data.imageurl+')'});
                    $("#image").val(data.image);
                });
            });

            $("#Form").on('submit', function () {
                var title = $.trim($("#title").val());
                if (!title) {
                    DSXUI.error('请填写职务名称');
                    return false;
                }

                var num = $.trim($("#num").val());
                if (!num) {
                    DSXUI.error('请填写招募人数');
                    return false;
                }
            });
        });
    </script>
@stop
