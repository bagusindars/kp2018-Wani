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


	
Auth::routes();
Route::group(['middleware' => 'auth'],function(){
	Route::resource('posts','PostController',['except' => ['index','show']]);


	Route::get('/managetag','profilecontroller@lihattag');
	Route::delete('/managetag/{id}','profilecontroller@hapustag');
	Route::get('/managetag/{id}/edit','profilecontroller@showtag');
	Route::post('/managetag/{id}/edit','profilecontroller@edittag');
	Route::post('/admindashboard','profilecontroller@createtag');

	Route::get('/manageuser','profilecontroller@manageuserbyadmin');
	Route::delete('/manageuser/{id}','profilecontroller@manageuserdeletebyadmin');
	Route::get('/managepost','PostController@managepostbyadmin');
	Route::delete('/managepost/{id}','PostController@managepostdeletebyadmin');


	Route::get('/confirmationpost', 'PostController@confirmationpost');
	Route::get('/confirmationuser', 'profilecontroller@confirmationuser');
	Route::put('/confirmationuser/{id}', 'profilecontroller@confirmationuserconfirm');
	Route::put('/confirmationpost/{id}', 'PostController@confirmationpostconfirm');
	Route::delete('/confirmationuser/{id}', 'profilecontroller@manageuserdeletebyadmin');
	Route::delete('/confirmationpost/{id}', 'PostController@managepostdeletebyadmin');

	Route::post('posts-comment/{id}','PostCommentController@store');
	Route::put('posts-comment/{id}','PostCommentController@update');
	Route::get('posts-comment/{id}/edit','PostCommentController@edit');
	Route::delete('posts-comment/{id}','PostCommentController@destroy');
	Route::get('/like/{type}/{model}','LikeController@like');
	Route::get('/unlike/{type}/{model}','LikeController@unlike');
	Route::get('notifications','HomeController@get_notif');
	Route::delete('notifications/{id}','HomeController@delete_notif');
});
// Route::get('/', 'PostController@halamanawal');
Route::get('/',function(){
	return redirect('/posts');
});
// Route::get('/home', 'HomeController@index')->name('home');
	
Route::get('/profile/{id?}','profilecontroller@profile');
Route::get('/admindashboard','profilecontroller@admin');
Route::put('/profile/{id?}','profilecontroller@update');
Route::get('/profile/{id}/edit','profilecontroller@profileedit');
Route::get('/posts/all','PostController@allpost');
Route::get('/posts/all/{id}','PostController@allposttype');

Route::get('/search','PostController@search');

Route::get('posts/filter/{tag}','PostController@filtershow');
Route::resource('posts','PostController',['only' =>[ 'index','show']]);



