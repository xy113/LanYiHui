@extends('layouts.mobile')

@section('title', '编辑简历')

@section('content')
    <div class="resume">
        <form method="post" id="Form">
            {{csrf_field()}}
            <input type="hidden" name="formsubmit" value="yes">
            <div class="form-wrap">
                <div class="list-box">
                    <h4>基本信息</h4>
                    <div>
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
                            <div class="label">最高学历</div>
                            <div class="content">
                                <select  class="input-text" name="resume[education]" id="education">
                                    <option value="0" @if($resume['education']=='0')selected @endif>其他</option>
                                    <option value="1" @if($resume['education']=='1')selected @endif>小学</option>
                                    <option value="2" @if($resume['education']=='2')selected @endif>初中</option>
                                    <option value="3" @if($resume['education']=='3')selected @endif>高中</option>
                                    <option value="4" @if($resume['education']=='4')selected @endif>专科</option>
                                    <option value="5" @if($resume['education']=='5')selected @endif>本科</option>
                                    <option value="6" @if($resume['education']=='6')selected @endif>硕士</option>
                                    <option value="7" @if($resume['education']=='7')selected @endif>博士</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="label">工作经验</div>
                            <div class="content"><input type="text" class="input-text" name="resume[work_exp]" id="work_exp" value="{{$resume['work_exp']}}" placeholder="工作经验，单位:年"></div>
                        </div>
                        <div class="form-group">
                            <div class="label">所在地</div>
                            <div class="content"><input type="text" class="input-text" name="resume[address]" id="address" value="{{$resume['address']}}" placeholder="当前所在地"></div>
                        </div>
                        <div class="form-group">
                            <div class="label">个人介绍</div>
                            <div class="content">
                                <textarea class="textarea" name="resume[introduction]" id="introduction" placeholder="简单简绍一下你自己">{{$resume['introduction']}}</textarea>
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
                <div class="list-box">
                    <h4>教育经历</h4>
                    <div>
                        @forelse ($edus as $edu)
                            <div class="resume-li">
                                <a href="{{url('/mobile/resume/edu?id='.$edu->id.'&resume='.$resume['id'])}}" class="iconfont icon-edit">编辑</a>
                                <div>{{date('Y',$edu->end_time)}}年毕业</div>
                                <div class="mainInfo">{{$edu->school}}</div>
                                <div>
                                    @switch($edu->degree)
                                        @case('1')
                                        小学
                                        @break
                                        @case('2')
                                        初中
                                        @break
                                        @case('3')
                                        高中
                                        @break
                                        @case('4')
                                        专科
                                        @break
                                        @case('5')
                                        本科
                                        @break
                                        @case('6')
                                        硕士
                                        @break
                                        @case('7')
                                        博士
                                        @break
                                        @default
                                        其他
                                        @endswitch
                                    ·{{$edu->major}}
                                </div>
                            </div>
                        @empty
                            <p class="notice">暂无教育经历</p>
                        @endforelse
                            <a href="{{url('/mobile/resume/edu?resume='.$resume['id'])}}" class="add-btn iconfont icon-add"> 添加</a>
                    </div>
                </div>
                <div class="list-box">
                    <h4>工作经历</h4>
                    <div>
                        @forelse($works as $work)
                            <div class="resume-li">
                                <a href="{{url('/mobile/resume/work?id='.$work['id'].'&resume='.$resume['id'])}}" class="iconfont icon-edit">编辑</a>
                                <div>{{date('Y-m-d',$work->start_time)}} - {{date('Y-m-d',$work->end_time)}}</div>
                                <div class="mainInfo">{{$work->job}}·{{$work->company}}</div>
                                <div>{{$work->experience}}</div>
                            </div>
                            @empty
                            <p class="notice">暂无工作经历</p>
                        @endforelse
                        <a href="{{url('/mobile/resume/work?&resume='.$resume['id'])}}" class="add-btn iconfont icon-add"> 添加</a>
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

            var education = $.trim($("#education").val());
            if (!education) {
                DSXUI.error('请填写学历');
                return false;
            }

            var work_exp = $.trim($("#work_exp").val());
            if (!work_exp) {
                DSXUI.error('请填写工作经验');
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
