@extends('layouts.member')

@section('title', '会员档案')

@section('content')
    <div class="console-title">
        <h2>会员档案</h2>
    </div>

    <div class="content-div">
        <form method="post">
            <table width="100%" cellspacing="0" cellpadding="0" class="formtable">
                <tr>
                    <td width="80">会员ID</td>
                    <td>{{$archive['id']}}</td>
                </tr>
                <tr>
                    <td>姓名</td>
                    <td>{{$archive['fullname']}}</td>
                </tr>
                <tr>
                    <td>性别</td>
                    <td>@if($archive['sex'])男@else女@endif</td>
                </tr>
                <tr>
                    <td>电话</td>
                    <td>{{$archive['phone']}}</td>
                </tr>
                <tr>
                    <td>出生日期</td>
                    <td>{{$archive['birthday']}}</td>
                </tr>
                <tr>
                    <td>就读大学</td>
                    <td>{{$archive['university']}}</td>
                </tr>
                <tr>
                    <td>入学年份</td>
                    <td>{{$archive['enrollyear']}}</td>
                </tr>
                <tr>
                    <td>籍贯</td>
                    <td>{{$archive['birthplace']}}</td>
                </tr>
                <tr>
                    <td>所在地</td>
                    <td>{{$archive['location']}}</td>
                </tr>
                <tr>
                    <td>联谊会职务</td>
                    <td>@if($archive['post']){{$archive['post']}}@else会员@endif</td>
                </tr>
                <tr>
                    <td>人气指数</td>
                    <td>{{$archive['stars']}}</td>
                </tr>
                <tr>
                    <td>认证状态</td>
                    <td>{{$verify_status[$archive['status']]}}</td>
                </tr>
            </table>
        </form>
    </div>
@stop
