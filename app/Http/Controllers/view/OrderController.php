<?php

namespace App\Http\Controllers\view;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Entity\CartItem;

use App\Entity\Product;
use App\Entity\Member;

use App\Entity\Order;
use App\Entity\OrderItem;

use Log;


class OrderController extends Controller
{
  public function toOrderCommit(Request $request)
  {
    $product_ids = $request->input('product_ids', '');
    // return $product_ids;
    $product_ids_arr = ($product_ids!='' ? explode(',', $product_ids) : array());
    $product_ids_arr = ['1', '3', '4'];
    // return $product_ids_arr;

    $member = Member::find(1);//fake data by cm
    // return $member;
    // $member = $request->session()->get('member', '');
    $cart_items = CartItem::where('member_id', $member->id)->whereIn('product_id', $product_ids_arr)->get();
    // return $cart_items;
    $order = new Order;
    $order->member_id = $member->id;
    $order->save();

    $cart_items_arr = array();
    $cart_items_ids_arr = array();
    $total_price = 0;
    $name = '';
    foreach($cart_items as $cart_item){
      // $cart_item->product = Product::where('product_id', $cart_item->product_id)->get();
      $cart_item->product = Product::find($cart_item->product_id);
      if($cart_item->product != null){
        $total_price += (int)$cart_item->product->price * (int)$cart_item->count; //may not need (int)
        $name .= ('《'.$cart_item->product->name.'》');
        array_push($cart_items_arr, $cart_item);
        array_push($cart_items_ids_arr, $cart_item->id);

        $order_item = new OrderItem;
        $order_item->order_id = $order->id;
        $order_item->product_id = $cart_item->product_id;
        $order_item->count = $cart_item->count;
        // $order_item->pdt_snapshot = json_encode($cart_item->product);
        $order_item->pdt_snapshot = $cart_item->product->toJson();
        // return $cart_item->product;
        // return $cart_item->product->toJson();
        // return json_decode($order_item->pdt_snapshot)->id;
        // return $order_item;
        $order_item->save();
      }
    }

    CartItem::whereIn('id', $cart_items_ids_arr)->delete();

    $order->name = $name;
    $order->total_price = $total_price;
    $order->order_no = 'E'.time().''.$order->id;
    $order->save();
    
    return view('order_commit')->with('cart_items', $cart_items_arr)
                               ->with('total_price', $total_price)
                               ->with('name', $name)
                               ->with('order_no', $order->order_no);
  }


  public function toOrderList(Request $request)
  {
    // $member = $request->session()->get('member', '');

    $member = Member::find(1);//fake data by cm
    $orders = Order::where('member_id', $member->id)->get();
    foreach ($orders as $order) {
      $order_items = OrderItem::where('order_id', $order->id)->get();
      $order->order_items = $order_items;
      foreach ($order_items as $order_item) {
        $order_item->product = Product::find($order_item->product_id);
        // $order_item->product = json_decode($order_item->pdt_snapshot);
      }
    }
    // return $orders;
    return view('order_list')->with('orders', $orders);
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
