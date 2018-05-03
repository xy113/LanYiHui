@extends('layouts.company')

@section('content')
    <div class="page-header">
        <div class="console-title">
            <h2>简历管理</h2>
        </div>
    </div>
    <div class="page-content">
        <div class="content-div">
            <table class="listtable" width="100%" cellpadding="0" cellspacing="0">
                <thead>
                <tr>
                    <th width="40"><label><input type="checkbox" class="checkbox"></label></th>
                    <th>简历名称</th>
                    <th>投递岗位</th>
                    <th width="80">状态</th>
                    <th width="140">提交时间</th>
                    <th width="60">选项</th>
                </tr>
                </thead>
                <tbody>
                @foreach($itemlist as $item)
                    <tr>
                        <td><label><input type="checkbox" class="checkbox"></label></td>
                        <th><a href="{{url('/company/resume/detail').'?id='.$item['id']}}">{{$item->resume->title}}</a></th>
                        <td>{{$item->job->title}}</td>
                        <td>@switch($item['status'])
                            @case('-1')<font class="error">已拒绝</font>@break
                                @case('0')<font class="success">未查看</font>@break
                                @case('1')<font class="info">已查看</font>@break
                                @case('2')<font class="primary">待沟通</font>@break
                            @endswitch</td>
                        <td>{{date('Y-m-d H:i:s', $item['created_at'])}}</td>
                        <td><a href="{{url('/company/resume/detail').'?id='.$item['id']}}">查看</a></td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <td colspan="10">
                        <div class="float-right">{{$pagination}}</div>
                        <label><input type="checkbox" class="checkbox checkall"> 全选</label>
                        <label><button class="btn" type="submit">提交</button></label>
                    </td>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
@stop
