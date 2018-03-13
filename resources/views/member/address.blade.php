@extends('layouts.member')

@section('content')
    <div class="console-title">
        <h2>收货地址管理</h2>
    </div>
    <div class="content-div">
        <form method="post" id="addrFrom">
            {{csrf_field()}}
            <input type="hidden" name="formsubmit" value="yes">
            <input type="hidden" name="address_id" value="{{$address_id}}">
            <table cellpadding="0" cellspacing="0" width="100%" class="formtable">
                <tr>
                    <td class="cell-name" width="80">收货人</td>
                    <td><input title="" type="text" class="input-text" id="consignee" name="address[consignee]" value="{{$address['consignee']}}"></td>
                </tr>
                <tr>
                    <td class="cell-name">联系电话</td>
                    <td><input title="" type="text" class="input-text" id="phone" name="address[phone]" value="{{$address['phone']}}"></td>
                </tr>
                <tr>
                    <td class="cell-name">所在地</td>
                    <td>
                        <select title="" class="select width-auto" id="province" name="address[province]">
                            <option value="">请选择</option>
                        </select>
                        <select title="" class="select width-auto" id="city" name="address[city]">
                            <option value="">请选择</option>
                        </select>
                        <select title="" class="select width-auto" id="district" name="address[district]">
                            <option value="">请选择</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class="cell-name">街道地址</td>
                    <td><input title="" type="text" class="input-text w300" id="street" name="address[street]" value="{{$address['street']}}"></td>
                </tr>
                <tr>
                    <td class="cell-name">邮政编码</td>
                    <td><input title="" type="text" class="input-text" id="postcode" name="address[postcode]" value="{{$address['postcode']}}"></td>
                </tr>
                <tr>
                    <td class="cell-name"></td>
                    <td>
                        <label>
                            <input type="checkbox" class="checkbox" name="address[isdefault]" value="1"@if($address['isdefault']) checked="checked"@endif>
                            <span>设为默认收货地址</span>
                        </label>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td><input type="submit" class="button" value="提交"></td>
                </tr>
            </table>
        </form>
    </div>
    <div class="console-title">
        <h2>收货地址列表</h2>
    </div>
    <div class="content-div">
        <table cellpadding="0" cellspacing="0" width="100%" border="0" class="listtable">
            <thead>
            <tr>
                <th width="120">联系人</th>
                <th width="120">电话</th>
                <th>地址</th>
                <th width="80">邮编</th>
                <th width="80">选项</th>
                <th width="100"></th>
            </tr>
            </thead>
            <tbody>
            @foreach($itemlist as $id=>$item)
            <tr id="item-{{$item['address_id']}}" class="addrRow">
                <td height="50"><b>{{$item['consignee']}}</b></td>
                <td>{{$item['phone']}}</td>
                <td>{{$item['province']}} {{$item['city']}} {{$item['district']}} {{$item['street']}}</td>
                <td>{{$item['postcode']}}</td>
                <td>
                    <a href="/member/address?address_id={{$id}}">修改</a>
                    <a href="javascript:;" rel="delete" data-id="{{$id}}">删除</a>
                </td>
                <td>
                    @if($item['isdefault'])
                    <span class="button button-cancel">默认地址</span>
                    @else
                    <span class="button addrBtn" style="display: none;" data-id="{{$id}}">默认地址</span>
                    @endif
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <script type="text/javascript">
        $(function () {
            var district = new DistrictSelector({
                province:'{{$address['province']}}',
                city:'{{$address['city']}}',
                district:'{{$address['district']}}'
            });
            $(".addrRow").hover(function () {
                $(this).find('.addrBtn').show();
            }, function () {
                $(this).find('.addrBtn').hide();
            });
            $(".addrBtn").on('click', function () {
                var address_id = $(this).attr('data-id');
                $.ajax({
                    url:"/member/address/setdefault",
                    data:{address_id:address_id},
                    dataType:'json',
                    success:function (response) {
                        if (response.errcode === 0){
                            DSXUtil.reFresh();
                        }
                    }
                });
            });
            $("a[rel=delete]").on('click', function () {
                var spinner = null;
                var address_id = $(this).attr('data-id');
                DSXUI.showConfirm('删除地址', '确认要删除此收货地址吗?', function () {
                    $.ajax({
                        url:"/member/address/delete",
                        data:{address_id:address_id},
                        dataType:'json',
                        beforeSend:function () {
                            spinner = DSXUI.showSpinner();
                        },
                        success:function (response) {
                            setTimeout(function () {
                                spinner.close();
                                if (response.errcode === 0){
                                    $("#item-"+address_id).remove();
                                }
                            }, 500);
                        }
                    });
                });
            });
            $("#addrFrom").on('submit', function () {
                var consignee = $.trim($("#consignee").val());
                if (!consignee) {
                    DSXUI.error('请填写收货人姓名');
                    return false;
                }

                var phone = $.trim($("#phone").val());
                if (!phone) {
                    DSXUI.error('请填写联系电话');
                    return false;
                }

                var province = $("#province").val();
                var city = $("#city").val();
                var district = $("#district").val();
                if (!province || !city || !district){
                    DSXUI.error('请选择所在地');
                    return false;
                }
                var street = $.trim($("#street").val());
                if (!street) {
                    DSXUI.error('请填写街道地址');
                    return false;
                }
                var postcode = $.trim($("#postcode").val());
                if (!postcode) {
                    DSXUI.error('请填写邮政编码');
                    return false;
                }
            });
        });
    </script>
@stop
