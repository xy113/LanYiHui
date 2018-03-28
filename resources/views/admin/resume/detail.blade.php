@extends('layouts.admin')

@section('title', $resume['title'])

<style type="text/css">
    .resume-title{
        text-align: center;
        display: block;
        margin-top: 30px 0 20px;
        font-size: 18px;
    }
    .resume-table{
        width: 842px;
        background-color: #aaa;
        margin: 0 auto;
    }
    .resume-table td{
        padding: 10px;
        background-color: #fff;
    }
    .print-div{
        display: block;
        margin: 20px 0;
        text-align: center;
    }
</style>

@section('content')
    <h3 class="resume-title">{{$resume['name']}}的简历</h3>
    <table width="842" class="resume-table" cellspacing="1" cellpadding="0">
        <tr>
            <td width="80">姓名</td>
            <td>{{$resume['name']}}</td>
        </tr>
        <tr>
            <td>性别</td>
            <td>@if($resume['gender'])男@else女@endif</td>
        </tr>
        <tr>
            <td>年龄</td>
            <td>{{$resume['age']}}</td>
        </tr>
        <tr>
            <td>电话</td>
            <td>{{$resume['phone']}}</td>
        </tr>
        <tr>
            <td>邮箱</td>
            <td>{{$resume['email']}}</td>
        </tr>
        <tr>
            <td>毕业学校</td>
            <td>{{$resume['university']}}</td>
        </tr>
        <tr>
            <td>毕业年份</td>
            <td>{{$resume['graduation_year']}}</td>
        </tr>
        <tr>
            <td>最高学历</td>
            <td>{{$resume['education']}}</td>
        </tr>
        <tr>
            <td>所选专业</td>
            <td>{{$resume['major']}}</td>
        </tr>
        <tr>
            <td>工作经验</td>
            <td>{{$resume['work_exp']}}年</td>
        </tr>
        <tr>
            <td>就职经历</td>
            <td>{{$resume['work_history']}}</td>
        </tr>
        <tr>
            <td>个人介绍</td>
            <td>{{$resume['introduction']}}</td>
        </tr>
    </table>
    <div class="print-div">
        <a onclick="window.print()">打印简历</a>
    </div>
@stop
