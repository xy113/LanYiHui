@extends('layouts.member')

@section('content')
    <div class="console-title">
        <div class="float-right">
            <form method="get">
                <input type="text" name="q" value="{{$q}}" class="input-text" placeholder="文章标题">
                <input type="submit" class="button" value="搜索">
            </form>
        </div>
        <ul class="tab">
            <li class="on"><a>文章</a></li>
        </ul>
    </div>

    <div class="content-div">
        <table cellpadding="0" cellspacing="0" width="100%" border="0" class="listtable">
            <thead>
            <tr>
                <th width="60">图片</th>
                <th>文章标题</th>
                <th width="200">收藏时间</th>
                <th width="85" class="align-right">选项</th>
            </tr>
            </thead>
            <tbody>
            @foreach($itemlist as $id=>$item)
            <tr id="favorite-item-{{$id}}">
                <td><div class="pic"><a href="{{post_url($item['data_id'])}}" target="_blank"><img src="{{image_url($item['image'])}}"></a></div></td>
                <td>
                    <h3 class="title"><a href="{{post_url($item['data_id'])}}" target="_blank">{{$item['title']}}</a></h3>
                </td>
                <td>{{@date('Y-m-d H:i:s', $item['created_at'])}}</td>
                <td class="align-right"><a rel="a-delete" data-id="{{$id}}">取消收藏</a></td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="pagination">{!! $pagination !!}</div>
    <script type="text/javascript">
        $(function () {
            $("a[rel=a-delete]").confirm({
                text:'确定要取消收藏吗?',
                onConfirm:function(view,o){
                    var id = $(o).attr('data-id');
                    var spinner = null;
                    $.ajax({
                        url:'/member/collection/delete',
                        data:{id:id},
                        dataType:"json",
                        beforeSend:function () {
                            spinner = DSXUI.showSpinner();
                        },
                        success: function(response){
                            setTimeout(function () {
                                spinner.close();
                                $("#favorite-item-"+id).remove();
                            }, 500);
                        }
                    });
                }
            });
        });
    </script>
@stop
