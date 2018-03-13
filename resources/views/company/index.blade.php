@extends('layouts.company')

@section('content')
    <div class="page-header">
        <div class="console-title">
            <h2>资料设置</h2>
        </div>
    </div>
    <div class="page-content">
        <div class="form-wrapper">
            <form method="post" id="companyForm">
                <input type="hidden" name="formsubmit" value="yes">
                {{csrf_field()}}
                <table cellpadding="0" cellspacing="0" width="100%" class="formtable">
                    <tbody>
                    <tr>
                        <td width="80">企业名称</td>
                        <td width="320"><input name="company[company_name]" id="company_name" title="" type="text" class="input-text" value="{{$company['company_name']}}"></td>
                        <td class="tips">企业名称，至少两个字，不能含有特殊字符和符号</td>
                    </tr>
                    <tr>
                        <td>企业LOGO</td>
                        <td>
                            <div class="bg-cover" id="pickLogo" style="width: 100px; height: 100px; background-color: #f5f5f5; background-image: url({{image_url($company['company_logo'])}});"></div>
                            <input type="hidden" name="company[company_logo]" id="company_logo" value="{{$company['company_logo']}}">
                        </td>
                        <td class="tips">图片格式为jpg，jpeg，png，gif，大小不要超过2MB</td>
                    </tr>
                    <tr>
                        <td>营业执照号码</td>
                        <td><input name="company[company_license_no]" title="" type="text" class="input-text" value="{{$company['company_license_no']}}"></td>
                        <td class="tips">请填写营业执照号码</td>
                    </tr>
                    <tr>
                        <td>营业执照照片</td>
                        <td>
                            <div class="bg-cover" id="pickLicensePic" style="width: 100px; height: 100px; background-color: #f5f5f5;background-image: url({{image_url($company['company_license_pic'])}});"></div>
                            <input name="company[company_license_pic]" type="hidden" id="company_license_pic" value="{{$company['company_license_pic']}}">
                        </td>
                        <td class="tips">图片格式为jpg，jpeg，png，gif，大小不要超过2MB</td>
                    </tr>
                    <tr>
                        <td>所在地区</td>
                        <td colspan="2">
                            <select name="company[province]" class="select" title="" id="province" style="width: auto;"></select>
                            <select name="company[city]" class="select" title="" id="city" style="width: auto;"></select>
                            <select name="company[district]" class="select" title="" id="district" style="width: auto;"></select>
                        </td>
                    </tr>
                    <tr>
                        <td>街道地址</td>
                        <td><input name="company[street]" title="" type="text" class="input-text" value="{{$company['street']}}"></td>
                        <td class="tips">企业所在地街道地址</td>
                    </tr>
                    <tr>
                        <td>联系人</td>
                        <td><input name="company[contact]" title="" type="text" class="input-text" value="{{$company['contact']}}"></td>
                        <td class="tips">企业招聘联系人</td>
                    </tr>
                    <tr>
                        <td>联系电话</td>
                        <td><input name="company[tel]" title="" type="text" class="input-text" value="{{$company['tel']}}"></td>
                        <td class="tips">企业联系电话</td>
                    </tr>
                    <tr>
                        <td>企业介绍</td>
                        <td colspan="2">@include('common.editor', ['name' => 'content', 'content' => $content['content'], 'params'=>[]])</td>
                    </tr>
                    </tbody>
                    <tfoot>
                    <tr>
                        <td></td>
                        <td colspan="2">
                            <button type="submit" class="button" style="width: 120px;">提交</button>
                        </td>
                    </tr>
                    </tfoot>
                </table>
            </form>
        </div>
        <script type="text/javascript">
            $(function () {
                $("#pickLogo").on('click', function () {
                    DSXUI.showImagePicker(function (data) {
                        $("#pickLogo").css({'background-image':'url('+data.imageurl+')'});
                        $("#company_logo").val(data.image);
                    });
                });

                $("#pickImage").on('click', function () {
                    DSXUI.showImagePicker(function (data) {
                        $("#pickImage").css({'background-image':'url('+data.imageurl+')'});
                        $("#company_image").val(data.image);
                    });
                });

                $("#pickLicensePic").on('click', function () {
                    DSXUI.showImagePicker(function (data) {
                        $("#pickLicensePic").css({'background-image':'url('+data.imageurl+')'});
                        $("#company_license_pic").val(data.image);
                    });
                });

                var selector = new DistrictSelector({
                    province:'{{$company['province']}}',
                    city:'{{$company['city']}}',
                    county:'{{$company['district']}}',
                });

                $("#companyForm").on('submit', function () {
                    var company_name = $.trim($("#company_name").val());
                    if (!company_name) {
                        DSXUI.error('请填写企业名称');
                        return false;
                    }
                });
            });
        </script>
    </div>
@stop
