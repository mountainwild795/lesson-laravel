<?php

namespace App\Http\Controllers\Service;
use App\Tool\Validate\ValidateCode;
use App\Http\Controllers\Controller;
use App\Tool\SMS\SendTemplateSMS;
use App\Models\M3Result;
use App\Entity\TempPhone;
use Illuminate\Http\Request;
use App\Entity\TempEmail;
use App\Entity\Member;

class ValidateController extends Controller
{
    public function create(Request $request){
      $validateCode = new ValidateCode;
      $request->session()->put('validate_code', $validateCode->getCode());
      return $validateCode->doimg();
    }

    public function sendSMS(){
      $m3_result = new M3Result;

      $phone = $request->input('phone', '');
      if($phone == '') {
        $m3_result->status = 1;
        $m3_result->message = '手机号不能为空';
        return $m3_result->toJson();
      }
      if(strlen($phone) != 11 || $phone[0] != '1') {
        $m3_result->status = 2;
        $m3_result->message = '手机格式不正确';
        return $m3_result->toJson();
      }
  
      $sendTemplateSMS = new SendTemplateSMS;
      $code = '';
      $charset = '1234567890';
      $_len = strlen($charset) - 1;
      for ($i = 0;$i < 6;++$i) {
          $code .= $charset[mt_rand(0, $_len)];
      }
      $m3_result = $sendTemplateSMS->sendTemplateSMS($phone, array($code, 60), 1);
      if($m3_result->status == 0) {
        $tempPhone = TempPhone::where('phone', $phone)->first();
        if($tempPhone == null) {
          $tempPhone = new TempPhone;
        }
        $tempPhone->phone = $phone;
        $tempPhone->code = $code;
        $tempPhone->deadline = date('Y-m-d H-i-s', time() + 60*60);
        $tempPhone->save();
      }
  
      return $m3_result->toJson();
    }

    public function validateEmail(Request $request)
  {
    $member_id = $request->input('member_id', '');
    $code = $request->input('code', '');
    if($member_id == '' || $code == '') {
      return '验证异常';
    }

    $tempEmail = TempEmail::where('member_id', $member_id)->first();
    if($tempEmail == null) {
      return '验证异常';
    }

    if($tempEmail->code == $code) {
      if(time() > strtotime($tempEmail->deadline)) {
        return '该链接已失效';
      }

      $member = Member::find($member_id);
      $member->active = 1;
      $member->save();

      return redirect('/login');
    } else {
      return '该链接已失效';
    }
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
