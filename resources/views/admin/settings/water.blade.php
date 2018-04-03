@extends('layouts.admin')

@section('content')
    <div class="console-title">
        <h2>系统设置->水印设置</h2>
    </div>
    <div class="content-div">
        <form method="post" id="settingForm" action="/admin/settings/save">
            {{csrf_field()}}
            <table class="formtable" border="0" cellpadding="0" cellspacing="0" width="100%">
                <tbody id="water">
                <tr>
                    <td class="cell-name" width="90">开启图片水印:</td>
                    <td width="320">
                        <label><input name="settings[water_mark]" value="1" type="radio" class="radio"@if ($settings['water_mark']) checked="checked"@endif> 是</label>
                        <label><input name="settings[water_mark]" value="0" type="radio" class="radio"@if (!$settings['water_mark']) checked="checked"@endif> 否</label>
                    </td>
                    <td>是否启用图片水印</td>
                </tr>
                <tr>
                    <td class="cell-name">水印类型:</td>
                    <td>
                        <label><input name="settings[water_type]" type="radio" class="radio" value="1"@if($settings['water_type']) checked="checked"@endif> 图片水印</label>
                        <label><input name="settings[water_type]" type="radio" class="radio" value="0"@if(!$settings['water_type']) checked="checked"@endif> 文字水印</label>
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td class="cell-name">水印位置:</td>
                    <td>
                        <select title="" class="select w200" name="settings[water_pos]">
                            <option value="1"@if($settings['water_pos'] == 1) selected="selected"@endif>左上角</option>
                            <option value="2"@if($settings['water_pos'] == 2) selected="selected"@endif>上居中</option>
                            <option value="3"@if($settings['water_pos'] == 3) selected="selected"@endif>右上角</option>
                            <option value="4"@if($settings['water_pos'] == 4) selected="selected"@endif>左居中</option>
                            <option value="5"@if($settings['water_pos'] == 5) selected="selected"@endif>居中</option>
                            <option value="6"@if($settings['water_pos'] == 6) selected="selected"@endif>右居中</option>
                            <option value="7"@if($settings['water_pos'] == 7) selected="selected"@endif>左下角</option>
                            <option value="8"@if($settings['water_pos'] == 8) selected="selected"@endif>下居中</option>
                            <option value="9"@if($settings['water_pos'] == 9) selected="selected"@endif>右下角</option>
                        </select>
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td class="cell-name">水印透明度:</td>
                    <td><input title="" name="settings[water_alpha]" value="{{$settings['water_alpha'] or ''}}" class="input-text w300" type="text"></td>
                    <td>水印透明度,100为不透明</td>
                </tr>
                <tr>
                    <td class="cell-name">水印文字:</td>
                    <td><textarea title="" name="settings[water_text]" class="textarea w300">{{$settings['water_text'] or ''}}</textarea></td>
                    <td>水印文字，仅当设定为文字水印时有效</td>
                </tr>
                <tr>
                    <td class="cell-name">水印颜色:</td>
                    <td><input title="" name="settings[water_color]" value="{{$settings['water_color'] or ''}}" class="input-text w300" type="text"></td>
                    <td>水印文字颜色，仅当设定为文字水印时有效</td>
                </tr>
                <tr>
                    <td class="cell-name">字体大小:</td>
                    <td><input title="" name="settings[water_size]" value="{{$settings['water_size'] or ''}}" class="input-text w300" type="text"></td>
                    <td>水印文字字体大小，仅当设定为文字水印时有效</td>
                </tr>
                <tr>
                    <td class="cell-name">位置偏移量:</td>
                    <td><input title="" name="settings[water_offset]" value="{{$settings['water_offset'] or ''}}" class="input-text w300" type="text"></td>
                    <td>水印位置偏移量，单位像素</td>
                </tr>
                <tr>
                    <td class="cell-name">旋转角度:</td>
                    <td><input title="" name="settings[water_angle]" value="{{$settings['water_angle'] or ''}}" class="input-text w300" type="text"></td>
                    <td>水印文字旋转角度</td>
                </tr>
                </tbody>
                <tfoot>
                <tr>
                    <td></td>
                    <td colspan="2"><input class="button submit" value="更新配置" type="submit"></td>
                </tr>
                </tfoot>
            </table>
        </form>
    </div>
@stop
