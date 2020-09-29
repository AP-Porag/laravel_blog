<?php

use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//Website frontend rout
Route::get('/',function (){
    return view('website.home');
})->name('website');

Route::get('/about',function (){
    return view('website.about');
})->name('about');

Route::get('/category',function (){
    return view('website.category');
})->name('category');

Route::get('/contact',function (){
    return view('website.contact');
})->name('contact');

Route::get('/post',function (){
    return view('website.post');
})->name('post');

//admin panel
Route::get('/admin-home',function (){
    return view('admin.dashboard.index');
})->name('admin');

Route::group(['prefix' => 'admin','middleware' => ['auth']],function (){
    Route::get('/dashboard',function (){
        return view('admin.dashboard.index');
    })->name('dashboard');

    Route::resource('category','CategoryController');
    Route::resource('tag','TagController');
    Route::resource('post','PostController');
});


