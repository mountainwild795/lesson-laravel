<?php

namespace App\Http\Controllers\service;
use App\Tool\Validate\ValidateCode;
use App\Http\Controllers\Controller;
use App\Models\M3Result;

use App\Entity\Category;


class BookController extends Controller
{
    public function getCategoryByParentId($parent_id){

      $categories = Category::where('parent_id', $parent_id)->get();
      $m3_result = new M3Result;
      $m3_result->status = 0;
      $m3_result->message = '返回成功';
      $m3_result->categories = $categories;
      return $m3_result->toJson();

      // return $categories;
    }
 
    // /*
    // |--------------------------------------------------------------------------
    // | Register Controller
    // |--------------------------------------------------------------------------
    // |
    // | This controller handles the registration of new users as well as their
    // | validation and creation. By default this controller uses a trait to
    // | provide this functionality without requiring any additional code.
    // |
    // */

    // use RegistersUsers;

    // /**
    //  * Where to redirect users after registration.
    //  *
    //  * @var string
    //  */
    // protected $redirectTo = RouteServiceProvider::HOME;

    // /**
    //  * Create a new controller instance.
    //  *
    //  * @return void
    //  */
    // public function __construct()
    // {
    //     $this->middleware('guest');
    // }

    // /**
    //  * Get a validator for an incoming registration request.
    //  *
    //  * @param  array  $data
    //  * @return \Illuminate\Contracts\Validation\Validator
    //  */
    // protected function validator(array $data)
    // {
    //     return Validator::make($data, [
    //         'name' => ['required', 'string', 'max:255'],
    //         'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
    //         'password' => ['required', 'string', 'min:8', 'confirmed'],
    //     ]);
    // }

    // /**
    //  * Create a new user instance after a valid registration.
    //  *
    //  * @param  array  $data
    //  * @return \App\User
    //  */
    // protected function create(array $data)
    // {
    //     return User::create([
    //         'name' => $data['name'],
    //         'email' => $data['email'],
    //         'password' => Hash::make($data['password']),
    //     ]);
    // }
}
