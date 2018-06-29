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
        return request()->header('x-token');
    });

    Route::any('/settings/get', 'SettingsController@get');

    Route::any('/account/signin', 'AccountController@signin');
    Route::any('/account/signup', 'AccountController@signup');

    Route::get('/block/batchget_item', 'BlockController@batchget_item');

    Route::any('/post/get_item', 'PostController@get_item');
    Route::any('/post/batchget_item', 'PostController@batchget_item');

    Route::any('/job/get_job', 'JobController@get_job');
    Route::any('/job/batchget_job', 'JobController@batchget_job');

    Route::any('/company/get_company', 'CompanyController@get_company');
    Route::any('/company/batchget_company', 'CompanyController@batchget_company');

    Route::any('/recruit/get_recruit', 'RecruitController@get_recruit');
    Route::any('/recruit/batchget_recruit', 'RecruitController@batchget_recruit');

    //forum
    Route::any('/forum/get_board', 'ForumController@get_board');
    Route::any('/forum/batchget_board', 'ForumController@batchget_board');

    Route::any('/forum/add_topic', 'ForumController@add_topic');
    Route::any('/forum/get_topic', 'ForumController@get_topic');
    Route::any('/forum/batchget_topic', 'ForumController@batchget_topic');

    Route::any('/forum/get_message', 'ForumController@get_message');
    Route::any('/forum/batchget_message', 'ForumController@batchget_message');
    Route::any('/forum/reply', 'ForumController@reply');

    Route::any('/feedback', 'FeedbackController@index');

    Route::any('/collection/add', 'CollectionController@add');
    Route::any('/collection/batchget', 'CollectionController@batchget');

    Route::any('/resume/get', 'ResumeController@get');
    Route::any('/resume/batchget', 'ResumeController@batchget');
    Route::any('/resume/generate', 'ResumeController@generate');
    Route::any('/resume/save', 'ResumeController@save');
    Route::any('/resume/delete', 'ResumeController@delete');

    Route::any('/archive/get', 'ArchiveController@get');
    Route::any('/archive/save', 'ArchiveController@save');
});
