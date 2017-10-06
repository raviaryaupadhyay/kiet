<?php
namespace kietbook\Http\Controllers;

use DB;
use Auth;
use kietbook\Models\Status;
use kietbook\Models\User;

class HomeController extends Controller
{
  public function postChat($username)
  {
    $user = User::where('username',$username)->first();

    if(!$user){
      abort(404);
    }

    $message = $user->messages()->notReply()->get();

    return view('profile.index')
    ->with('user',$user)
    ->with('statuses',$statuses)
    ->with('authUserIsFriend',Auth::user()->isFriendWith($user));
  }
}
