@extends('layouts.mobile')

@section('title', '教育经历')

@section('content')
    <link rel="stylesheet" type="text/css" href="{{asset('css/date.css')}}">
    <div class="resume">
        <form method="post" id="Form">
            {{csrf_field()}}
            <input type="hidden" name="formsubmit" value="yes">
            <div class="form-wrap">
                <div class="list-box">
                    <div>
                        <div class="form-group">
                            <div class="label">学校名称</div>
                            <div class="content"><input type="text" class="input-text" name="education[school]" id="school" value="{{$education['school']}}" placeholder="学校名称"></div>
                        </div>
                        <div class="form-group">
                            <div class="label">所学专业</div>
                            <div class="content"><input type="text" class="input-text" name="education[major]" id="major" value="{{$education['major']}}" placeholder="所学专业"></div>
                        </div>
                        <div class="form-group">
                            <div class="label">入学日期</div>
                            <div class="content"><input type="text" class="input-text" name="education[start_time]" id="start_time" value="{{date('Y-m-d',$education['start_time'])}}" placeholder="毕业年份" readonly></div>
                        </div>
                        <div class="form-group">
                            <div class="label">毕业日期</div>
                            <div class="content"><input type="text" class="input-text" name="education[end_time]" id="end_time" value="{{date('Y-m-d',$education['end_time'])}}" placeholder="毕业年份" readonly></div>
                        </div>
                        <div class="form-group">
                            <div class="label">学历</div>
                            <div class="content">
                                <select id="degree_select" name="education[degree]">
                                    <option value="0">其他</option>
                                    <option value="1">小学</option>
                                    <option value="2">初中</option>
                                    <option value="3">高中</option>
                                    <option value="4">专科</option>
                                    <option value="5">本科</option>
                                    <option value="6">硕士</option>
                                    <option value="7">博士</option>
                                </select>
                            </div>
                        </div>
                        <div style="display: none">
                            <input type="text" id="degree" value="{{$education['degree']}}">
                            <input type="text" name="education[id]" id="id" value="{{$education['id']}}">
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
            <div id="datePlugin"></div>
        </form>
    </div>
    <script src="{{asset('js/date.js')}}" type="text/javascript"></script>
    <script type="text/javascript">
        var now = new Date();
        var edate = $('#end_time').val().split('-');
        var bdate = $('#start_time').val().split('-');
        var byear = bdate[0]?bdate[0]:(now.getFullYear()-4).toString();
        var bmonth = bdate[1]?bdate[1]:'9';
        var bday = bdate[2]?bdate[2]:'1';
        var eyear = edate[0]?edate[0]:now.getFullYear().toString();
        var emonth = edate[1]?edate[1]:'7';
        var eday = edate[2]?edate[2]:'1';

        $('#start_time').date({
            setY:byear,
            setM:bmonth,
            setD:bday,
            curdate:false
        });
        $('#end_time').date({
            setY:eyear,
            setM:emonth,
            setD:eday,
            curdate:false
        });

        (function () {
            $('#degree_select').val($('#degree').val());
            console.log($('#degree_select').val());
        })();
        $('#degree_select').change(function () {
            $('#degree').val($('#degree_select').val());
            console.log($('#degree').val());
        })
        $("#submit").on('click', function () {

            var school = $.trim($("#school").val());
            if (!school) {
                DSXUI.error('请填写学校名称');
                return false;
            }
            var major = $.trim($("#major").val());
            if (!major) {
                DSXUI.error('请填写专业名称');
                return false;
            }
            var end_time = $.trim($("#end_time").val());
            if (!end_time) {
                DSXUI.error('请填写学校名称');
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
