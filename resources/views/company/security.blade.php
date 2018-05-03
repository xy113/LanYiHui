@extends('layouts.company')

@section('content')
    <div class="page-header">
        <div class="console-title">
            <h2>安全设置</h2>
        </div>
    </div>
    <div class="page-content">
        <div class="form-wrapper">
            <form method="post" id="securityForm">
                <input type="hidden" name="formsubmit" value="yes">
                {{csrf_field()}}
                <table cellpadding="0" cellspacing="0" width="100%" class="formtable">
                    <tbody>
                    <tr>
                        <td width="80">请输入旧密码</td>
                        <td width="320"><input name="security[old_pwd]" id="old_pwd" title="" type="password" class="input-text pss" value=""></td>
                        <td class="tips">6-20个字母、数字、下划线</td>
                    </tr>
                    <tr>
                        <td width="80">请输入新密码</td>
                        <td width="320"><input name="security[new_pwd]" id="new_pwd" title="" type="password" class="input-text pss" value=""></td>
                        <td class="tips">6-20个字母、数字、下划线</td>
                    </tr>
                    <tr>
                        <td width="80">请确认新密码</td>
                        <td width="320"><input name="security[insure]" id="insure" title="" type="password" class="input-text" value=""></td>
                        <td class="tips">6-20个字母、数字、下划线</td>
                    </tr>
                    </tbody>
                    <tfoot>
                    <tr>
                        <td></td>
                        <td colspan="2">
                            <button type="button" id="btn" class="button" style="width: 120px;">提交</button>
                        </td>
                    </tr>
                    </tfoot>
                </table>
            </form>
        </div>
        <script type="text/javascript">
            var reg = [1,1]
            function regPwd(s) {
                var patrn=/^(\w){6,20}$/;
                if (!patrn.exec(s)) {
                    return false
                }
                return true
            }
            $('.pss').on('change',function () {
                var t = this;
                if(regPwd($(t).val())){
                    $(t).parent('td').siblings('.tips').removeClass('error').addClass('success').html('格式正确！');
                    reg[0] = 1;
                }else {
                    $(t).parent('td').siblings('.tips').removeClass('success').addClass('error').html('密码格式不正确！');
                    reg[0] = 0;
                }
            })
            $('#insure').on('change',function () {
                var t = this;
                if($(t).val()==$('#new_pwd').val()){
                    $(t).parent('td').siblings('.tips').removeClass('error').addClass('success').html('密码一致！');
                    reg[1] = 1;
                }else {
                    $(t).parent('td').siblings('.tips').removeClass('success').addClass('error').html('两次输入密码不一致！');
                    reg[1] = 0;
                }
            })
            $('#btn').on('click',function () {
                if (!reg[0]){
                    DSXUI.error('请输入正确格式的密码！');
                    return false;
                }
                if (!reg[1]){
                    DSXUI.error('两次输入新密码不一致！');
                    return false;
                }
                $("#securityForm").ajaxSubmit({
                    dataType:'json',
                    success:function (response) {
                        if (response.errcode === 0){
                            DSXUI.success('操作成功！')
                        }else {
                            DSXUI.error(response.msg);
                        }
                    }
                });
            })
        </script>
    </div>
@stop
