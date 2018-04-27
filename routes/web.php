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
    Route::any('/settings/archive', 'SettingsController@archive');
    Route::any('/settings/set_avatar', 'SettingsController@set_avatar');

    Route::any('/wallet', 'WalletController@index');
    Route::any('/address', 'AddressController@index');
    Route::any('/address/setdefault', 'AddressController@setdefault');
    Route::any('/address/delete', 'AddressController@delete');
    Route::any('/collection/delete', 'CollectionController@delete');
    Route::any('/collection/{type}', 'CollectionController@index');
    Route::any('/comment', 'CommentController@index');

    Route::any('/post','PostController@index');
    Route::any('/post/publish', 'PostController@publish');

    Route::any('/topic', 'TopicController@index');
    Route::any('/resume', 'ResumeController@index');
    Route::any('/resume/add', 'ResumeController@add');
});

Route::get('/avatar/{code}', 'Plugin\AvatarController@index');
Route::group(['namespace'=>'Plugin', 'prefix'=>'plugin'], function (){
    Route::get('/image', 'ImageController@index');
});
Route::get('test','Controller@test');
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

Route::group(['namespace'=>'Join', 'prefix'=>'join', 'middleware'=>'member.auth'], function (){
    Route::get('/', 'IndexController@index');
    Route::any('/enroll', 'IndexController@enroll');
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

    Route::group(['middleware'=>'admin.auth'], function (){
        Route::get('/', 'IndexController@index');
        Route::get('/index/wellcome', 'IndexController@wellcome');
        //系统设置
        Route::get('/settings/{type}', 'SettingsController@index');
        Route::post('/settings/save', 'SettingsController@save');
        //用户管理
        Route::get('/member', 'MemberController@index');
        Route::post('member/delete', 'MemberController@delete');
        Route::any('/member/archive', 'MemberController@archive');
        Route::any('/member/education', 'MemberController@education');
        Route::any('/member/experience', 'MemberController@experience');
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
        //校友录管理
        Route::get('/schoolfellow/school', 'SchoolmateController@index');
        Route::post('/schoolfellow/school/edit', 'SchoolmateController@editSchool');
        Route::post('/schoolfellow/school/deal', 'SchoolmateController@dealSchool');
        Route::get('/schoolfellow/detail','SchoolmateController@schoolfellow');
        Route::any('/schoolfellow/application', 'SchoolmateController@application');
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

        //用户反馈
        Route::any('/feedback', 'FeedbackController@index');

        //企业管理
        Route::any('/company', 'CompanyController@index');
        Route::any('/company/add', 'CompanyController@add');
        //职位
        Route::any('/job', 'JobController@index');
        Route::any('/job/publish', 'JobController@publish');
        //简历管理
        Route::any('/resume', 'ResumeController@index');
        Route::get('/resume/detail/{id}.html', 'ResumeController@detail');
        //联谊会招聘
        Route::any('/recruit', 'RecruitController@index');
        Route::any('/recruit/publish', 'RecruitController@publish');
        Route::any('/recruit/catlog', 'RecruitController@catlog');
        //讨论区
        Route::any('/forum/board', 'ForumController@board');
        Route::any('/forum/topic', 'ForumController@topic');
        Route::any('/forum/seticon', 'ForumController@seticon');
    });
});

