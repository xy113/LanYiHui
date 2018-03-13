@extends('layouts.admin')

@section('content')
    <div class="console-title">
        <h2>快递管理</h2>
    </div>
    <div class="content-div">
        <form method="post" autocomplete="off" action="/admin/express/save">
            {{csrf_field()}}
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="listtable">
                <thead>
                <tr>
                    <th width="50" class="center">删?</th>
                    <th width="220">快递名称</th>
                    <th width="120">公司代码</th>
                    <th>单号规则</th>
                </tr>
                </thead>
                <tbody id="express_list">
                @foreach($itemlist as $id=>$item)
                <tr>
                    <td><input title="" type="checkbox" class="checkbox checkmark" name="delete[]" value="{{$id}}"></td>
                    <td><input title="" type="text" class="input-text" name="itemlist[{{$id}}][name]" value="{{$item['name']}}"></td>
                    <td><input title="" type="text" class="input-text w100" name="itemlist[{{$id}}][code]" value="{{$item['code']}}"></td>
                    <td><input title="" type="text" class="input-text w300" name="itemlist[{{$id}}][regular]" value="{{$item['regular']}}"></td>
                </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <td colspan="10">
                        <label><input type="checkbox" class="checkbox checkall"> {{trans('common.selectall')}}</label>
                        <label><input type="radio" class="radio" name="option" value="delete" checked> 删除</label>
                        <a id="addnew" style="margin-left:20px;"><i class="iconfont icon-roundaddfill"></i>添加快递</a>
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
        var express_id = 0;
        $("#addnew").on('click', function () {
            $("#express_list").append('<tr>' +
                '                <td></td>' +
                '                <td><input type="text" class="input-text" name="itemlist['+express_id+'][name]"></td>\n' +
                '                <td><input type="text" class="input-text w100" name="itemlist['+express_id+'][code]"></td>\n' +
                '                <td><input type="text" class="input-text w300" name="itemlist['+express_id+'][regular]"></td>\n' +
                '            </tr>');
            express_id--;
        });
    </script>
@stop
