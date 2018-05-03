@extends('layouts.company')

@section('content')
    <style type="text/css">
        .page-content.err-page{
            text-align: center;
            padding: 5rem 2rem;
            line-height: 3rem;
        }
    </style>
    <div class="page-content err-page">
        <h1 class="error">企业未认证</h1>
        <h2 class="primary">审核中，请耐心等待</h2>
        <p class="info">企业需要认证后才能发布招聘信息，升级为联谊会合作伙伴发布信息免审核。</p>
        <p><span id="time">5</span>秒后将自动跳转到认证页面</p>
        <a href="{{url('/company')}}">前往认证</a>
    </div>
    <script type="text/javascript">
        var t = 5;
        setInterval(function () {
            if (t>0){
                t--;
                $('#time').html(t);
            }
        },1000);
            setTimeout(function () {
                window.location='{{url('/company')}}'
            },5000)
    </script>
@stop
