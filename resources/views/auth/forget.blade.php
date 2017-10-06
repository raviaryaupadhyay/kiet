@extends('templates.default')

@section('content')

<h1>Request OTP</h1>
   <div class="row">
     <div class="col-lg-6">
       <form class="form-vertical"  role="form" method="post" action="{{ route('auth.forget')}}">


       <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
         <label for="email" class="control-label">Email</label>
         <input type="text" name="email" class="form-control" id="email" value="{{ Request::old('email') ?: '' }}">
         @if($errors->has('email'))
          <span class="help-block">{{ $errors->first('email') }}</span>
         @endif
      </div>

      <div class="form-group">
        <button type="submit" class="btn btn-default">Get OTP</button
     </div>
     <input type="hidden" name="_token" value="{{ Session::token() }}">
   </form>
 </div>
</div>
@stop
