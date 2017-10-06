@extends('templates.default')

@section('content')
<div class="row">
  <div class="col-lg-6">
    <form class="form-vertical"  role="form" method="post" action="{{ route('status.post') }}">
      <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
        <textarea placeholder="What's up {{ Auth::user()->getFirstNameOrUsername() }} ?"
           type="text" name="status" class="form-control" rows="2" value=""></textarea>
        @if($errors->has('status'))
         <span class="help-block">{{ $errors->first('status') }}</span>
        @endif
      </div>
      <button type="submit" class="btn btn-default">Update Status</button>
      <input type="hidden" name="_token" value="{{ Session::token() }}">
    </form>
    <hr>
   </div>
</div>


<div class="row">
  <div class="col-lg-5">
    @if(!$statuses->count())
      <p> You have no status</p>
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
             <li>{{ $status->created_at->diffForHumans() }}</li>
             @if($status->user->id !== Auth::user()->id)
               <li><a href="{{ route('status.like', ['statusId'=>$status->id]) }}">Like</a></li>
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
                   <li><a href="{{ route('status.like', ['statusId'=>$reply->id]) }}">Like</a></li>
                @endif
                  <li>{{ $reply->likes->count() }} {{ str_plural('like', $reply->likes->count())}}</li>
               </ul>
             </div>
           </div>
           @endforeach

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
         </div>
       </div>
      @endforeach
      {!! $statuses->render() !!}
    @endif
  </div>
</div>
@stop
