@extends('layouts.mobile')

@section('title', '发表话题')

@section('content')
    <div class="content-div">
        <div class="form-wrap">
            <form method="post" id="Form">
                {{csrf_field()}}
                <input type="hidden" name="formsubmit" value="yes">
                <div class="form-group">
                    <div class="content"><input type="text" class="input-text" name="title" id="title" placeholder="填写话题"></div>
                </div>
                <div class="form-group">
                    <div class="content">
                        <textarea class="textarea" name="message" id="message" placeholder="填写内容，不少于5个字"></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <div class="content"><button type="button" class="button" id="submit" style="width: 100%;">发表</button></div>
                </div>
            </form>
        </div>
    </div>

    <script type="text/javascript">
        (function () {
            $("#submit").on('click', function () {
                var title = $.trim($("#title").val());
                if (!title) {
                    DSXUI.error('请填写话题');
                    return false;
                }

                var message = $.trim($("#message").val());
                if (message.length < 5) {
                    DSXUI.error('请填写内容，不少于5个字');
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
                                DSXUI.success('话题发布成功', function () {
                                    window.history.back();
                                });
                            }
                        }, 500);
                    }
                });
            })
        })();
    </script>
@stop
