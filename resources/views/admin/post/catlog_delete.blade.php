@extends('admin.default')

@section('content')
    <div class="console-title">
        <a href="{{url('/admin/postcatlog')}}" class="button float-right">返回列表</a>
        <h2>文章管理 > 删除分类</h2>
    </div>
    <div class="content-div">
        <form method="post" id="J_deleteForm" autocomplete="off">
            {{csrf_field()}}
            <input type="hidden" name="formsubmit" value="yes">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="formtable">
                <tbody>
                <tr>
                    <td width="80">删除分类</td>
                    <td width="320">{{$catlog['name']}}</td>
                    <td class="tips"></td>
                </tr>
                <tr>
                    <td>删除子分类及文章</td>
                    <td>
                        <label><input type="radio" class="radio" name="deleteChilds" value="1"> 是 </label>
                        <label><input type="radio" class="radio" name="deleteChilds" value="0" checked> 否</label>
                    </td>
                    <td class="tips">选择是否删除子分类</td>
                </tr>
                <tr>
                    <td>移入分类</td>
                    <td>
                        <select name="moveto" id="moveto" class="w300" title="" size="10" style="height: 200px;">
                            @if(isset($catloglist[0]))
                                @foreach($catloglist[0] as $catid1=>$cat1)
                                    <option value="{{$catid1}}"@if($catid1==$catid) disabled="disabled"@endif>{{$cat1['name']}}</option>
                                    @if (isset($catloglist[$catid1]))
                                        @foreach($catloglist[$catid1] as $catid2=>$cat2)
                                            <option value="{{$catid2}}"@if($catid2==$catid) disabled="disabled"@endif>|--{{$cat2['name']}}</option>
                                            @if (isset($catloglist[$catid2]))
                                                @foreach($catloglist[$catid2] as $catid3=>$cat3)
                                                    <option value="{{$catid3}}"@if($catid3==$catid) disabled="disabled"@endif>|--|--{{$cat3['name']}}</option>
                                                @endforeach
                                            @endif
                                        @endforeach
                                    @endif
                                @endforeach
                            @endif
                        </select>
                    </td>
                    <td class="tips">删除后将分类下的文章移动到此分类</td>
                </tr>
                </tbody>
                <tfoot>
                <tr>
                    <td></td>
                    <td colspan="5">
                        <label><input type="submit" class="button button-long" value="确认删除"></label>
                    </td>
                </tr>
                </tfoot>
            </table>
        </form>
    </div>
    <script type="text/javascript">
        $("#J_deleteForm").on('submit', function () {
            if ($("[name=deleteChilds]:checked").val() === '0'){
                if (!$("#moveto").val()){
                    DSXUI.error('请选择文章移入分类');
                    return false;
                }
            }
        });
    </script>
@stop
