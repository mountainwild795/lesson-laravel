<?php

namespace App\Http\Controllers\view;
use App\Tool\Validate\ValidateCode;
use App\Http\Controllers\Controller;

use App\Entity\Category;
use App\Entity\Product;
use App\Entity\PdtContent;

class BookController extends Controller
{
    public function toCategory($value=''){

      $categories = Category::whereNull('parent_id')->get();
      return view('category')->with('categories', $categories);
    }

    public function toProduct($category_id){

      $products = Product::where('category_id', $category_id)->get();
      return view('product')->with('products', $products);
    }

    public function toPdtContent($product_id){
      $product = Product::find($product_id);
      // $product = Product::where('product_id', $product_id)->get();
      $pdt_content = PdtContent::where('product_id', $product_id)->first();
      return view('pdt_content')->with('product', $product)
                               ->with('pdt_content', $pdt_content);
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
