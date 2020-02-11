<?php

namespace App\Http\Controllers\service;
use App\Tool\Validate\ValidateCode;
use App\Http\Controllers\Controller;
use App\Models\M3Result;

use Illuminate\Http\Request;

use App\Entity\Category;
use App\Entity\Product;
use App\Entity\CartItem;


class CartController extends Controller
{
  public function addCart(Request $request, $product_id)
  {
    $m3_result = new M3Result;
    $m3_result->status = 0;
    $m3_result->message = '添加成功';

    // 如果当前已经登录
    $member = $request->session()->get('member', '');
    if($member != '') {
      $cart_items = CartItem::where('member_id', $member->id)->get();

      $exist = false;
      foreach ($cart_items as $cart_item) {
        if($cart_item->product_id == $product_id) {
          $cart_item->count ++;
          $cart_item->save();
          $exist = true;
          break;
        }
      }

      if($exist == false) {
        $cart_item = new CartItem;
        $cart_item->product_id = $product_id;
        $cart_item->count = 1;
        $cart_item->member_id = $member->id;
        $cart_item->save();
      }

      return $m3_result->toJson();
    }

    $bk_cart = $request->cookie('bk_cart');
    // return $bk_cart;
    $bk_cart_arr = ($bk_cart!=null ? explode(',', $bk_cart) : array());

    $count = 1;
    foreach ($bk_cart_arr as &$value) {   // 一定要传引用
      $index = strpos($value, ':');
      if(substr($value, 0, $index) == $product_id) {
        // $count = Number(substr($value, $index+1)) + 1;
        $count = ((int) substr($value, $index+1)) + 1;
        $value = $product_id . ':' . $count;
        // break;
      }
    }

    if($count == 1) {
      array_push($bk_cart_arr, $product_id . ':' . $count);
    }

    return response($m3_result->toJson())->withCookie('bk_cart', implode(',', $bk_cart_arr));
  }


  public function deleteCart(Request $request)
  {
    $m3_result = new M3Result;
    $m3_result->status = 0;
    $m3_result->message = '删除成功';

    $product_ids = $request->input('product_ids', '');
    if($product_ids == '') {
      $m3_result->status = 1;
      $m3_result->message = '书籍ID为空';
      return $m3_result->toJson();
    }
    $product_ids_arr = explode(',', $product_ids);

    $member = $request->session()->get('member', '');
    if($member != '') {
        // 已登录
        CartItem::whereIn('product_id', $product_ids_arr)->delete();
        return $m3_result->toJson();
    }

    $product_ids = $request->input('product_ids', '');
    if($product_ids == '') {
      $m3_result->status = 1;
      $m3_result->message = '书籍ID为空';
      return $m3_result->toJson();
    }

    // 未登录
    $bk_cart = $request->cookie('bk_cart');
    $bk_cart_arr = ($bk_cart!=null ? explode(',', $bk_cart) : array());
    foreach ($bk_cart_arr as $key => $value) {
      $index = strpos($value, ':');
      $product_id = substr($value, 0, $index);
      // 存在, 删除
      if(in_array($product_id, $product_ids_arr)) {
        array_splice($bk_cart_arr, $key, 1);
        continue;
      }
    }
    return response($m3_result->toJson())->withCookie('bk_cart', implode(',', $bk_cart_arr));
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
