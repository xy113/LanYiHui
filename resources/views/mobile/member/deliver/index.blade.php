@extends('layouts.mobile')

@section('title', '我的投递')

@section('content')
    <div class="favor-tabs-wrapper">
        <div class="favor-tabs-fixed">
            <ul id="tabs">
                <li class="active" data-type="all">全部</li>

                <li data-type="2">待沟通</li>
                <li data-type="-1">不合适</li>
            </ul>
        </div>
    </div>
    <div class="favor-wrapper" id="app">
        <ul>
            <li class="deliver" v-for="item in items" v-on:click="view(item.id)">
                <img :src="item.company.company_logo">
                <div>
                    <div>@{{ item.job.title }}</div>
                    <div>@{{ item.job.place }} · @{{ item.company.company_name }}</div>
                    <div class="time">投递时间：@{{ toTime(item.created_at) }}</div>

                    <span v-if="item.status==-1" class="error">不合适</span>
                    <span v-if="item.status==0" class="success">待查看</span>
                    <span v-if="item.status==1" class="info">已查看</span>
                    <span v-if="item.status==2" class="success">待沟通</span>
                    <span v-if="item.status==3" class="success">已录取</span>
                </div>

            </li>
            <div v-if="items.length==0">
                <div class="icon-no-data"></div>
                <p class="icon-no-data-p">暂无数据</p>
            </div>
        </ul>
    </div>
    @include('mobile.tabbar', ['tab' => 'mine'])
    <script type="text/javascript">
        (function () {
            var vm = new Vue({
                el:'#app',
                data:{
                    items:[]
                },
                methods:{
                    view:function (id) {
                        window.redirect(g_config.baseUrl+'/mobile/resume/deliver/detail?id='+id);
                    },
                    toTime:function (t) {
                        var time = new Date(t*1000);
                        var str = time.getFullYear()+'-'+(time.getMonth()+1)+'-'+time.getDate()+' '+(time.getHours()>9?time.getHours():('0'+time.getHours()))+':'+(time.getMinutes()>9?time.getMinutes():('0'+time.getMinutes()))+':'+(time.getSeconds()>9?time.getSeconds():('0'+time.getSeconds()));
                        return str;
                    }
                }
            });
            function fetchData(type){
                $.ajax({
                    dataType:'json',
                    url:'/mobile/resume/getdeliver',
                    data:{type:type},
                    success:function (response) {
                        vm.$data.items = response.data;
                    }
                });
            }
            $("#tabs>li").on('tap', function () {
                $(this).addClass('active').siblings().removeClass();
                fetchData($(this).attr('data-type'));
            });
            fetchData('all');
        })();
    </script>
@stop
