@extends('admin.default')

@section('content')
    <div class="console-title">
        <h2>系统设置->微信设置</h2>
    </div>
    <div class="content-div">
        <form method="post" id="settingForm" action="/admin/settings/save">
            {{csrf_field()}}
            <table class="formtable" border="0" cellpadding="0" cellspacing="0" width="100%">
                <tbody id="weixin">
                <tr>
                    <td class="cell-name" width="140">公众号APPID:</td>
                    <td width="320"><input title="" name="settings[wx.appid]" value="{{$settings['wx.appid'] or ''}}" class="input-text w300" type="text"></td>
                    <td>微信公众号appID</td>
                </tr>
                <tr>
                    <td class="cell-name">公众号APPSECRET:</td>
                    <td><input title="" name="settings[wx.appsecret]" value="{{$settings['wx.appsecret'] or ''}}" class="input-text w300" type="text"></td>
                    <td>微信公众号appSecret</td>
                </tr>
                <tr>
                    <td class="cell-name">微信支付商户号:</td>
                    <td><input title="" name="settings[wx.mch_id]" value="{{$settings['wx.mch_id'] or ''}}" class="input-text w300" type="text"></td>
                    <td>微信支付商户ID</td>
                </tr>
                <tr>
                    <td class="cell-name">微信支付API安全秘钥:</td>
                    <td><input title="" name="settings[wx.mch_key]" value="{{$settings['wx.mch_key'] or ''}}" class="input-text w300" type="text"></td>
                    <td>微信支付API安全秘钥，不超过32位</td>
                </tr>
                <tr>
                    <td class="cell-name">被关注自动回复:</td>
                    <td>
                        <label><input type="radio" name="settings[wx.subscribe_msgtype]" value="1"@if (isset($settings['wx.subscribe_msgtype']) && $settings['wx.subscribe_msgtype']==1) checked="checked"@endif> 文字消息</label>
                        <label><input type="radio" name="settings[wx.subscribe_msgtype]" value="2"@if (isset($settings['wx.subscribe_msgtype']) && $settings['wx.subscribe_msgtype']==2) checked="checked"@endif> 图文消息</label>
                    </td>
                    <td>自动回复</td>
                </tr>
                <tr>
                    <td class="cell-name">被关注自动回复内容:</td>
                    <td><textarea title="" name="settings[wx.subscribe_message]" class="textarea w300">{{$settings['wx.subscribe_message'] or ''}}</textarea></td>
                    <td>公众号被关注时自动回复的内容，若为图文消息请填写素材的media_id</td>
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
