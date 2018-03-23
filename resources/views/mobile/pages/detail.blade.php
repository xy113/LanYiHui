@extends('layouts.mobile')

@section('title', $page['title'])

@section('content')
    <div class="pages">
        <h1 class="title">{{$page['title']}}</h1>
        <div class="content">{!! $page['body'] !!}</div>
    </div>
@stop
