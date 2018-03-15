@extends('layouts.company')

@section('content')
    <div class="page-header">
        <div class="console-title">
            <a href="/company/job/publish" class="button float-right">发布职位</a>
            <h2>资料设置</h2>
        </div>
    </div>
    <div class="page-content">
        <div class="content-div">
            <table class="listtable" width="100%" cellpadding="0" cellspacing="0">
                <thead>
                <tr>
                    <th width="40"><label><input type="checkbox" class="checkbox"></label></th>
                    <th>标题</th>
                    <th width="80">浏览数</th>
                    <th width="140">发布时间</th>
                    <th width="60">选项</th>
                </tr>
                </thead>
                <tbody>
                @foreach($itemlist as $item)
                    <tr>
                        <td><label><input type="checkbox" class="checkbox"></label></td>
                        <th><a href="{{job_url($item['job_id'])}}" target="_blank">{{$item['title']}}</a></th>
                        <td>{{$item['view_num']}}</td>
                        <td>{{date('Y-m-d H:i:s', $item['created_at'])}}</td>
                        <td><a href="{{action('Company\JobController@publish', ['job_id'=>$item['job_id']])}}">编辑</a></td>
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
