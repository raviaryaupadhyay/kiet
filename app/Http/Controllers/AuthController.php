<?php
namespace kietbook\Http\Controllers;

use Auth;
use DB;
use Illuminate\Http\Request;
use kietbook\Models\User;

class AuthController extends Controller
{
  public function getSignup()
  {
      return view('auth.signup');
  }

  public function postSignup(Request $request)
  {
      $request->validate([
      'email' => 'required|min:8|unique:users|email|max:255',
      'username' => 'required|unique:users|alpha_dash',
      'password' => 'required|min:6',
    ]);
  $OTP =rand(100000,999999);
  $account_mail=$request->input('email');
  User::create([
  'email'=>$account_mail,
  'username'=>$request->input('username'),
  'password'=>bcrypt($request->input('password')),
  'OTP'=>$OTP,
  ]);
  mail($account_mail,"OTP for KIETBOOK",$OTP);

  return redirect()
  ->route('auth.OTPConfirm')
  ->with('info','Confirm your OTP');
  }

  public function getOTPConfirm()
  {
    return view('auth.OTPConfirm');
  }

  public function postOTPConfirm(Request $request)
  {
    $request->validate([
    'email' => 'required|min:8|email|max:255',
    'OTP'=>'required|max:6|min:6',
    ]);
    $OTP=DB::table('users')->where('email',$request->input('email'))->pluck('OTP');
    if($OTP[0]!=$request->input('OTP'))
    {
      return redirect()->back()->with('info','Could not signup!!! Either your OTP wrong or you does not create account');
    }
    DB::table('users')->where('email',$request->input('email'))->update([
    'OTP'=>0,
    ]);
    return redirect()->route('home')->with('info','Now you can loged In.');
  }


  public function getOTP()
  {
    return view('auth.OTP');
  }


  public function postOTP(Request $request)
  {
    $request->validate([
    'email' => 'required|min:8|email|max:255',
    'OTP'=>'required|max:6|min:6',
    'password'=>'required|min:6',
    'repassword'=>'required',
    ]);
    $OTP=DB::table('users')->where('email',$request->input('email'))->pluck('OTP');
    if($OTP[0]!=$request->input('OTP'))
    {
      return redirect()->back()->with('info','Could not signup!!! Either your OTP wrong or you does not create account');
    }
    if($request->input('password')===$request->input('repassword'))
    {
    DB::table('users')->where('email',$request->input('email'))->update([
    'password'=>bcrypt($request->input('password')),
    'OTP'=>0,
    ]);
    return redirect()->route('home')->with('info','Now you can loged In.');
    }
  }


  public function getSignin()
  {
    return view('auth.signin');
  }

  public function postSignin(Request $request)
  {
    $request->validate([
    'email' => 'required',
    'password' => 'required',
    ]);

    $Count=DB::table('users')->where('email',$request->input('email'))->Count();
    if($Count==1)
    {
      $OTP=DB::table('users')->where('email',$request->input('email'))->pluck('OTP');
      if($OTP[0]!=0)
      {
        return redirect()->route('auth.OTPConfirm')->with('info','Could not sign in with those details please confirm your OTP ');
      }
      if(!Auth:: attempt($request->only(['email','password']),$request->has('remember')))
      {
        return redirect()->back()->with('info','Could not sign in with those details');
      }
      return redirect()->route('home')->with('info','You are loged In.');
    }
    return redirect()->back()->with('info','Plese enter a valid email');
  }

  public function getSignout()
  {
    Auth::logout();
    return redirect()->route('home');
  }

  public function getForget()
  {
    return view('auth.forget');
  }

  public function postForget(Request $request)
  {
    $request->validate([
    'email' => 'required',
    ]);
    $OTP=DB::table('users')->where('email',$request->input('email'))->Count();
    if($OTP==1)
    {
      $OTP =rand(100000,999999);
      $account_mail=$request->input('email');
      DB::table('users')->where('email',$request->input('email'))->update([
        'OTP'=>$OTP,
      ]);
      mail($account_mail,"OTP for KIETBOOK",$OTP);
      return redirect()->route('auth.OTP')->with('info','Plese confirm your OTP');
    }
  return  redirect()->back()->with('info','Invalid Email');
  }
 }
