@extends('layouts.mobile')

@section('title', '会员经历')

@section('content')
    <link rel="stylesheet" href="{{asset('css/jquery-weui.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/weui.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/date.css')}}">
    <div class="resume">
        <form method="post" id="Form">
            {{csrf_field()}}
            <input type="hidden" name="formsubmit" value="yes">
            <div class="form-wrap">
                <div class="list-box">
                    <div>
                        <input type="text" style="display: none;" name="experience[id]" id="id" value="{{$experience['id']}}">
                    <div class="form-group">
                            <div class="label">工作时段</div>
                            <div class="content" style="padding-top: 7px" id="time">
                                <label><input type="radio" class="radio" name="experience[vacation]" value="0" @if($experience['vacation']==0) checked="checked"@endif> 寒假</label>
                                <label><input type="radio" class="radio" name="experience[vacation]" value="1" @if($experience['vacation']==1) checked="checked"@endif> 暑假</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="label">工作年份</div>
                            <div class="content"><input type="text" class="input-text" name="experience[year]" id="year" value="{{$experience['year']}}" placeholder="工作年份"></div>
                        </div>
                        <p class="notice" style="margin: -20px 0">寒假以下一年的年份为主</p>
                        <div class="form-group">
                            <div class="label">参与类型</div>
                            <div class="content" style="padding-top: 7px">
                                <label><input r_name="part" type="radio" class="radio" name="experience[part]" value="0"@if($experience['part']==0) checked="checked"@endif> 部门</label>
                                <label><input r_name="part" type="radio" class="radio" name="experience[part]" value="1"@if($experience['part']==1) checked="checked"@endif> 活动</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="label">部门/活动名称</div>
                            <div class="content"><input type="text" class="input-text" name="experience[department]" id="department" value="{{$experience['department']}}" placeholder="活动/部门名称"></div>
                        </div>
                        <div class="form-group">
                            <div class="label">会员职务</div>
                            <div class="content"><input type="text" class="input-text" name="experience[role]" id="role" value="{{$experience['role']}}" placeholder="会员职务"></div>
                        </div>
                        <div class="form-group">
                            <div class="label">工作简述</div>
                            <div class="content">
                                <textarea class="textarea" name="experience[description]" id="description" placeholder="简单简绍一下你自己">{{$experience['description']}}</textarea>
                            </div>
                        </div>
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
    <script src="{{asset('js/jquery-weui.min.js')}}" type="text/javascript"></script>
    <script type="text/javascript">
        $("#submit").on('click', function () {

            var year = $.trim($("#year").val());
            if (!year) {
                DSXUI.error('请选择年份');
                return false;
            }
            var department = $.trim($("#department").val());
            if (!department) {
                DSXUI.error('请填写活动/部门名称');
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
