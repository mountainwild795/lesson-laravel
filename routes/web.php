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
use App\Entity\Member;

Route::get('/', function () {
    // return view('welcome');
    return view('login');
});


Route::get('/login', 'view\MemberController@toLogin');
Route::get('/register', 'view\MemberController@toRegister');

Route::get('/category', 'view\BookController@toCategory');
Route::get('/product/category_id/{category_id}', 'view\BookController@toProduct');
Route::get('/product/{product_id}', 'view\BookController@toPdtContent');


Route::group(['prefix' => 'service'], function(){
  Route::get('validate_code/create', 'Service\ValidateController@create');
  Route::post('validate_phone/send', 'Service\ValidateController@sendSMS');
  Route::post('register', 'Service\MemberController@register');
  Route::post('login', 'Service\MemberController@login');
  Route::post('validate_email', 'Service\ValidateController@validateEmail');

  Route::get('category/parent_id/{parent_id}', 'Service\BookController@getCategoryByParentId');
});






