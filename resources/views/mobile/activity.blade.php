@extends('layouts.mobile')

@section('title', '近期活动')

@section('content')
    <div class="content-div" id="app">
        <ul class="activity-list" v-for="item in items">
            <li class="item" v-on:click="viewItem(item.aid)" data-link="/mobile/post/detail/@{{ item.aid }}.html">
                <div class="data">
                    <h3 class="title">@{{ item.title }}</h3>
                    <div class="info">
                        <span>@{{ item.view_num }}浏览</span>
                        <span>@{{ item.comment_num }}评</span>
                    </div>
                    <span class="created_at">@{{ item.created_at }}</span>
                </div>
                <div class="image bg-cover" v-bind:style="{'background-image':'url('+item.image+')'}"></div>
            </li>
        </ul>
    </div>
    @include('mobile.tabbar', ['tab' => 'grow'])
    <script type="text/javascript">
        var vm = new Vue({
            el:'#app',
            data:{
                items:[]
            },
            methods:{
                viewItem : function (id) {
                    window.location.href = g_config.baseUrl+'/mobile/post/detail/'+id+'.html';
                }
            }
        });
        function fetchData(page) {
            if (!page) page = 1;
            $.ajax({
                url:'/mobile/post/getjson?catid=16&page='+page,
                dataType:'json',
                success:function (response) {
                    $(response.data).each(function () {
                        vm.$data.items.push(this);
                    });
                }
            });
        }
        fetchData();
    </script>
@stop
