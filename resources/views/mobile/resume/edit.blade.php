@extends('layouts.mobile')

@section('title', '编辑简历')

@section('content')
    <div class="resume">
        <form method="post" id="Form">
            {{csrf_field()}}
            <input type="hidden" name="formsubmit" value="yes">
            <div class="form-wrap">
                <div class="form-group">
                    <div class="label">简历名称</div>
                    <div class="content"><input type="text" class="input-text" name="resume[title]" id="title" value="{{$resume['title']}}" placeholder="简历名称"></div>
                </div>
                <div class="form-group">
                    <div class="label">姓名</div>
                    <div class="content"><input type="text" class="input-text" name="resume[name]" id="name" value="{{$resume['name']}}" placeholder="你的姓名"></div>
                </div>
                <div class="form-group">
                    <div class="label">性别</div>
                    <div class="content" style="padding-top: 7px">
                        <label><input type="radio" class="radio" name="resume[gender]" value="0"@if($resume['gender']==0) checked="checked"@endif> 女</label>
                        <label><input type="radio" class="radio" name="resume[gender]" value="1"@if($resume['gender']==1) checked="checked"@endif> 男</label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="label">年龄</div>
                    <div class="content"><input type="text" class="input-text" name="resume[age]" id="age" value="{{$resume['age']}}" placeholder="你的年龄"></div>
                </div>
                <div class="form-group">
                    <div class="label">电话</div>
                    <div class="content"><input type="text" class="input-text" name="resume[phone]" id="phone" value="{{$resume['phone']}}" placeholder="电话号码"></div>
                </div>
                <div class="form-group">
                    <div class="label">邮箱</div>
                    <div class="content"><input type="text" class="input-text" name="resume[email]" id="email" value="{{$resume['email']}}" placeholder="电子邮箱"></div>
                </div>
                <div class="form-group">
                    <div class="label">毕业学校</div>
                    <div class="content"><input type="text" class="input-text" name="resume[university]" id="university" value="{{$resume['university']}}" placeholder="毕业学校"></div>
                </div>
                <div class="form-group">
                    <div class="label">毕业年份</div>
                    <div class="content"><input type="text" class="input-text" name="resume[graduation_year]" id="graduation_year" value="{{$resume['graduation_year']}}" placeholder="毕业年份"></div>
                </div>
                <div class="form-group">
                    <div class="label">最高学历</div>
                    <div class="content"><input type="text" class="input-text" name="resume[education]" id="education" value="{{$resume['education']}}" placeholder="最高学历"></div>
                </div>
                <div class="form-group">
                    <div class="label">所学专业</div>
                    <div class="content"><input type="text" class="input-text" name="resume[major]" id="major" value="{{$resume['major']}}" placeholder="所学专业"></div>
                </div>
                <div class="form-group">
                    <div class="label">工作经验</div>
                    <div class="content"><input type="text" class="input-text" name="resume[work_exp]" id="work_exp" value="{{$resume['work_exp']}}" placeholder="工作经验，单位:年"></div>
                </div>
                <div class="form-group">
                    <div class="label">工作经历</div>
                    <div class="content">
                        <textarea class="textarea" name="resume[work_history]" id="work_history" placeholder="填写你的就业经历">{{$resume['work_history']}}</textarea>
                    </div>
                </div>
                <div class="form-group">
                    <div class="label">个人介绍</div>
                    <div class="content">
                        <textarea class="textarea" name="resume[introduction]" id="introduction" placeholder="简单简绍一下你自己">{{$resume['introduction']}}</textarea>
                    </div>
                </div>
                <div class="form-group">
                    <div class="label"></div>
                    <div class="content">
                        <button type="button" id="submit" class="button">保存</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <script type="text/javascript">
        $("#submit").on('click', function () {
            var title = $.trim($("#title").val());
            if (!title) {
                DSXUI.error('请填写简历名称');
                return false;
            }

            var name = $.trim($("#name").val());
            if (!DSXValidate.IsChineseName(name)) {
                DSXUI.error('姓名输入有误');
                return false;
            }

            var age = $.trim($("#age").val());
            if (!age) {
                DSXUI.error('请填写年龄');
                return false;
            }

            var phone = $.trim($("#phone").val());
            if (!phone) {
                DSXUI.error('请填写电话号码');
                return false;
            }

            var email = $.trim($("#email").val());
            if (!DSXValidate.IsEmail(email)) {
                DSXUI.error('电子邮箱输入有误');
                return false;
            }

            var university = $.trim($("#university").val());
            if (!university) {
                DSXUI.error('请填写毕业院校');
                return false;
            }

            var graduation_year = $.trim($("#graduation_year").val());
            if (!graduation_year) {
                DSXUI.error('请填写毕业年份');
                return false;
            }

            var education = $.trim($("#education").val());
            if (!education) {
                DSXUI.error('请填写学历');
                return false;
            }

            var major = $.trim($("#major").val());
            if (!major) {
                DSXUI.error('请填写专业');
                return false;
            }

            var work_exp = $.trim($("#work_exp").val());
            if (!work_exp) {
                DSXUI.error('请填写工作经验');
                return false;
            }

            var work_history = $.trim($("#work_history").val());
            if (!work_history) {
                DSXUI.error('请填写工作经历');
                return false;
            }

            var introduction = $.trim($("#introduction").val());
            if (!introduction) {
                DSXUI.error('请填写个人介绍');
                return false;
            }

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
                            window.location.href = '{{url('/mobile/resume')}}';
                        }else {
                            DSXUI.error(response.errmsg);
                        }
                    }, 500);
                }
            });
        });
    </script>
@stop
