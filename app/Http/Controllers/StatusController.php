<?php
namespace kietbook\Http\Controllers;

use Auth;
use DB;
use kietbook\Models\Like;
use Illuminate\Http\Request;
use kietbook\Models\User;
use kietbook\Models\Status;

class StatusController extends Controller
{
    public function postStatus(Request $request)
    {
      $request->validate([
        'status'=>'required|max:1000',
      ]);

      Auth::user()->statuses()->create([
        'body'=>$request->input('status'),
      ]);

      return redirect()
      ->route('home')
      ->with('info','Status Posted');
    }

    public function postReply(Request $request, $statusId)
    {
      $request->validate([
        "reply-{$statusId}"=>'required|max:1000',
      ],[
        'required'=>'The reply Body is required'
      ]);

      $status=Status::notReply()->find($statusId);

      if(!$status){
        return redirect()->route('home');
      }

      if(!Auth::user()->isFriendWith($status->user)&& Auth::user()->id!==$status->user->id)
      {
        return redirect()->route('home');
      }
      $reply=Status::create([
        'user_id'=>Auth::user()->id,
      'body'=>$request->input("reply-{$statusId}"),
      ])->user()->associate(Auth::user());

      $status->replies()->save($reply);

      return redirect()->back();
    }


    public function getLike($statusId)
    {
      #dd($statusId);
      $status = Status::find($statusId);
      if(!$status)
      {
        return redirect()->route('home');
      }
      if(!Auth::user()->isFriendWith($status->user))
      {
        return redirect()->route('home');;
      }

      if(Auth::user()->hasLikedStatus($status))
      {
        return redirect()->back();
      }
      Like::create([
        'user_id'=>Auth::user()->id,
        'likeable_id'=>$status->id,
        'likeable_type'=>get_class($status),
      ]);
      return redirect()->back();
    }
}
