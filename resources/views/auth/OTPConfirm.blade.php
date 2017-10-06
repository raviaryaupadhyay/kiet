@extends('templates.default')

@section('content')
<h1>OTP confirmation</h1>
   <div class="row">
     <div class="col-lg-6">
       <form class="form-vertical"  role="form" method="post" action="{{ route('auth.OTPConfirm')}}">

       <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
         <label for="email" class="control-label">Email</label>
         <input type="text" name="email" class="form-control" id="email" value="{{ Request::old('email') ?: '' }}">
         @if($errors->has('email'))
          <span class="help-block">{{ $errors->first('email') }}</span>
         @endif
      </div>

       <div class="form-group{{ $errors->has('OTP') ? ' has-error' : '' }}">
         <label for="OTP" class="control-label">OTP</label>
         <input type="text" name="OTP" class="form-control" id="OTP" value="">
         @if($errors->has('OTP'))
          <span class="help-block">{{ $errors->first('OTP') }}</span>
         @endif
       </div>

      <div class="form-group">
        <button type="submit" class="btn btn-default">Confirm OTP</button
     </div>
     <input type="hidden" name="_token" value="{{ Session::token() }}">
   </form>
 </div>
</div>
@stop
