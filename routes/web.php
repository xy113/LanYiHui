<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['namespace' => 'Home'], function () {
    Route::get('/', 'IndexController@index');
});

Route::group(['namespace' => 'Member', 'middleware' => 'member.auth', 'prefix' => 'member'], function () {
    Route::get('/', 'IndexController@index');
    Route::any('/settings/userinfo', 'SettingsController@userinfo');
    Route::any('/settings/security', 'SettingsController@security');
    Route::any('/settings/verify', 'SettingsController@verify');

    Route::any('/wallet', 'WalletController@index');
    Route::any('/address', 'AddressController@index');
    Route::any('/address/setdefault', 'AddressController@setdefault');
    Route::any('/address/delete', 'AddressController@delete');
    Route::any('/collection/delete', 'CollectionController@delete');
    Route::any('/collection/{type}', 'CollectionController@index');
    Route::any('/comment', 'CommentController@index');
});

Route::group(['namespace'=>'Plugin', 'prefix'=>'plugin'], function (){
    Route::get('/image', 'ImageController@index');
    Route::get('/avatar', 'AvatarController@index');
});

Route::group(['namespace' => 'Account', 'prefix'=>'account'], function (){
    Route::get('/login', 'LoginController@index');
    Route::post('/login/check', 'LoginController@check');
    Route::get('/logout', 'LogoutController@index');
    Route::get('/register', 'RegisterController@index');
    Route::post('register/save', 'RegisterController@save');
    Route::any('/register/check', 'RegisterController@check');
});


//service
Route::post('/service/upload/image', 'Service\UploadController@image');

Route::group(['namespace' => 'Post'], function (){
    Route::get('news', 'IndexController@index');

    Route::group(['prefix'=>'post'], function (){
        Route::get('/list', 'ListController@index');
        Route::get('/detail/{aid}.html', 'DetailController@index');
    });
});

Route::group(['namespace'=>'Recruit', 'prefix'=>'recruit'], function (){
    Route::get('/', 'IndexController@index');
});

Route::group(['namespace'=>'Job', 'prefix'=>'job'], function (){
    Route::get('/', 'IndexController@index');
    Route::get('/detail/{id}.html', 'DetailController@index');
});

Route::group(['namespace'=>'Company', 'prefix'=>'company'], function (){
    Route::any('/', 'IndexController@index');
    Route::get('/login', 'LoginController@index');
    Route::post('/login/check', 'LoginController@check');
    Route::post('/logout', 'LoginController@logout');
    Route::get('/register', 'RegisterController@index');
    Route::post('/register/save', 'RegisterController@save');
    Route::post('/register/check', 'RegisterController@check');

    Route::any('/security', 'SecurityController@index');
    Route::any('/job', 'JobController@index');
    Route::any('/job/publish', 'JobController@publish');
    Route::any('/resume', 'ResumeController@index');
});

//后台管理
Route::group(['namespace' => 'Admin','prefix'=>'admin'], function(){
    Route::get('login', [
        'as'=>'login',
        'uses'=>'LoginController@index'
    ]);
    Route::get('logout', 'LoginController@logout')->name('logout');
    Route::post('checklogin', 'LoginController@checklogin');

    Route::group(['middleware'=>'auth.admin'], function (){
        Route::get('/', 'IndexController@index');
        Route::get('/index/wellcome', 'IndexController@wellcome');
        //系统设置
        Route::get('/settings/{type}', 'SettingsController@index');
        Route::post('/settings/save', 'SettingsController@save');
        //用户管理
        Route::get('/member', 'MemberController@index');
        Route::post('member/delete', 'MemberController@delete');
        Route::any('/membergroup', 'MemberGroupController@index');
        //菜单管理
        Route::any('/menu', 'MenuController@index');
        Route::any('/menu/itemlist', 'MenuController@itemlist');
        //广告管理
        Route::any('/ad', 'AdController@index');
        Route::any('/ad/edit', 'AdController@edit');
        //内容板块
        Route::any('/block', 'BlockController@index');
        Route::any('/block/edit', 'BlockController@edit');
        Route::any('/block/itemlist', 'BlockController@itemlist');
        Route::any('/block/edit_item', 'BlockController@edit_item');
        Route::any('/block/setimage', 'BlockController@setimage');

        //文章管理
        Route::get('/post/index', 'PostController@index');
        Route::get('/post/publish', 'PostController@publish');
        Route::post('/post/save', 'PostController@save');
        Route::post('/post/delete', 'PostController@delete');
        Route::post('/post/setimage', 'PostController@setimage');
        Route::post('/post/review', 'PostController@review');

        Route::any('/postcatlog', 'PostCatlogController@index');
        Route::any('/postcatlog/edit', 'PostCatlogController@edit');
        Route::any('/postcatlog/merge', 'PostCatlogController@merge');
        Route::any('/postcatlog/delete', 'PostCatlogController@delete');
        Route::post('/postcatlog/seticon', 'PostCatlogController@seticon');

        //微信管理
        Route::any('/weixin/menu', 'WeixinController@menu');
        Route::any('/weixin/apply_menu', 'WeixinController@apply_menu');
        Route::any('/weixin/remove_menu', 'WeixinController@remove_menu');
        Route::any('/weixin/edit_menu', 'WeixinController@edit_menu');
        Route::any('/weixin/material', 'WeixinController@material');
        Route::any('/weixin/add_material', 'WeixinController@add_material');
        Route::any('/weixin/news', 'WeixinController@news');
        Route::any('/weixin/add_news', 'WeixinController@add_news');
        Route::any('/weixin/viewimage', 'WeixinController@viewimage');

        //页面管理
        Route::any('/pages', 'PagesController@index');
        Route::any('/pages/publish', 'PagesController@publish');
        Route::any('/pages/category', 'PagesController@category');
        //素材管理
        Route::get('material', 'MaterialController@index');
        Route::post('material/delete', 'MaterialController@delete');
        //区域管理
        Route::get('/district', 'DistrictController@index');
        Route::post('/district/save', 'DistrictController@save');
        //快递管理
        Route::get('/express', 'ExpressController@index');
        Route::post('/express/save', 'ExpressController@save');

        //友情链接
        Route::get('/link', 'LinkController@index');
        Route::post('/link/save', 'LinkController@save');
        Route::post('/link/setimage', 'LinkController@setimage');
    });
});

Route::group(['namespace'=>'Mobile', 'prefix'=>'mobile'], function (){
    Route::get('/', 'IndexController@index');
});
