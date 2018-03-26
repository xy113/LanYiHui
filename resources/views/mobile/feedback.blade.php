@extends('layouts.mobile')

@section('title', '意见反馈')

@section('content')
    <div class="feedback">
        <div class="form-wrap">
            <form method="post" id="Form">
                {{csrf_field()}}
                <input type="hidden" name="formsubmit" value="yes">
                <div class="form-group">
                    <div class="label">主题</div>
                    <div class="content"><input type="text" class="input-text" name="title" id="title" placeholder="你要反馈的主题"></div>
                </div>
                <div class="form-group">
                    <div class="label">内容</div>
                    <div class="content">
                        <textarea class="textarea" name="message" id="message" placeholder="简单描述一下你要反应的问题"></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <div class="label"></div>
                    <div class="content"><button type="button" class="button" id="submit">提交</button></div>
                </div>
            </form>
        </div>
    </div>
    <script type="text/javascript">
        (function () {
            $("#submit").on('click', function () {
                var title = $.trim($("#title").val());
                if (!title) {
                    DSXUI.error('请填写主题');
                    return false;
                }

                var message = $.trim($("#message").val());
                if (message.length < 10) {
                    DSXUI.error('请简单描述一下你的问题，不少于10个字');
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
                            if (response.errcode === 0) {
                                DSXUI.success('你的问题已提交', function () {
                                    window.location.href = '{{url('/mobile/member')}}';
                                })
                            }
                        }, 500);
                    }
                });
            })
        })();
    </script>
@stop
