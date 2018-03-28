@extends('layouts.admin')

@section('title', '分类管理')

@section('content')
    <div class="console-title">
        <a href="{{url('/admin/recruit')}}" class="button float-right">返回列表</a>
        <h2>分类管理</h2>
    </div>
    <div class="content-div">
        <form method="post" autocomplete="off">
            {{csrf_field()}}
            <input type="hidden" name="formsubmit" value="yes">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="listtable">
                <thead>
                <tr>
                    <th width="50" class="center">删?</th>
                    <th width="50">ID</th>
                    <th>分类名称</th>
                </tr>
                </thead>
                <tbody id="express_list">
                @foreach($itemlist as $item)
                    <tr>
                        <td><input title="" type="checkbox" class="checkbox checkmark" name="delete[]" value="{{$item['catid']}}"></td>
                        <td>{{$item['catid']}}</td>
                        <td><input title="" type="text" class="input-text" name="itemlist[{{$item['catid']}}][name]" value="{{$item['name']}}"></td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <td colspan="10">
                        <label><input type="checkbox" class="checkbox checkall"> {{trans('common.selectall')}}</label>
                        <label><input type="radio" class="radio" name="option" value="delete" checked> 删除</label>
                        <a id="addnew" style="margin-left:20px;"><i class="iconfont icon-roundaddfill"></i>添加分类</a>
                    </td>
                </tr>
                <tr>
                    <td colspan="10">
                        <input type="submit" class="button" value="{{trans('common.submit')}}">
                        <input type="button" class="button button-cancel" value="{{trans('common.refresh')}}" onclick="DSXUtil.reFresh()">
                    </td>
                </tr>
                </tfoot>
            </table>
        </form>
    </div>
    <script type="text/javascript">
        var id = 0;
        $("#addnew").on('click', function () {
            $("#express_list").append('<tr>' +
                '                <td></td>' +
                '                <td><input type="text" class="input-text" name="itemlist['+id+'][name]"></td>\n' +
                '            </tr>');
            id--;
        });
    </script>
@stop
