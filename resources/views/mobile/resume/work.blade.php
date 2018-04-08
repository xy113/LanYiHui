@extends('layouts.mobile')

@section('title', '工作经历')

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
                            <div class="label">公司名称</div>
                            <div class="content"><input type="text" class="input-text" name="work[company]" id="company" value="{{$work['company']}}" placeholder="公司名称"></div>
                        </div>
                        <div class="form-group">
                            <div class="label">职位</div>
                            <div class="content"><input type="text" class="input-text" name="work[job]" id="job" value="{{$work['job']}}" placeholder="担任职位"></div>
                        </div>

                        <div class="form-group">
                            <div class="label">入职时间</div>
                            <div class="content">
                                <input type="text" class="input-text" name="work[start_time]" id="start_time" value="{{$work['start_time']}}" placeholder="入职时间">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="label">离职时间</div>
                            <div class="content">
                                <input type="text" class="input-text" name="work[end_time]" id="end_time" value="{{$work['end_time']}}" placeholder="离职时间">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="label">工作介绍</div>
                            <div class="content">
                                <textarea class="textarea" name="work[experience]" id="experience" placeholder="主要工作介绍">{{$work['experience']}}</textarea>
                            </div>
                        </div>
                        <div style="display: none">
                            <input type="text" name="work[id]" id="id" value="{{$work['id']}}">
                            <input type="text" name="work[resume_id]" id="resume_id" value="{{$work['resume_id']}}">
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
        <div id="datePlugin"></div>
    </div>
    <script src="{{asset('js/date.js')}}" type="text/javascript"></script>
    <script type="text/javascript">
        var date1 = $('#end_time').val().split('-');
        var year1 = date1[0]?date1[0]:'2000';
        var month1 = date1[1]?date1[1]:'1';
        var day1 = date1[2]?date1[2]:'1';

        $('#end_time').date({
            setY:year1,
            setM:month1,
            setD:day1,
            curdate:false
        });

        var date2 = $('#start_time').val().split('-');
        var year2 = date2[0]?date2[0]:'2000';
        var month2 = date2[1]?date2[1]:'1';
        var day2 = date2[2]?date2[2]:'1';

        $('#start_time').date({
            setY:year2,
            setM:month2,
            setD:day2,
            curdate:false
        });

        $("#submit").on('click', function () {

            var company = $.trim($("#company").val());
            if (!company) {
                DSXUI.error('请填写单位名称');
                return false;
            }
            var job = $.trim($("#job").val());
            if (!job) {
                DSXUI.error('请填写职位名称');
                return false;
            }
            var start_time = $.trim($("#start_time").val());
            if (!start_time) {
                DSXUI.error('请填写入职时间');
                return false;
            }
            var end_time = $.trim($("#end_time").val());
            if (!end_time) {
                DSXUI.error('请填写离职时间');
                return false;
            }

            var resume_id = $("#resume_id").val();
            if (!resume_id) {
                DSXUI.error('未关联简历，请返回上一步！');
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
                            window.location.href = '{{url('/mobile/resume/edit?id='.$work['resume_id'])}}';
                        }else {
                            DSXUI.error(response.errmsg);
                        }
                    }, 500);
                }
            });
        });
    </script>
@stop
