@extends('admin.default')

@section('content')
    <div class="console-title">
        <div class="float-right">
            <form method="get" id="searchForm" action="">
                <input type="hidden" name="province" value="{{$province}}" id="J_province">
                <input type="hidden" name="city" value="{{$city}}" id="J_city">
                <input type="hidden" name="district" value="{{$district}}" id="J_district">
                <select title="" id="province" class="select" style="width: auto;">
                    <option>--省份--</option>
                    @foreach($provincelist as $id=>$p)
                    <option value="{{$id}}"@if($id==$province) selected="selected"@endif>{{$p['name']}}</option>
                    @endforeach
                </select>
                <select title="" id="city" class="select" style="width: auto;">
                    <option value="0">--城市--</option>
                    @foreach($citylist as $id=>$c)
                        <option value="{{$id}}"@if($id==$city) selected="selected"@endif>{{$c['name']}}</option>
                    @endforeach
                </select>
                <select title="" id="district" class="select" style="width: auto;">
                    <option value="0">--州县--</option>
                    @foreach($districtlist as $id=>$d)
                        <option value="{{$id}}"@if($id==$district) selected="selected"@endif>{{$d['name']}}</option>
                    @endforeach
                </select>
            </form>
        </div>
        <h2>区域管理</h2>
    </div>
    <div class="content-div">
        <form method="post" id="listForm" action="/admin/district/save">
            {{csrf_field()}}
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="listtable">
                <thead>
                <tr>
                    <th width="40" class="center">删?</th>
                    <th>名称</th>
                    <th>拼音</th>
                    <th>首字母</th>
                    <th>区域代码</th>
                    <th>经度</th>
                    <th>纬度</th>
                    <th>排序</th>
                </tr>
                </thead>
                <tbody>
                @foreach($itemlist as $id=>$item)
                <tr>
                    <td><input title="" type="checkbox" class="checkbox checkmark" name="delete[]" value="{{$id}}" /></td>
                    <td><input title="" type="text" class="input-text" name="itemlist[{{$id}}][name]" value="{{$item['name']}}"></td>
                    <td><input title="" type="text" class="input-text" name="itemlist[{{$id}}][pinyin]" value="{{$item['pinyin']}}"></td>
                    <td><input title="" type="text" class="input-text" name="itemlist[{{$id}}][letter]" value="{{$item['letter']}}" style="width: 40px;"></td>
                    <td><input title="" type="text" class="input-text" name="itemlist[{{$id}}][zone_code]" value="{{$item['zone_code']}}" style="width: 100px;"></td>
                    <td><input title="" type="text" class="input-text" name="itemlist[{{$id}}][lng]" value="{{$item['lng']}}" style="width: 100px;"></td>
                    <td><input title="" type="text" class="input-text" name="itemlist[{{$id}}][lat]" value="{{$item['lat']}}" style="width: 100px;"></td>
                    <td><input title="" type="text" class="input-text" name="itemlist[{{$id}}][displayorder]" value="{{$item['displayorder']}}" style="width: 60px;"></td>
                </tr>
                @endforeach
                </tbody>
                <tbody id="newDistrict"></tbody>
                <tfoot>
                <tr>
                    <td colspan="10">
                        <label><input type="checkbox" class="checkbox checkall" /> 全选</label>
                        <a href="javascript:;" id="addnew"><i class="iconfont icon-roundadd"></i>添加区域</a>
                    </td>
                </tr>
                <tr>
                    <td colspan="10">
                        <input type="submit" class="button" value="提交" />
                        <input type="button" class="button button-cancel" value="刷新" data-action="refresh" />
                    </td>
                </tr>
                </tfoot>
            </table>
        </form>
    </div>

    <script type="text/template" id="tplDistrict">
        <tr>
            <td></td>
            <td><input title="" type="text" class="input-text" name="itemlist[#keynum#][name]" value=""></td>
            <td><input title="" type="text" class="input-text" name="itemlist[#keynum#][pinyin]" value=""></td>
            <td><input title="" type="text" class="input-text" name="itemlist[#keynum#][letter]" value="" style="width: 40px;"></td>
            <td><input title="" type="text" class="input-text" name="itemlist[#keynum#][zone_code]" value="" style="width: 100px;"></td>
            <td><input title="" type="text" class="input-text" name="itemlist[#keynum#][lng]" value="" style="width: 100px;"></td>
            <td><input title="" type="text" class="input-text" name="itemlist[#keynum#][lat]" value="" style="width: 100px;"></td>
            <td><input title="" type="text" class="input-text" name="itemlist[#keynum#][displayorder]" value="" style="width: 60px;"></td>
        </tr>
    </script>
    <script type="text/javascript">
        var keynum = 0;
        $("#addnew").click(function(){
            var html = $("#tplDistrict").html().replace(/#keynum#/g,keynum);
            $("#newDistrict").append(html);
            keynum--;
        });
        $(function () {
            $("#province").on('change', function () {
                $("#J_province").val($(this).val());
                $("#J_city").val(0);
                $("#J_district").val(0);
                $("#searchForm").submit();
            });
            $("#city").on('change', function () {
                $("#J_city").val($(this).val());
                $("#J_district").val(0);
                $("#searchForm").submit();
            });
            $("#district").on('change', function () {
                $("#J_district").val($(this).val());
                $("#searchForm").submit();
            });
        });
    </script>
@stop
