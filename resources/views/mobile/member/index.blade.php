@extends('layouts.mobile')

@section('title', '个人中心')

@section('content')

    @include('mobile.tabbar', ['tab' => 'mine'])
@stop
