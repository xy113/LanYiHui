@extends('layouts.mobile')

@section('title', '修改信息')

@section('styles')
    <link rel="stylesheet" href="{{asset('css/iconfont.css')}}" type="text/css">
@stop

@section('content')
    <link rel="stylesheet" type="text/css" href="{{asset('css/date.css')}}">
    <div class="resume">
        <form method="post" id="Form" style="padding: 10px 0;">
            {{csrf_field()}}
            <input type="hidden" name="formsubmit" value="yes">
            <div class="form-wrap">
                <div class="form-group">
                    <div class="label">姓名</div>
                    <div class="content"><input type="text" class="input-text" name="user[fullname]" id="fullname" value="{{$user['fullname']}}" placeholder="你的姓名"></div>
                </div>
                <div class="form-group">
                    <div class="label">性别</div>
                    <div class="content" style="padding-top: 7px">
                        <label><input type="radio" class="radio" name="user[sex]" value="0"@if($user['sex']==0) checked="checked"@endif> 女</label>
                        <label><input type="radio" class="radio" name="user[sex]" value="1"@if($user['sex']==1) checked="checked"@endif> 男</label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="label">电话</div>
                    <div class="content"><input type="text" class="input-text" name="user[phone]" id="phone" value="{{$user['phone']}}" placeholder="电话号码"></div>
                </div>
                <div class="form-group">
                    <div class="label">生日</div>
                    <div class="content"><input type="text" class="input-text" name="user[birthday]" id="birthday" value="{{$user['birthday']}}" placeholder="生日"></div>
                </div>
                <div class="form-group">
                    <div class="label">就读大学</div>
                    <div class="content"><input type="text" class="input-text" name="user[university]" id="university" value="{{$user['university']}}" placeholder="就读学校"></div>
                </div>
                <div class="form-group">
                    <div class="label">入学年份</div>
                    <div class="content"><input type="text" class="input-text" name="user[enrollyear]" id="enrollyear" value="{{$user['enrollyear']}}" placeholder="入学年份"></div>
                </div>
                <div class="form-group">
                    <div class="label">籍贯</div>
                    <div class="content"><input type="text" class="input-text" name="user[birthplace]" id="birthplace" value="{{$user['birthplace']}}" placeholder="籍贯"></div>
                </div>
                <div class="form-group">
                    <div class="label">所在地</div>
                    <div class="content"><input type="text" class="input-text" name="user[location]" id="location" value="{{$user['location']}}" placeholder="所在地"></div>
                </div>
                <div class="form-group">
                    <div class="label"></div>
                    <div class="content">
                        <button type="button" id="submit" class="button">保存</button>
                    </div>
                </div>
            </div>
        </form>
        <div id="datePlugin"></div>
    </div>
    <script src="{{asset('js/date.js')}}" type="text/javascript"></script>
    <script type="text/javascript">
        var nowDate = new Date();
        var date = $('#birthday').val().split('-');
        var byear = date[0]?date[0]:'2000';
        var bmonth = date[1]?date[1]:'1';
        var bday = date[2]?date[2]:'1';
        console.log(byear,bmonth,bday);
        $('#birthday').date({
            setY:byear,
            setM:bmonth,
            setD:bday,
            curdate:false
        })

        $("#submit").on('click', function () {
            var name = $.trim($("#name").val());

            var phone = $.trim($("#phone").val());
            if (!phone) {
                DSXUI.error('请填写电话号码');
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
                            window.location.href = '{{url('/mobile/member/archive')}}';
                        }else {
                            DSXUI.error(response.errmsg);
                        }
                    }, 500);
                }
            });
        });
    </script>
@stop
