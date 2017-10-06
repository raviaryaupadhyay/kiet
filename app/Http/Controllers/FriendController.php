<?php
namespace kietbook\Http\Controllers;

use Illuminate\Http\Request;
use kietbook\Models\User;
use Auth;

class FriendController extends Controller
{
    public function getIndex()
    {
      $friends= Auth::user()->friends();
      $requests= Auth::user()->friendRequests();

      return view('friends.index')
      ->with('friends',$friends)
      ->with('requests',$requests);
    }

    public function getAdd($username)
    {
      $user = User::where('username',$username)->first();
      if(!$user)
      {
        return redirect()
        ->route('home')
        ->with('info','That user could not be found');
      }
      if( Auth::user()->id===$user->id)
      {
        return redirect()->route('home');
      }
      if(Auth::user()->hasFriendRequestsPending($user)||$user->hasFriendRequestsPending(Auth::user()))
      {
        return redirect()
        ->route('profile.index',['username'=>$user->username])
        ->with('info','Friend request already panding.');
      }

      if(Auth::user()->isFriendWith($user))
      {
        return redirect()
        ->route('profile.index',['username'=>$user->username])
        ->with('info',' You are already friends.');
      }

      Auth::user()->addFriend($user);

      return redirect()
      ->route('profile.index',['username'=>$username])
      ->with('info',' Friend Request sent');
    }

    public function getAccept($username)
    {
      $user = User::where('username',$username)->first();
      if(!$user)
      {
        return redirect()
        ->route('home')
        ->with('info','That user could not be found');
      }
      if ( !Auth::user()->hasFriendRequestsRecived($user))
      {
        return redirect()->route('home');
      }
        Auth::user()->acceptFriendRequest($user);
        return redirect()
        ->route('profile.index',['username'=>$username])
        ->with('info',' Friend Request accepted');
    }

    public function getDelete($username)
    {
      $user = User::where('username',$username)->first();
      if(!Auth::user()->isFriendWith($user))
      {
        return redirect()->back();
      }
      Auth::user()->deleteFriend($user);
      return redirect()->back()->with('info','Friend deleted');
    }
}
