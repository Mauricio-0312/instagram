<?php

use Illuminate\Support\Facades\Route;
use App\Models\Image;



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

Route::get('/', function () {

    $images = Image::all();
    foreach($images as $image){
        echo $image->description."     ";
        echo $image->user->name."<br>";
        echo count($image->user->images)."<br>";


    }
    die();
    return view('welcome');
});


Auth::routes();

//User
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/config', 'UserController@config')->name("config");
Route::post('/updateUser', 'UserController@updateUser')->name("updateUser");
Route::get('user/getImage/{filename}', 'UserController@getImage')->name("user.profileImage");
Route::get('/profile/{user_id}', 'UserController@profile')->name("user.profile");
Route::get('/people/{search?}', 'UserController@people')->name("people");


//Image
Route::get('postImage', 'ImageController@create')->name("postImage");
Route::post('/savePost', 'ImageController@save')->name("savePost");
Route::get('/test', 'ImageController@getImages')->name("images");
Route::get('getImage/{filename}', 'ImageController@getImage')->name("image");
Route::get('detail/{id}', 'ImageController@detail')->name("image.detail");
Route::get('/deletePost/{id}', 'ImageController@delete')->name("post.delete");
Route::get('/image/updatePage/{id}', 'ImageController@edit')->name("post.updatePage");
Route::post('/image/edit/{id}', 'ImageController@editAndSave')->name("post.edit");


//Comment
Route::post('/postComment', 'CommentController@store')->name("postComment");
Route::get('/deleteComment/{id}', 'CommentController@delete')->name("deleteComment");


//Like
Route::get('/like/{image_id}', 'LikeController@like')->name("like");
Route::get('/dislike/{image_id}', 'LikeController@dislike')->name("dislike");
Route::get('/favoritePosts', 'LikeController@index')->name("favoritePosts");







