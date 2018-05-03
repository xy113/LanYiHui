@extends('layouts.mobile')

@section('title', '投递简历')

@section('content')
    <div class="recruit">
        <form method="post" id="Form">
            {{csrf_field()}}
            <input type="hidden" name="formsubmit" value="yes">
            <h3 class="resume-choose">选择简历</h3>
            <ul class="resume-list">
                @foreach ($itemlist as $item)
                    <li>
                        <label>
                            <input type="radio" class="radio" name="resume_id" value="{{$item['id']}}">
                            {{$item['title']}}
                        </label>
                    </li>
                @endforeach
            </ul>
            <div class="enroll-button">
                <button type="button" class="button" id="send">投递</button>
            </div>
            <div class="blank"></div>
        </form>
    </div>
    <script type="text/javascript">
        $("#send").on('tap', function () {
            if ($(".radio:checked").length === 0) {
                DSXUI.error('请选择简历');
            }else  {
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
                                DSXUI.success('简历投递成功', function () {
                                    window.history.back();
                                });
                            }else {
                                DSXUI.error(response.errmsg);
                            }
                        }, 500)
                    }
                });
            }
        });
    </script>
@stop
