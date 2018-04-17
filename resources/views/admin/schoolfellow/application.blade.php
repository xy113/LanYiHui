@extends('layouts.admin')

@section('title', $school['name'].'申请管理')

@section('content')
    <div class="console-title">
        <div class="float-right">
            <form name="search" method="get">
                <input type="hidden" name="searchType" value="0">
                <input type="text" title="" class="input-text" name="q" placeholder="关键字">
                <label><button type="submit" class="button">快速搜索</button></label>
            </form>
        </div>
        <h2>校友录->{{$school['name']}}->申请管理</h2>
    </div>
    <div class="content-div">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="listtable">
                <thead>
                <tr>
                    <th width="40" class="center"><input title="全选" type="checkbox" class="checkbox checkall checkmark"></th>
                    <th width="100">姓名</th>
                    <th>用户名</th>
                    <th>联系电话</th>
                    <th>就读学历</th>
                    <th>专业</th>
                    <th>毕业时间</th>
                    <th>申请时间</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach($list as $item)
                <tr>
                    <td class="center"><input title="" type="checkbox" class="checkbox checkmark itemCheckBox" name="items[]" value="{{$item['id']}}"></td>
                    <td>{{$item->info->name}}</td>
                    <td>{{$item['username']}}</td>
                {{--<td>@if($item['gender'])男@else女@endif</td>--}}
                    <td>{{$item['mobile']}}</td>
                    <td>
                        @switch($item->pivot->degree)
                            @case('1')
                            小学
                            @break

                            @case('2')
                            初中
                            @break

                            @case('3')
                            高中
                            @break

                            @case('4')
                            本科
                            @break

                            @case('5')
                            硕士
                            @break

                            @case('6')
                            博士
                            @break

                            @case('7')
                            专科
                            @break
                            @default
                            其他
                        @endswitch
                    </td>
                    <td>{{$item->pivot->major}}</td>
                    <td>{{$item->pivot->graduation_at}}</td>
                    <td>{{$item->pivot->created_at}}</td>
                    <td>
                        <button onclick="deal({{$item->pivot->id}},true,'{{$item['username']}}')">通过</button>
                        <button onclick="deal({{$item->pivot->id}},false,'{{$item['username']}}')">拒绝</button>
                    </td>
                </tr>
                @endforeach
                </tbody>
                {{$list->links()}}
                <tfoot>
                <tr>
                    <td colspan="10">
                        {{--<div class="float-right">{{$pagination}}</div>--}}
                        <label><input type="checkbox" class="checkbox checkall checkmark"> {{trans('common.selectall')}}</label>
                        <label><button type="button" class="btn btn-action" data-action="delete">删除</button></label>
                        <label><button type="button" class="btn" onclick="DSXUtil.reFresh()">刷新</button></label>
                        {{--{{$itemlist->currentPage()}}--}}
                    </td>
                </tr>
                </tfoot>
            </table>
    </div>
    <script type="text/javascript">
        function deal(id,opt,name) {
            var text = opt?'通过':'拒绝';
            var opp = opt?'1':'0';
            if(confirm('是否'+text+''+name+'的申请？')){
                console.log(text);
                $.ajax({
                    type:'POST',
                    url:'{{url('/admin/schoolfellow/application')}}',
                    dataType: 'json',
                    data:{
                        item:{
                            id:id,
                            pass:opp,
                        },
                        formsubmit:'yes'
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    success:function (res) {
                        if (res.errcode == 0){
                            alert('处理成功！');
                            DSXUtil.reFresh();
                        }
                    },
                    error:function (err) {

                    }
                })
            }
        }

        function degree(d) {
            var res = '其他';
            switch (d){
                case '1':
                    res = '小学';
                    break;
                case '2':
                    res = '初中';
                    break;
                case '3':
                    res = '高中';
                    break;
                case '4':
                    res = '本科';
                    break;
                case '5':
                    res = '硕士';
                    break;
                case '6':
                    res = '博士';
                    break;
                case '7':
                    res = '专科';
                    break;
                default:
                    break;
            }
        }
    </script>
@stop
