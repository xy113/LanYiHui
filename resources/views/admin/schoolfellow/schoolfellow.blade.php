@extends('layouts.admin')

@section('title', $school['name'].'校友录')

@section('content')
    <div class="console-title">
        <div class="float-right">
            <form name="search" method="get">
                <input type="hidden" name="searchType" value="0">
                <input type="text" title="" class="input-text" name="q" placeholder="关键字">
                <label><button type="submit" class="button">快速搜索</button></label>
            </form>
        </div>
        <h2>校友录->{{$school['name']}}</h2>
    </div>
    <div class="content-div">
        <form method="post" id="listForm">
            {{csrf_field()}}
            <input type="hidden" name="formsubmit" value="yes">
            <input type="hidden" name="eventType" id="J_eventType" value="">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="listtable">
                <thead>
                <tr>
                    <th width="40" class="center"><input title="全选" type="checkbox" class="checkbox checkall checkmark"></th>
                    <th width="100">姓名</th>
                    <th>用户名</th>
                    <th>毕业年限</th>
                    <th>专业</th>
                    <th>学历</th>
                    <th>邮箱</th>
                    <th>审批时间</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach($members as $item)
                <tr>
                <td class="center"><input title="" type="checkbox" class="checkbox checkmark itemCheckBox" name="items[]" value="{{$item['id']}}"></td>
                <td>{{$item->info->name}}</td>
                    <td>{{$item->username}}</td>
                <td>{{$item->pivot->graduation_at}}</td>
                    <td>{{$item->pivot->major}}</td>
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
                    <td>{{$item->email}}</td>
                    <td>{{$item->pivot->updated_at}}</td>
                    <td>操作</td>
                {{--<td>{{$item->edus()->orderBy('id', 'ASC')->first()['school']?$item->edus()->orderBy('id', 'ASC')->first()['school']:'暂无'}}</td>--}}
                {{--<td>{{$item->edus()->orderBy('id', 'ASC')->first()['major']?$item->edus()->orderBy('id', 'ASC')->first()['major']:'暂无'}}</td>--}}
                {{--<td>{{$item['work_exp']}}</td>--}}
                {{--<td>{{$item['views']}}</td>--}}
                </tr>
                @endforeach
                </tbody>
                {{$members->links()}}
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
        </form>
    </div>
    <script type="text/javascript">
    </script>
@stop
