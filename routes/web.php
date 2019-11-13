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

/*首頁 */
Route::get('/', function () {
    return view('index');
})->name('index');

/*TestsController */
//Route::get('foo', 'TestsController@index');

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
//Route::post('export_xls','ExcelController@export_xls')->name('export_xls'); //20191031註記不使用
//展場庫存匯出
Route::post('pos_inv_export','ExcelController@pos_inv_export')->name('pos_inv_export');
//銷貨對帳單匯出
Route::post('fin_ship_export','ExcelController@fin_ship_export')->name('fin_ship_export');
//製令工時匯出
Route::post('WorkingTimeExport','ExcelController@WorkingTimeExport')->name('WorkingTimeExport');
//結帳前&後明細匯出
Route::get('fin_b4_export/{fin_chk}','ExcelController@fin_b4_export')->name('fin_b4_export');
Route::post('fin_af_export','ExcelController@fin_af_export')->name('fin_af_export');

//檢查MS SQL連線結果
//Route::get('dbresult', 'Auth\VerificationController@dbresult')->name('auth.dbresult');

// Search Route
Route::get('searchs', 'SearchsController@index')->name('searchs.index'); //查詢List
//進貨查詢 & 賢齊進退貨查詢
Route::get('searchs/search1', 'SearchsController@search1')->name('searchs.search1');
//展場庫存查詢
Route::get('searchs/search2', 'SearchsController@search2')->name('searchs.search2');
//Route::get('searchs/search3', 'SearchsController@search3')->name('searchs.search3');
//Route::get('searchs/search4', 'SearchsController@search4')->name('searchs.search4');
Route::post('searchs/store', 'SearchsController@store')->name('searchs.store');
Route::post('searchs/result01', 'SearchsController@result01')->name('searchs.result01');
Route::post('searchs/purth_result', 'SearchsController@purth_result')->name('searchs.purth_result');
Route::post('searchs/pos_inv', 'SearchsController@pos_inv')->name('searchs.pos_inv');
Route::post('searchs/pos_stocks', 'SearchsController@pos_stocks')->name('searchs.pos_stocks');
Route::post('searchs/WorkingTime', 'SearchsController@WorkingTime')->name('searchs.WorkingTime');


//UserProfileEdit
/*顯示使用者清單 */
Route::get('UsersProfile', 'UsersProfileController@UsersIndex')->name('UsersProfile.UsersIndex');
/*修改使用者資料 */
Route::get('UsersProfile/{username}/UsersEdit', 'UsersProfileController@UsersEdit')->name('UsersProfile.UsersEdit');
Route::get('UsersProfile/{username}/UsersResetPWD', 'UsersProfileController@UsersResetPWD')->name('UsersProfile.UsersResetPWD');
Route::patch('UsersProfile/{username}', 'UsersProfileController@UsersUpdate')->name('UsersProfile.UsersUpdate');
Route::patch('UsersProfile/reset/{username}', 'UsersProfileController@UsersResetPassword')->name('UsersProfile.UsersResetPassword');
Route::delete('UsersProfile/{username}', 'UsersProfileController@destroy')->name('UsersProfile.destroy');

/* Finance 財務查詢&結算檢查 */
//銷貨對帳單查詢
Route::get('finance/fsearch1', 'FinanceController@fsearch1')->name('finance.fsearch1');
Route::post('finance/fin_ship', 'FinanceController@fin_ship')->name('finance.fin_ship');
//結帳前檢查輸入畫面
Route::get('finance/fsearch2', 'FinanceController@fsearch2')->name('finance.fsearch2');
Route::post('finance/fin_b4check', 'FinanceController@fin_b4check')->name('finance.fin_b4check');
Route::post('finance/fin_afcheck', 'FinanceController@fin_afcheck')->name('finance.fin_afcheck');
//Tab test
Route::post('finance/fin_b4chk', 'FinanceController@fin_b4chk')->name('finance.fin_b4chk');
Route::post('finance/fin_afchk', 'FinanceController@fin_afchk')->name('finance.fin_afchk');

//SalesController 業務用
Route::get('sales/ts6index', 'SalesController@ts6index')->name('sales.ts6index');
Route::post('sales/ts6members', 'SalesController@ts6members')->name('sales.ts6members');
Route::post('sales/orderscount', 'SalesController@orderscount')->name('sales.orderscount');
Route::post('sales/amountover', 'SalesController@amountover')->name('sales.amountover');
Route::post('sales/itemscount', 'SalesController@itemscount')->name('sales.itemscount');
Route::post('sales/ts6detail', 'SalesController@ts6detail')->name('sales.ts6detail');
Route::get('sales/{email}', 'SalesController@ts6byemail')->name('sales.ts6byemail');
Route::post('sales/ts6noorder', 'SalesController@ts6noorder')->name('sales.ts6noorder');

//ts6export會員資料匯出
Route::get('ts6export/{sqlstr}/ts6members_export', 'TS6ExportController@ts6members_export')->name('ts6members_export');
Route::get('ts6counts_export', 'TS6ExportController@ts6counts_export')->name('ts6counts_export');
Route::get('ts6amounts_export', 'TS6ExportController@ts6amounts_export')->name('ts6amounts_export');
Route::get('ts6items_export', 'TS6ExportController@ts6items_export')->name('ts6items_export');
Route::get('ts6export/{mem_email}/ts6detail_export', 'TS6ExportController@ts6detail_export')->name('ts6detail_export');
Route::get('ts6export/ts6noorder_export', 'TS6ExportController@ts6noorder_export')->name('ts6noorder_export');
