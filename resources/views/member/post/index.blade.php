@extends('layouts.member')

@section('title', '我的文章')

@section('content')
    <div class="console-title">
        <a href="{{url('member/post/publish')}}" class="button float-right">发布文章</a>
        <h2>我的文章</h2>
    </div>
    <div class="content-div">
        <form method="post" id="listForm">
            {{csrf_field()}}
            <table cellpadding="0" cellspacing="0" width="100%" border="0" class="listtable">
                <thead>
                <tr>
                    <th width="30"><input type="checkbox" class="checkbox" title="" data-action="checkall"></th>
                    <th width="60">图片</th>
                    <th>文章标题</th>
                    <th>分类</th>
                    <th width="200">时间</th>
                    <th>点击</th>
                    <th width="50" class="align-right">选项</th>
                </tr>
                </thead>
                <tbody>
                @foreach($itemlist as $aid=>$item)
                    <tr id="favorite-item-{{$aid}}">
                        <td><input type="checkbox" class="checkbox checkmark" title="" name="items[]" value="{{$aid}}"></td>
                        <td>
                            <div class="bg-cover" style="width: 80px; height: 60px; background-image: url({{image_url($item['image'])}})"></div>
                        </td>
                        <td><h3><a href="{{post_url($aid)}}" target="_blank">{{$item['title']}}</a></h3></td>
                        <td>{{$item['cat_name']}}</td>
                        <td>{{@date('Y-m-d H:i:s', $item['created_at'])}}</td>
                        <td>{{$item['view_num']}}</td>
                        <td class="align-right"><a href="{{url('member/post/publish?aid='.$aid)}}">编辑</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div style="display: block; padding: 15px 0;">
                <div class="float-right">{!! $pagination !!}</div>
                <input type="button" class="button" value="提交" id="submit">
            </div>
        </form>
    </div>


    <script type="text/javascript">
        $(function () {
            $("#submit").on('click', function () {
                if ($(".checkmark:checked").length === 0){
                    DSXUI.error('请选择选项');
                    return false;
                }

                DSXUI.showConfirm('删除确认', '确认要删除所选信息吗?', function () {
                    $("#listForm").submit();
                });
            });
        });
    </script>
@stop
