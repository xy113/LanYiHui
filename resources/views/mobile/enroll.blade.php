@extends('layouts.mobile')

@section('title', '加入联谊会')

@section('scripts')
    <script src="{{asset('DatePicker/WdatePicker.js')}}" type="text/javascript"></script>
@stop

@section('content')
    <div class="enroll">
        <div class="form-wrapper">
            <form method="post" autocomplete="off" id="Form">
                {{csrf_field()}}
                <input type="hidden" name="formsubmit" value="yes">
                <div class="form-group">
                    <div class="label">真实姓名</div>
                    <div class="content">
                        <input type="text" class="input-text" title="" name="fullname" id="fullname" placeholder="真实姓名">
                    </div>
                </div>
                <div class="form-group">
                    <div class="label">手机号</div>
                    <div class="content">
                        <input type="text" class="input-text" title="" name="phone" id="phone" placeholder="常用手机号码">
                    </div>
                </div>
                <div class="form-group">
                    <div class="label">性别</div>
                    <div class="content" style="padding-top: 10px;">
                        <label><input type="radio" class="radio" name="sex" value="0" checked="checked"> 女</label>
                        <label><input type="radio" class="radio" name="sex" value="1"> 男</label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="label">出生日期</div>
                    <div class="content">
                        <input type="text" class="input-text" title="" name="birthday" id="birthday" placeholder="选择日期" onclick="WdatePicker()" readonly>
                    </div>
                </div>

                <div class="form-group">
                    <div class="label">就读大学</div>
                    <div class="content">
                        <input type="text" class="input-text" title="" name="university" id="university" placeholder="填写就读大学名称">
                    </div>
                </div>

                <div class="form-group">
                    <div class="label">入学年份</div>
                    <div class="content">
                        <input type="text" class="input-text" title="" name="enrollyear" id="enrollyear" placeholder="选择入学年份" onclick="WdatePicker({dateFmt:'yyyy'})" readonly>
                    </div>
                </div>

                <div class="form-group">
                    <div class="label">籍贯</div>
                    <div class="content">
                        <input type="text" class="input-text" title="" name="birthplace" id="birthplace" placeholder="填写家乡所在地">
                    </div>
                </div>

                <div class="form-group">
                    <div class="label">所在地</div>
                    <div class="content">
                        <input type="text" class="input-text" title="" name="location" id="location" placeholder="填写当前所在地">
                    </div>
                </div>
                <div class="form-group">
                    <div class="label"></div>
                    <div class="content">
                        <input type="button" class="button" title="" id="submitBtn" value="提交申请">
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script type="text/javascript">
        $("#submitBtn").on('click', function () {
            var fullname = $.trim($("#fullname").val());
            if (!DSXValidate.IsChineseName(fullname)) {
                DSXUI.error('姓名输入有误，请重新输入');
                return false;
            }

            var phone = $.trim($("#phone").val());
            if (!DSXValidate.IsMobile(phone)) {
                DSXUI.error('手机号码输入有误,请重新输入');
                return false;
            }

            var birthday = $.trim($("#birthday").val());
            if (!birthday) {
                DSXUI.error('请选择出生日期');
                return false;
            }

            var university = $.trim($("#university").val());
            if (!university) {
                DSXUI.error('请填写你所就读大学');
                return false;
            }

            var enrollyear = $.trim($("#enrollyear").val());
            if (!enrollyear) {
                DSXUI.error('请选择入学年份');
                return false;
            }

            var birthplace = $.trim($("#birthplace").val());
            if (!birthplace) {
                DSXUI.error('请填写家乡所在地');
                return false;
            }

            var location = $.trim($("#location").val());
            if (!location) {
                DSXUI.error('请填写你当前所在地');
                return false;
            }

            if (confirm('资料提交后将不可再修改,是否确认要现在提交申请？')){
                var spinner = null;
                $("#Form").ajaxSubmit({
                    dataType:'json',
                    beforeSend:function () {
                        spinner = DSXUI.showSpinner();
                    },
                    success:function (response) {
                        setTimeout(function () {
                            spinner.close();
                            if (response.errcode === 0){
                                DSXUI.success('你的申请资料已提交成功<br>请等待管理员审核!', function () {
                                    window.location.href = '/mobile';
                                });
                            }else {
                                DSXUI.error(response.errmsg);
                            }
                        }, 500);
                    }
                });
            }
        });
    </script>
@stop
