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
/******首頁*****/
Route::get('/', 'HomeController@index');
/******討論區總目錄*****/
Route::get('/discussion', 'DiscussionController@index');
Route::get('/personal_discussion', 'DiscussionController@index_personal');

Route::get('/discussion_broad/{id}', 'DiscussionController@show_broad');

/*排行榜*/
Route::get('/rank', 'RankController@index');
/*章節*/
Route::get('/section/{title}/{c_id}/{s_id}','SectionController@show');
Route::get('/section/{title}/{q_id}','QuestionController@show');
/*各種分析頁面*/
Route::get('/caculation', 'HomeController@cal');

Route::group(['middleware' => 'auth'], function()
{
  Route::get('/userpage', 'UserPageController@index');
  Route::get('/personal_discussion', 'UserPageController@show');
  Route::get('/personal_discussion/codeRecord', 'UserPageController@showCode');
  Route::get('/userhw', 'UserHwController@index');
  Route::get('/userhw/{cid}/{id}', 'UserHwController@coderec');
  Route::get('/userhw/handin/{cid}/{id}/{code_id}', 'UserHwController@hand_in');
  Route::post('/userhw/delHw/{id}', 'UserHwController@deleteHW');
  Route::get('/discussion_ask/{id}', 'DiscussionAskController@show_ask');
  Route::get('/discussion_answer/{id}', 'DiscussionAnswerController@show_answer');

});
/********************************/
/***********管理頁面*************/
/*******************************/


/******發問管理*****/
Route::post('admin/discussionask', 'DiscussionAskController@store');
/******回文管理*****/
Route::post('admin/discussionanswer', 'DiscussionAnswerController@store');
/******每章討論區*****/
Route::get('discussion_sec/{id}', 'DiscussionController@show_sec');

/********************************/
/***********管理頁面*************/
/*******************************/

Route::group(['prefix' => 'admin',  'middleware' => 'auth:admin'], function()
{


    /******章管理*******/
    Route::resource('/chapter', 'ChapterController');
    /******節管理*******/
    Route::resource('/section', 'SectionController');
    /******題目管理*****/
    Route::resource('/question', 'QuestionController');


    /******修課名單管理*/
    Route::get('/user_lists/deleteAllUser/{type}/{id}', 'CourseUserListsController@deleteAllUser');
    Route::resource('/user_lists', 'CourseUserListsController');
    /******各班選題管理*/
    Route::get('/select_question/select/{id}', 'AdminSelectQuestionsController@select');
    Route::get('/select_question/showHW/{id}/{qid}', 'AdminSelectQuestionsController@showHomework');
    Route::get('/select_question/downloadHW/{id}', 'AdminSelectQuestionsController@downloadHomework');
    Route::post('/select_question/due_date/store', 'AdminSelectQuestionsController@due_date');
    Route::resource('/select_question', 'AdminSelectQuestionsController');
    /******增加新的user(學生)到修課名單*/
    // Route::post('/import_parse', 'ImportController@parseImport')->name('import_parse');
    Route::post('/import_process', 'ImportController@processImport')->name('import_process');

    /******編輯公告頁面******/
    Route::get('/newsedit/{course_id}', 'NewReportController@index');
    /******公告儲存******/
    Route::post('/newsedit', 'NewReportController@store');
    /******從後台公告頁到編輯頁*****/
    Route::get('/newseditsecond/{id}', 'NewReportController@show');
    /******從編輯頁到後台公告頁*****/
    Route::post('/newseditsecond/{id}', 'NewReportController@edit_fin');
    /******刪除公告*****/
    Route::delete('/news_delete/{id}', 'NewReportController@delete');

    /**管理員註冊*/
    Route::get('/register', 'Auth\AdminRegisterController@showRegistrationForm')->name('admin.register');
    Route::post('/register', 'Auth\AdminRegisterController@register')->name('admin.register.submit');
});



/*使用者(管理員)登入認證部分*/
Route::prefix('admin')->group(function() {
      Route::get('/', 'AdminController@index')->name('admin');
      Route::get('/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
      Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');

    });

/*使用者(學生)登入認證部分*/
Auth::routes();

/******發問頁面*****/

/******Compiler*****/
// Route::get('/compiler', function () {
//     return view('compiler.index');
// });
Route::get('/compiler','CompilerController@index');
Route::get('/compiler/getQuestion/{id}','CompilerController@show');
Route::post('/compiler/sendTest','CompilerController@testCode');
Route::post('/compiler/judgeCode','CompilerController@judgeCode');
Route::post('/compiler/starred/{post}','CompilerController@starred');
Route::post('/compiler/unstarred/{post}','CompilerController@unstarred');
Route::get('/compiler/recommend/{id}','CompilerController@recommend');
Route::get('/compiler/getOldCode/{id}','CompilerController@getOldCode');

/******portal登入*****/
Route::get('/portal/login', 'SocialAccountController@redirect');
Route::get('/portal/callback', 'SocialAccountController@callback');
Route::get('/portal/flush', 'SocialAccountController@session_flush');
