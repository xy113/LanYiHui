@extends('layouts.admin')

@section('title', '用户反馈')

@section('content')
    <div class="console-title">
        <h2>用户反馈</h2>
    </div>

    <div class="content-div">
        <form method="post" action="" id="listForm">
            {{csrf_field()}}
            <input type="hidden" name="formsubmit" value="yes">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="listtable">
                <thead>
                <tr>
                    <th width="40">删?</th>
                    <th>主题</th>
                    <th>内容</th>
                    <th width="80">用户</th>
                    <th width="120">时间</th>
                </tr>
                </thead>
                <tbody>
                @foreach($itemlist as $item)
                    <tr>
                        <td><input title="" type="checkbox" class="checkbox checkmark itemCheckBox" name="delete[]" value="{{$item['id']}}"></td>
                        <td>{{$item['title']}}</td>
                        <td>{{$item['message']}}</td>
                        <td>{{$item['username']}}</td>
                        <td>{{@date('Y-m-d H:i',$item['created_at'])}}</td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <td colspan="10">
                        <span class="float-right">{!! $pagination !!}</span>
                        <label><input type="checkbox" class="checkbox checkall"> 全选</label>
                        <label><button type="submit" class="btn">提交</button></label>
                        <label><button type="button" class="btn" onclick="DSXUtil.reFresh()">刷新</button></label>
                    </td>
                </tr>
                </tfoot>
            </table>
        </form>
    </div>
    <script type="text/javascript">
        $("#listForm").on('submit', function () {
            if ($(".itemCheckBox:checked").length === 0){
                DSXUI.error('请选择选项');
                return false;
            }
        });
    </script>
@stop
