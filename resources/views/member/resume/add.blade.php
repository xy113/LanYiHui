@extends('layouts.member')

@section('title', '新增建立了')

@section('content')
    <style type="text/css">.input-text{width: 300px;}</style>
    <div class="console-title">
        <a href="{{url('member/resume')}}" class="button float-right">简历列表</a>
        <h2>我的简历</h2>
    </div>
    <div class="content-div">
        <form method="post" autocomplete="off" id="Form">
            {{csrf_field()}}
            <input type="hidden" name="formsubmit" value="yes">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="formtable">
                <tr>
                    <td width="65">简历名称</td>
                    <td width="320"><input title="" type="text" class="input-text" id="title" name="resume[title]" value="{{$resume['title']}}"></td>
                    <td>简历名称</td>
                </tr>
                <tr>
                    <td>姓名</td>
                    <td><input title="" type="text" class="input-text" id="name" name="resume[name]" value="{{$resume['name']}}"></td>
                    <td>真实姓名</td>
                </tr>
                <tr>
                    <td>性别</td>
                    <td>
                        <label><input type="radio" class="radio" name="resume[gender]" value="0"@if($resume['gender']==0) checked="checked"@endif> 女</label>
                        <label><input type="radio" class="radio" name="resume[gender]" value="1"@if($resume['gender']==1) checked="checked"@endif> 男</label>
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td>年龄</td>
                    <td><input title="" type="text" class="input-text" id="age" name="resume[age]" value="{{$resume['age']}}"></td>
                    <td>你的年龄</td>
                </tr>
                <tr>
                    <td>电话</td>
                    <td><input title="" type="text" class="input-text" id="phone" name="resume[phone]" value="{{$resume['phone']}}"></td>
                    <td>你的手机号码</td>
                </tr>
                <tr>
                    <td>邮箱</td>
                    <td><input title="" type="text" class="input-text" id="email" name="resume[email]" value="{{$resume['email']}}"></td>
                    <td>你的电子邮箱</td>
                </tr>
                <tr>
                    <td>毕业学校</td>
                    <td><input title="" type="text" class="input-text" id="university" name="resume[university]" value="{{$resume['university']}}"></td>
                    <td>你的毕业学校</td>
                </tr>
                <tr>
                    <td>毕业年份</td>
                    <td><input title="" type="text" class="input-text" id="graduation_year" name="resume[graduation_year]" value="{{$resume['graduation_year']}}"></td>
                    <td>毕业时间</td>
                </tr>
                <tr>
                    <td>最高学历</td>
                    <td><input title="" type="text" class="input-text" id="education" name="resume[education]" value="{{$resume['education']}}"></td>
                    <td>所获最高学历</td>
                </tr>
                <tr>
                    <td>所学专业</td>
                    <td><input title="" type="text" class="input-text" id="major" name="resume[major]" value="{{$resume['major']}}"></td>
                    <td>在学校所选专业</td>
                </tr>
                <tr>
                    <td>工作经验</td>
                    <td><input title="" type="text" class="input-text" id="work_exp" name="resume[work_exp]" value="{{$resume['work_exp']}}"></td>
                    <td>单位：年</td>
                </tr>
                <tr>
                    <td>工作经历</td>
                    <td colspan="2">
                        <textarea class="textarea" name="resume[work_history]" id="work_history" placeholder="填写你的就业经历" style="width: 600px; height: 200px;">{{$resume['work_history']}}</textarea>
                    </td>
                </tr>
                <tr>
                    <td>个人介绍</td>
                    <td colspan="2">
                        <textarea class="textarea" name="resume[introduction]" id="introduction" placeholder="简单简绍一下你自己" style="width: 600px; height: 200px;">{{$resume['introduction']}}</textarea>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="2"><input type="submit" class="button" title="" value="提交"></td>
                </tr>
            </table>
        </form>
    </div>
    <script type="text/javascript">
        $("#Form").on('submit', function () {
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
        });
    </script>
@stop
