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

/*Default */
Route::get('/home', function () {
    return view('home');
});

//Auth 
Auth::routes();
//Route::get('/home', 'HomeController@index')->name('home');
//以上 Auth::routes() 語法就包含了底下 登入、登出、註冊、忘記密碼、等幾個Route


#登入
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
#登出
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

#註冊
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register')->name('register.post');

#忘記密碼
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');

/*測試首頁 */
Route::get('/', function () {
    return view('index');
})->name('index');

/*TestsController */
Route::get('foo', 'TestsController@index');

/*取得PostsController後續頁面Route與Controller搭配 --此例為公告列表*/
Route::get('posts', 'PostsController@index')->name('posts.index');
/*出現公告新增的表單 */
Route::get('posts/create', 'PostsController@create')->name('posts.create');
/*出現指定要修改的公告 id=第幾則 */
Route::get('posts/{id}/edit', 'PostsController@edit')->name('posts.edit');
/*show出指定的公告 id=第幾則 */
Route::get('posts/{id}', 'PostsController@show')->name('posts.show');
/*實際post的儲存表單 */
Route::post('posts/store', 'PostsController@store')->name('posts.store');
/*實際儲存修改的資料 */
Route::patch('posts/{id}', 'PostsController@update')->name('posts.update');
/*刪除指定改的資料 */
Route::delete('posts/{id}', 'PostsController@destroy')->name('posts.destroy');

/*
//上傳檔案
Route::get('upload', 'Auth\VerificationController@upload')->name('upload');
//匯出頁面
Route::get('export', 'Auth\VerificationController@export')->name('export');
//匯出Excel 測試
Route::get('outputexcel', 'Auth\VerificationController@outputexcel')->name('outputexcel');
Route::get('excel', 'Auth\VerificationController@excel')->name('excel');
*/

//Laravel Excel 
Route::get('userexport','ExcelController@userexport')->name('userexport');
Route::post('userimport','ExcelController@userimport')->name('userimport');
Route::get('AllUserExport','ExcelController@AllUserExport')->name('AllUserExport');
Route::post('export_xls','ExcelController@export_xls')->name('export_xls');
Route::post('pos_inv_export','ExcelController@pos_inv_export')->name('pos_inv_export');
Route::post('ship_data_export','ExcelController@ship_data_export')->name('ship_data_export');
Route::post('WorkingTimeExport','ExcelController@WorkingTimeExport')->name('WorkingTimeExport');

//檢查MS SQL連線結果
Route::get('dbresult', 'Auth\VerificationController@dbresult')->name('auth.dbresult');
//Route::post('auth/test', 'Auth\VerificationController@test')->name('auth.test');

// Search Route
Route::get('searchs', 'SearchsController@index')->name('searchs.index');
Route::get('searchs/search1', 'SearchsController@search1')->name('searchs.search1');
Route::get('searchs/search2', 'SearchsController@search2')->name('searchs.search2');
Route::get('searchs/search3', 'SearchsController@search3')->name('searchs.search3');
//Route::get('searchs/search4', 'SearchsController@search4')->name('searchs.search4');
Route::post('searchs/store', 'SearchsController@store')->name('searchs.store');
Route::post('searchs/result01', 'SearchsController@result01')->name('searchs.result01');
Route::post('searchs/purth_result', 'SearchsController@purth_result')->name('searchs.purth_result');
Route::post('searchs/pos_inv', 'SearchsController@pos_inv')->name('searchs.pos_inv');
Route::post('searchs/ship_data', 'SearchsController@ship_data')->name('searchs.ship_data');
Route::post('searchs/WorkingTime', 'SearchsController@WorkingTime')->name('searchs.WorkingTime');

