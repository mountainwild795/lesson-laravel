<?php

namespace App\Http\Controllers\view;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Entity\CartItem;

use App\Entity\Product;
use App\Entity\Member;

use Log;


class CartController extends Controller
{
  public function toCart(Request $request)
  { 
    // $member = session('member');
    // return $member->toJson();
    // $member = $_SESSION['member'];
    // return $member->toJson();
    $cart_items = array();
    $bk_cart = $request->cookie('bk_cart');
    $bk_cart_arr = ($bk_cart!=null ? explode(',', $bk_cart) : array());
    // if($request->session()->has('member'));
    $member = $request->session()->get('member', '');
    if($member == '') {
    // if($member != '') {
      $member = Member::find(1);//fake data by cm
      $cart_items = $this->syncCart($member->id, $bk_cart_arr);
      return response()->view('cart', ['cart_items' => $cart_items])->withCookie('bk_cart', null);
    }

    foreach ($bk_cart_arr as $key => $value) {
      $index = strpos($value, ':');
      $cart_item = new CartItem;
      $cart_item->id = $key;
      $cart_item->product_id = substr($value, 0, $index);
      $cart_item->count = (int) substr($value, $index+1);
      $cart_item->product = Product::find($cart_item->product_id);
      if($cart_item->product != null) {
        array_push($cart_items, $cart_item);
      }
    }

    return view('cart')->with('cart_items', $cart_items);
  }

  private function syncCart($member_id, $bk_cart_arr)
  {
    $cart_items = CartItem::where('member_id', $member_id)->get();

    $cart_items_arr = array();
    foreach ($bk_cart_arr as $value) {
      $index = strpos($value, ':');
      $product_id = substr($value, 0, $index);
      $count = (int) substr($value, $index+1);

      // 判断离线购物车中product_id 是否存在 数据库中
      $exist = false;
      foreach ($cart_items as $temp) {
        if($temp->product_id == $product_id) {
          if($temp->count < $count) {
            $temp->count = $count;
            $temp->save();
          }
          $exist = true;
          break;
        }
      }

      // 不存在则存储进来
      if($exist == false) {
        $cart_item = new CartItem;
        $cart_item->member_id = $member_id;
        $cart_item->product_id = $product_id;
        $cart_item->count = $count;
        $cart_item->save();
        $cart_item->product = Product::find($cart_item->product_id);
        array_push($cart_items_arr, $cart_item);
      }
    }

    // 为每个对象附加产品对象便于显示
    foreach ($cart_items as $cart_item) {
      $cart_item->product = Product::find($cart_item->product_id);
      array_push($cart_items_arr, $cart_item);
    }

    return $cart_items_arr;
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
