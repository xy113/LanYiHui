<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2018/2/7
 * Time: 下午3:06
 */

return [
    'username'=>'用户名',
    'password'=>'密码',
    'mobile'=>'手机号',
    'email'=>'邮箱',
    'you are not an administrator'=>'你不是管理员',
    'password incorrect'=>'密码错误',
    'account does not exist'=> '账号不存在',
    'captcha incorrect'=> '验证码输入错误',

    'username be occupied'=>'你输入的用户名已被人使用',
    'email be occupied'=>'你输入的邮箱已被人使用',
    'mobile be occupied'=>'你输入的手机号已被人使用',
    'password input incorrect'=>'密码输入错误',
    'login_be_forbidden'=>'你已被限制登录',
    'account_unauthorized'=>'账号未通过认证',
    'login_expired'=>'登录过期,请重新登录',
    'login_success'=>'登录成功',
    'register success'=>'注册成功',
    'member_add_succeed'=>'用户添加成功',

    'star'=>'星座',
    'star_items'=>array(
        1=>'白羊座',
        2=>'金牛座',
        3=>'双子座',
        4=>'巨蟹座',
        5=>'狮子座',
        6=>'处女座',
        7=>'天秤座',
        8=>'天蝎座',
        9=>'射手座',
        10=>'摩羯座',
        11=>'水瓶座',
        12=>'双鱼座'
    ),
    'sex'=>'性别',
    'sex_items'=>array(
        1=>'男',
        2=>'女',
        3=>'其他'
    ),
    'blood'=>'血型',
    'blood_items'=>array(
        1=>'A型',
        2=>'B型',
        3=>'O型',
        4=>'AB型',
        5=>'其他'
    ),
    'edu_items'=>array(
        1=>'小学',
        2=>'初中',
        3=>'高中',
        4=>'中专',
        5=>'大专',
        6=>'本科',
        7=>'研究生',
        8=>'硕士',
        9=>'博士'
    ),
    'member_status'=>array(
        '1'=>'正常',
        '-1'=>'禁止登录',
        '0'=>'等待验证'
    ),
    'member_perms'=>array(
        'allowpubpost'=>'发布文章',
        'alloweditpost'=>'编辑文章',
        'allowdelpost'=>'删除文章',
        'allowauditpost'=>'文章免审',
        'allowpostcomment'=>'发表评论',
        'allowdelcomment'=>'删除评论',
        'allowuploadphoto'=>'上传照片',
        'allowuploadattach'=>'上传附件'
    ),
    'usergroup_types'=>array(
        'system'=>'管理组',
        'member'=>'用户组'
    ),

    //个人中心
    'account_balance'=>'账户余额',
    'account_recharge'=>'账户充值',
    'trade_detail'=>'交易明细',
    'trade_status'=>array(
        'PAID'=>'已支付',
        'UNPAID'=>'未支付'
    ),
    'trade_success'=>'交易成功',
    'waiting_for_pay'=>'等待付款',

    'my_article'=>'我的文章',
    'my_ad'=>'我的广告',
    'my_score'=>'我的积分',
    'verify_status'=>[
        '-1'=>'审核不过',
        '0'=>'等待审核',
        '1'=>'认证通过'
    ]
];
