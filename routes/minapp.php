<?php
/**
 * ============================================================================
 * Copyright (c) 2015-2018 贵州大师兄信息技术有限公司 All rights reserved.
 * siteַ: http://www.dsxcms.com
 * ============================================================================
 * @author:     David Song<songdewei@163.com>
 * @version:    v1.0.0
 * ---------------------------------------------
 * Date: 2018/5/30
 * Time: 下午5:41
 */

Route::group(['namespace'=>'Minapp'], function (){
    Route::get('/', function (){
        return request()->header('X-Token');
    });

    Route::any('/account/signin', 'AccountController@signin');
    Route::any('/account/signup', 'AccountController@signup');

    Route::get('/block/batchget_item', 'BlockController@batchget_item');

    Route::any('/post/get_item', 'PostController@get_item');
    Route::any('/post/batchget_item', 'PostController@batchget_item');
});
