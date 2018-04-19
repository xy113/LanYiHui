@extends('layouts.mobile')

@section('title', '添加校友录')

@section('content')

    <div class="resume">
        <div class="form-wrap">
            <div class="form-group">
                <div class="label">学校名称</div>
                <div class="content">
                    <input type="text" class="input-text" id="school" value="" placeholder="学校名称" oninput="getSchool()">
                    <div class="select-box" id="select">

                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="label">毕业年份</div>
                <div class="content">
                    <input type="text" class="input-text" id="graduation_at" value="" placeholder="毕业年份">
                </div>
            </div>
            <div class="form-group">
                <div class="label">就读专业</div>
                <div class="content">
                    <input type="text" class="input-text" id="major" value="" placeholder="就读专业">
                </div>
            </div>
            <div class="form-group">
                <div class="label">毕业学历</div>
                <div class="content">
                    <select id="degree" class="input-text">
                        <option value="1">小学</option>
                        <option value="2">初中</option>
                        <option value="3">高中</option>
                        <option value="4" selected>本科</option>
                        <option value="5">硕士</option>
                        <option value="6">博士</option>
                        <option value="0">其他</option>
                    </select>
                </div>
            </div>
            <p style="margin-top: 3rem; font-size: 12px; color: #aaa;">注：请填写学校全称，如学校名非全称，可能导致学校审核不通过。</p>
            <div class="form-group">
                <div class="label"></div>
                <div class="content">
                    <button type="button" id="submit" class="button">申请</button>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $('#school').focus(function () {
            $('.select-box').show();
        })
        $('#school').blur(function () {
            setTimeout(function(){$('.select-box').hide()},300);
        });
        function getSchool() {
            if($('#school').val()){
                $.ajax({
                    type:'POST',
                    url:'{{url('/mobile/getSchool')}}',
                    dataType: 'json',
                    data:{school:$('#school').val()},
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    success:function (res) {
                        if(res.err_code==0){
                            $('#select').empty();
                            for (var i=0;i<res.data.length;i++){
                                $('#select').append('<li onclick="setVal(\''+res.data[i].name+'\')">'+res.data[i].name+'</li>');
                                if(i==4){
                                    break;
                                }
                            }
                        }
                    },
                    error:function (err) {

                    }
                })
            }
        }
        function setVal(val) {
            console.log('123');
            $('#school').val(val);
        }
        $('#submit').click(function () {
            if ($('#school').val()){
                $.ajax({
                    type:'POST',
                    url:'{{url('/mobile/forum/schoolfellow/apply')}}',
                    dataType: 'json',
                    data:{
                        school:$('#school').val(),
                        graduation_at:$('#graduation_at').val(),
                        degree:$('#degree option:selected').val(),
                        major:$('#major').val()
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    success:function (res) {
                        if(res.err_code==0){
                            DSXUI.success('申请成功',function () {
                                window.location = '{{url('/mobile/forum/schoolfellow/list')}}'
                            })
                        }else {
                            DSXUI.error(res.msg);
                        }
                    },
                    error:function (err) {

                    }
                })
            }else {

            }
        })
    </script>
@stop
