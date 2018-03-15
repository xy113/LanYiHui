@extends('layouts.company')

@section('content')
    <div class="page-header">
        <div class="console-title">
            <a href="/company/job" class="button float-right">返回列表</a>
            <h2>资料设置</h2>
        </div>
    </div>
    <div class="page-content">
        <div class="form-wrapper">
            <form method="post" id="companyForm">
                <input type="hidden" name="formsubmit" value="yes">
                {{csrf_field()}}
                <table cellpadding="0" cellspacing="0" width="100%" class="formtable">
                    <tbody>
                    <tr>
                        <td width="80">职位名称</td>
                        <td width="320"><input name="job[title]" id="title" title="" type="text" class="input-text" value="{{$job['title']}}"></td>
                        <td class="tips">职位名称，至少两个字，不能含有特殊字符和符号</td>
                    </tr>
                    <tr>
                        <td>职位类别</td>
                        <td>
                            <label><input type="radio" class="radio" value="1" name="job[type]"@if($job['type']==1) checked="checked"@endif> 全职</label>
                            <label><input type="radio" class="radio" value="2" name="job[type]"@if($job['type']==2) checked="checked"@endif> 兼职</label>
                        </td>
                        <td class="tips">图片格式为jpg，jpeg，png，gif，大小不要超过2MB</td>
                    </tr>
                    <tr>
                        <td>薪资范围</td>
                        <td colspan="2">
                            @foreach($salary_ranges as $k=>$v)
                                <label><input type="radio" class="radio" name="job[salary]" value="{{$k}}"@if($job['salary']==$k) checked="checked"@endif>{{$v}}</label>
                            @endforeach
                        </td>
                    </tr>

                    <tr>
                        <td>招聘人数</td>
                        <td><input name="job[num]" id="num" title="" type="text" class="input-text" value="{{$job['num']}}"></td>
                        <td class="tips"></td>
                    </tr>
                    <tr>
                        <td>工作地点</td>
                        <td><input name="job[place]" id="place" title="" type="text" class="input-text" value="{{$job['place']}}"></td>
                        <td class="tips"></td>
                    </tr>
                    <tr>
                        <td>福利待遇</td>
                        <td colspan="2">
                            @foreach($welfare_types as $k=>$v)
                                <label><input type="checkbox" class="checkbox" name="welfares[]" value="{{$k}}"@if(isset($job['welfare'][$k])) checked="checked"@endif>{{$v}}</label>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <td>企业介绍</td>
                        <td colspan="2">
                            <textarea class="textarea" id="description" title="" name="job[description]" style="width: 640px; height: 360px;">{{$job['description']}}</textarea>
                        </td>
                    </tr>
                    </tbody>
                    <tfoot>
                    <tr>
                        <td></td>
                        <td colspan="2">
                            <button type="submit" class="button" style="width: 120px;">提交</button>
                        </td>
                    </tr>
                    </tfoot>
                </table>
            </form>
        </div>
        <script type="text/javascript">
            $(function () {
                $("#companyForm").on('submit', function () {
                    var title = $.trim($("#title").val());
                    if (!title) {
                        DSXUI.error('请填写职位名称');
                        return false;
                    }

                    var num = $("#num").val();
                    if (!num) {
                        DSXUI.error('请填写招聘人数');
                        return false;
                    }

                    var place = $("#place").val();
                    if (!place) {
                        DSXUI.error('请填写工作地点');
                        return false;
                    }

                    var description = $("#description").val();
                    if (description.length < 50) {
                        DSXUI.error('职位描述不能少于50个字');
                        return false;
                    }
                });
            });
        </script>
    </div>
@stop
