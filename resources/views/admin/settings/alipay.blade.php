@extends('layouts.admin')

@section('content')
    <div class="console-title">
        <h2>系统设置->支付宝设置</h2>
    </div>
    <div class="content-div">
        <form method="post" id="settingForm" action="{U:('c=setting&a=save')}">
            <input type="hidden" name="formsubmit" value="yes">
            <input type="hidden" name="formhash" value="{FORMHASH}">
            <table class="formtable" border="0" cellpadding="0" cellspacing="0" width="100%">
                <tbody id="weixin">
                <tr>
                    <td class="cell-name" width="110">应用ID:</td>
                    <td width="320"><input name="settingnew[alipay_appid]" class="input-text w300" value="{$setting[alipay_appid]}" type="text"></td>
                    <td>支付宝注册的应用ID</td>
                </tr>
                <tr>
                    <td class="cell-name">合作身份者ID:</td>
                    <td><input name="settingnew[alipay_partner]" class="input-text w300" value="{$setting[alipay_partner]}" type="text"></td>
                    <td>合作身份者ID，签约账号，以2088开头由16位纯数字组成的字符串</td>
                </tr>
                <tr>
                    <td class="cell-name">收款支付宝账号:</td>
                    <td><input name="settingnew[alipay_seller_id]" class="input-text w300" value="{$setting[alipay_seller_id]}" type="text"></td>
                    <td>收款支付宝账号，以2088开头由16位纯数字组成的字符串，一般情况下收款账号就是签约账号</td>
                </tr>
                <tr>
                    <td class="cell-name">商户应用私钥:</td>
                    <td><textarea class="textarea" name="settingnew[alipay_private_key]" style="height: 160px;">{$setting[alipay_private_key]}</textarea></td>
                    <td>商户的私钥,此处填写原始私钥去头去尾</td>
                </tr>
                <tr>
                    <td class="cell-name">支付宝公钥:</td>
                    <td><textarea class="textarea" name="settingnew[alipay_public_key]" style="height: 160px;">{$setting[alipay_public_key]}</textarea></td>
                    <td>支付宝的公钥，查看地址：https://b.alipay.com/order/pidAndKey.htm</td>
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
