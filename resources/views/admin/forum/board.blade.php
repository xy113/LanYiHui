@extends('layouts.admin')

@section('title', '版面设置')

@section('content')
    <div class="console-title">
        <h2>讨论区->版面设置</h2>
    </div>
    <div class="content-div">
        <form method="post" action="">
            {{csrf_field()}}
            <input type="hidden" name="formsubmit" value="yes">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="listtable">
                <thead>
                <tr>
                    <th width="40">删?</th>
                    <th width="60">图标</th>
                    <th width="300">分类名称</th>
                    <th width="80">显示顺序</th>
                    <th>显示</th>
                </tr>
                </thead>
                <tbody id="newCategory">
                @foreach($itemlist as $item)
                    <tr>
                        <td><input type="checkbox" title="" class="checkbox checkmark" name="delete[]" value="{{$item['boardid']}}" /></td>
                        <td><img src="{{image_url($item['icon'])}}" width="50" height="50" rel="pickimage" data-id="{{$item['boardid']}}"></td>
                        <td><input type="text" title="" class="input-text w200" name="boardlist[{{$item['boardid']}}][title]" value="{{$item['title']}}" maxlength="10"> </td>
                        <td><input type="text" title="" class="input-text w60" name="boardlist[{{$item['boardid']}}][displayorder]" value="{{$item['displayorder']}}" maxlength="4"></td>
                        <td><input type="checkbox" class="checkbox" title="" value="1" name="boardlist[{{$item['boardid']}}][visible]"@if($item['visible']) checked="checked"@endif></td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <td colspan="5">
                        <label><input type="checkbox" class="checkbox checkall" name="delete[]" value="0" /> 全选</label>
                        <a href="javascript:;" onclick="addClass()"><i class="iconfont icon-roundadd"></i>添加分类</a></td>
                </tr>
                <tr>
                    <td colspan="5">
                        <input type="submit" class="button" value="提交" />
                        <input type="button" class="button button-cancel" value="刷新" onclick="DSXUtil.reFresh()" />
                    </td>
                </tr>
                </tfoot>
            </table>
        </form>
    </div>
    <script type="text/template" id="J-category-tpl">
        <tr class="white">
            <td></td>
            <td></td>
            <td><input type="text" title="" class="input-text w200" name="boardlist[#k#][title]" value="" maxlength="10"></td>
            <td><input type="text" title="" class="input-text w60" name="boardlist[#k#][displayorder]" value="0" maxlength="4"></td>
            <td><input type="checkbox" class="checkbox" title="" value="1" name="boardlist[#k#][visible]" checked="checked"></td>
        </tr>
    </script>
    <script type="text/javascript">
        var k = 0;
        function addClass(){
            k--;
            var html = $("#J-category-tpl").html().replace(/#k#/g, k);
            $("#newCategory").append(html);
        }
        (function () {
            $("img[rel=pickimage]").on('click', function () {
                var self = this;
                var boardid = $(this).attr('data-id');
                DSXUI.showImagePicker(function (data) {
                    $(self).attr('src', data.imageurl);
                    $.post("{{url('/admin/forum/seticon')}}", {boardid:boardid,icon:data.image});
                });
            });
        })();
    </script>
@stop
