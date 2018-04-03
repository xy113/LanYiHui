@extends('layouts.mobile')

@section('title', '我的收藏')

@section('content')
    <div class="favor-tabs-wrapper">
        <div class="favor-tabs-fixed">
            <ul id="tabs">
                <li class="active" data-type="article">文章</li>
                <li data-type="job">职位</li>
                <li data-type="company">企业</li>
            </ul>
        </div>
    </div>
    <div class="favor-wrapper" id="app">
        <ul v-for="item in items">
            <li v-on:click="view(item.data_type, item.data_id)">@{{ item.title }}</li>
        </ul>
    </div>
    <script type="text/javascript">
        (function () {
            var vm = new Vue({
                el:'#app',
                data:{
                    items:[]
                },
                methods:{
                    view:function (type,id) {
                        if (type === 'article'){
                            window.redirect(g_config.baseUrl+'/mobile/post/detail/'+id+'.html');
                        }

                        if (type === 'job') {
                            window.redirect(g_config.baseUrl+'/mobile/job/detail/'+id+'.html');
                        }

                        if (type === 'company') {
                            window.redirect(g_config.baseUrl+'/mobile/company/detail/'+id+'.html');
                        }
                    }
                }
            });
            function fetchData(type){
                $.ajax({
                    dataType:'json',
                    url:'/mobile/favorite/getjson',
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
            fetchData('article');
        })();
    </script>
@stop
