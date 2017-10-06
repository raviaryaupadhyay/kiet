<?php
namespace kietbook\Http\Controllers;

use Illuminate\Http\Request;
use kietbook\Models\User;
use Auth;

class ProfileController extends Controller
{
    public function getProfile($username)
    {
      $user = User::where('username',$username)->first();

      if(!$user){
        abort(404);
      }

      $statuses = $user->statuses()->notReply()->get();

      return view('profile.index')
      ->with('user',$user)
      ->with('statuses',$statuses)
      ->with('authUserIsFriend',Auth::user()->isFriendWith($user));
    }

    public function getEdit()
    {
      return view('profile.edit');
    }
    public function postEdit(Request $request)
    {
      $request->validate([
        'first_name' => 'alpha|max:50',
        'last_name' => 'alpha|max:50',
        'location'=>'max:20',
      ]);

      Auth::user()->update([
        'first_name'=>$request->input('first_name'),
        'last_name'=>$request->input('last_name'),
        'location'=>$request->input('location'),
      ]);

      return redirect()
      ->route('profile.edit')
      ->with('info','Your profile updated');
    }

    public function getRePassword()
    {
        return view('profile.rePassword');
    }
    public function postRePassword(Request $request)
    {
      $request->validate([
        'password' => 'required|min:6',
        'repassword' => 'required|min:6',
      ]);
      $password=$request->input('password');
      $rePassword=$request->input('repassword');
      if($password===$rePassword)
      {
      Auth::user()->update([
        'password'=>bcrypt($request->input('password')),
        ]);
        return redirect()->route('home')->with('info','You are loged In.');
      }
      return view('profile.rePassword');

    }
}
