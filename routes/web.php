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

/*Auth 
Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
以上 Auth::routes() 語法就包含了底下 登入、登出、註冊、忘記密碼、等幾個Route
*/

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

/*實際post的儲存表單 */
Route::post('posts/store', 'PostsController@store')->name('posts.store');

/*show出指定的公告 id=第幾則 */
Route::get('posts/{id}', 'PostsController@show')->name('posts.show');

/*出現指定要修改的公告 id=第幾則 */
Route::get('posts/{id}', 'PostsController@edit')->name('posts.edit');

/*實際儲存修改的資料 */
Route::patch('posts/{id}', 'PostsController@update')->name('posts.update');

/*刪除指定改的資料 */
Route::delete('posts/{id}', 'PostsController@destory')->name('posts.destory');

/*上傳檔案  */
Route::get('upload', 'Auth\VerificationController@upload')->name('upload');

