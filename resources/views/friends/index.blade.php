@extends('templates.default')

@section('content')
<div class="row">
    <div class="col-lg-6">
        <h3>Your Friend</h3>
        @if (!$friends->count())
        <p> You have no Friends</p>
        @else
          @foreach ($friends as $user)
            @include('user/partials/userblock')
          @endforeach
        @endif
    </div>
    <div class="col-lg-6">
      <h3>Friend requests</h3>
        @if (!$requests->count())
          <p> You have no Friend request</p>
        @else
          @foreach ($requests as $user)
            @include('user/partials/userblock')
          @endforeach
        @endif
    </div>
</div>
@stop