//移动版
Route::group(['namespace'=>'Mobile', 'prefix'=>'mobile'], function (){
    Route::get('/', 'IndexController@index');
    Route::get('/activity', 'ActivityController@index');

    Route::get('/post/detail/{aid}.html', 'PostController@detail');
    Route::get('/post/list', 'PostController@itemlist');
    Route::get('/post/getjson', 'PostController@getjson');

    Route::get('/job/list', 'JobController@itemlist');
    Route::get('/job/detail/{id}.html', 'JobController@detail');

    Route::post('/background/upload','ImageController@upload');

    Route::any('/join/index', 'JoinController@index');
    Route::any('/join/enroll', 'JoinController@enroll');

    Route::any('/login', 'SignController@signin');
    Route::any('/register', 'SignController@signup');

    Route::get('/member', 'MemberController@index');
    Route::get('/member/archive', 'MemberController@archive')->middleware('mobile.auth');
    Route::any('/member/experience/edit','MemberController@experienceEdit')->middleware('mobile.auth');
    Route::any('/member/experience/add','MemberController@experienceAdd')->middleware('mobile.auth');
    Route::any('/member/edit', 'MemberController@edit')->middleware('mobile.auth');
    Route::any('/member/userinfo', 'MemberController@info')->middleware('mobile.auth');
    Route::any('/member/education', 'MemberController@education')->middleware('mobile.auth');
    Route::any('/member/work', 'MemberController@work')->middleware('mobile.auth');

    Route::any('/schoolfellow/index', 'SchoolController@index')->middleware('mobile.auth');
    Route::get('/schoolfellow/list', 'SchoolController@schoolfellow')->middleware('mobile.auth');

    Route::get('/pages/list', 'PagesController@index');
    Route::get('/pages/detail/{pageid}.html', 'PagesController@detail');

    Route::get('/company', 'CompanyController@index');
    Route::get('/company/detail/{id}.html', 'CompanyController@detail');

    Route::get('/daren', 'DarenController@index')->middleware(['mobile.auth']);
    Route::get('/space/{uid}', 'SpaceController@index')->middleware(['mobile.auth']);

    Route::get('/resume', 'ResumeController@index')->middleware(['mobile.auth']);
    Route::any('/resume/edit', 'ResumeController@edit')->middleware(['mobile.auth']);
    Route::get('/resume/delete', 'ResumeController@delete')->middleware(['mobile.auth']);
    Route::get('/resume/detail/{id}.html', 'ResumeController@detail')->middleware(['mobile.auth']);
    Route::get('/resume/json/get', 'ResumeController@get')->middleware(['mobile.auth']);
    Route::get('/resume/json/batchget', 'ResumeController@batchget')->middleware(['mobile.auth']);
    Route::any('/resume/edu', 'ResumeController@edu')->middleware(['mobile.auth']);
    Route::any('/resume/work', 'ResumeController@work')->middleware(['mobile.auth']);
    Route::post('/resume/createWithArchive','ResumeController@createWithArchive')->middleware(['mobile.auth']);

    Route::get('/recruit', 'RecruitController@index');
    Route::get('/recruit/detail/{id}.html', 'RecruitController@detail');
    Route::any('/recruit/enroll', 'RecruitController@enroll')->middleware('member.auth');

    Route::get('/favorite', 'FavoriteController@index')->middleware(['mobile.auth']);
    Route::get('/favorite/getjson', 'FavoriteController@getjson')->middleware(['mobile.auth']);
    Route::any('/feedback', 'FeedbackController@index')->middleware(['mobile.auth']);

    //交流
    Route::get('/forum', 'ForumController@index');
    Route::get('/forum/board/{boardid}', 'ForumController@board');
    Route::get('/forum/topic/{tid}', 'ForumController@topic')->middleware(['mobile.auth']);
    Route::any('/forum/publish', 'ForumController@publish')->middleware(['mobile.auth']);
    Route::any('/forum/reply', 'ForumController@reply')->middleware(['mobile.auth']);

    Route::any('/forum/schoolfellow', 'ForumController@schoolfellow')->middleware(['mobile.auth']);
    Route::any('/forum/schoolfellow/application','ForumController@applyPage')->middleware(['mobile.auth']);
    Route::post('/forum/schoolfellow/apply','ForumController@apply')->middleware(['mobile.auth']);
    Route::post('/getSchool','ForumController@getSchool')->middleware(['mobile.auth']);
    Route::get('/forum/schoolfellow/list','ForumController@schoolfellowList')->middleware(['mobile.auth']);
    Route::get('/forum/schoolfellow/member','ForumController@schoolfellow')->middleware(['mobile.auth']);
    Route::post('/forum/schoolfellow/delete','ForumController@schoolfellowDelete')->middleware(['mobile.auth']);
    Route::get('/message','MessageController@index')->middleware(['mobile.auth']);
    Route::post('/leaveMessage','MessageController@leaveMessage')->middleware(['mobile.auth']);
    Route::post('/message/del','MessageController@delMessage')->middleware(['mobile.auth']);
    Route::any('/test','ForumController@test');
});
