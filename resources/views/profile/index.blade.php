@extends('templates.default')

@section('content')

<div class="row">
  <div class="col-lg-5">
    @include('user.partials.userblock')
    <hr>

    @if(!$statuses->count())
      <p>{{ $user->getFirstNameOrUsername() }} hasn't posted status yet. </p>
    @else
      @foreach($statuses as $status)
       <div class="media">
         <a class="pull-left" href="{{ route('profile.index',['username'=>$status->user->username]) }}">
           <img class="media-object" src="{{ $status->user->getAvatarUrl() }}" alt="{{ $status->user->getNameOrUsername() }}">
         </a>
         <div class="media-body">
           <h4 class="media-heading"><a href="{{ route('profile.index',['username'=>$status->user->username]) }}">{{ $status->user->getNameOrUsername() }}</a></h4>
           <p>{{ $status->body }}</p>
           <ul class="list-inline">
             <li>{{ $status->created_at->diffForHumans() }} </li>
             @if($status->user->id !== Auth::user()->id)
               <li><a href="{{ route('status.like',['statusId'=>$status->id]) }}">Like</a></li>
             @endif
              <li>{{ $status->likes->count() }} {{ str_plural('like', $status->likes->count())}}</li>
           </ul>

        @foreach ($status->replies as $reply)
        <div class="media">
             <a class="pull-left" href="{{ route('profile.index',['username'=>$reply->user->username]) }}">
               <img class="media-object" src="{{ $status->user->getAvatarUrl() }}" alt="{{ $status->user->getNameOrUsername() }}" >
             </a>
             <div class="media-body">
               <h6 class="media-heading"><a href="{{ route('profile.index',['username'=>$reply->user->username]) }}">{{ $reply->user->getNameOrUsername() }}</a></h6>
               <p>{{ $reply->body }}</p>
               <ul class="list-inline">
                 <li> {{ $reply->created_at->diffForHumans() }}</li>
                 @if($reply->user->id !== Auth::user()->id)
                   <li><a href="{{ route('status.like',['statusId'=>$reply->id]) }}">Like</a></li>
                 @endif
                  <li>{{ $reply->likes->count() }} {{ str_plural('like', $reply->likes->count())}}</li>
               </ul>
             </div>
           </div>
           @endforeach

           @if($authUserIsFriend || Auth::user()->id===$status->user->id )
             <form class="form-vertical"  role="form" method="post" action="{{ route('status.reply',['statusId'=>$status->id]) }}">
               <div class="form-group{{ $errors->has("reply-{$status->id}") ? ' has-error' : '' }}">
                 <textarea placeholder="reply to the status" type="text" name="reply-{{ $status->id }}" class="form-control" rows="2" value=""></textarea>
                 @if($errors->has("reply-{$status->id}" ))
                  <span class="help-block">{{ $errors->first("reply-{$status->id}") }}</span>
                 @endif
               </div>
               <button type="submit" class="btn btn-default">Reply</button>
               <input type="hidden" name="_token" value="{{ Session::token() }}">
             </form>
           @endif
         </div>
       </div>
      @endforeach
    @endif
  </div>

  <div class="col-lg-4 col-lg-offset-3">
    @if (Auth::user()->hasFriendRequestsPending($user))
    <p> waiting for {{ $user->getNameOrUsername() }} to accept your request.</p>

    @elseif (Auth::user()->hasFriendRequestsRecived($user))
      <a href="{{ route('friend.accept',['username'=>$user->username]) }}" class="btn btn-primary">Accept friend request</a>

    @elseif (Auth::user()->isFriendWith($user))
      <p>You and {{ $user->getNameOrUsername() }} are friends</p>

        <form action="{{ route('friend.delete',['username'=>$user->username]) }}" method="get">
          <input type="submit" value="Delete Friend" class="btn btn-primary">
          <input type="hidden" name="_token" value="{{ csrf_token() }}"
        </form>

    @elseif( Auth::user()->id==$user->id)

    @else
      <a href="{{ route('friend.add',['username'=>$user->username]) }}" class="btn btn-primary">Add as friend</a>
    @endif


    <h4>{{ $user->getFirstNameOrUsername() }}'s friends</h4>

    @if (!$user->friends()->count())
    <p> {{ $user->getFirstNameOrUsername() }} has no Friends</p>
    @else
      @foreach ($user->friends() as $user)
        @include('user/partials/userblock')
      @endforeach
    @endif
  </div>
</div>

@stop
