@extends('layouts.admin')

@section('content')
    <div class="console-title">
        <div class="float-right">
            <a href="{{action('Admin\PagesController@publish', ['catid'=>$catid])}}" class="button">添加页面</a>
        </div>
        <h2>页面管理</h2>
    </div>

    <div class="tabs-container">
        <div class="tabs">
            <div class="tab @if(!$catid)on @endif"><a href="{{url('/admin/pages')}}">全部</a><span>|</span></div>
            @foreach($categorylist as $pageid=>$category)
            <div class="tab @if($catid==$pageid)on @endif"><a href="{{action('Admin\PagesController@index', ['catid'=>$pageid])}}">{{$category['title']}}</a><span>|</span></div>
            @endforeach
        </div>
    </div>

    <div class="content-div">
        <form method="post" action="" id="listForm">
            {{csrf_field()}}
            <input type="hidden" name="formsubmit" value="yes">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="listtable">
                <thead>
                <tr>
                    <th width="40">删?</th>
                    <th>标题</th>
                    <th>别名</th>
                    <th width="80">排序</th>
                    <th width="120">发布时间</th>
                    <th width="120">最后修改</th>
                    <th width="40">编辑</th>
                </tr>
                </thead>
                <tbody>
                @foreach($pagelist as $pageid=>$item)
                <tr>
                    <td><input title="" type="checkbox" class="checkbox checkmark itemCheckBox" name="delete[]" value="{{$pageid}}"></td>
                    <th><a href="{{url('/pages/detail',['pageid'=>$pageid])}}" target="_blank">{{$item['title']}}</a></th>
                    <td>{{$item['alias']}}</td>
                    <td><input title="" type="text" class="input-text w60" name="pagelist[{{$pageid}}][displayorder]" value="{{$item['displayorder']}}" /></td>
                    <td>{{@date('Y-m-d H:i',$item['created_at'])}}</td>
                    <td>{{@date('Y-m-d H:i',$item['updated_at'])}}</td>
                    <td><a href="{{action('Admin\PagesController@publish',['pageid'=>$pageid])}}">编辑</a></td>
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
@stop
