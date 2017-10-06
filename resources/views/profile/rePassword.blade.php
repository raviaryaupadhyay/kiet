@extends('templates.default')

@section('content')

<h1>Update password</h1>
   <div class="row">
     <div class="col-lg-6">
       <form class="form-vertical"  role="form" method="post" action="{{ route('profile.rePassword')}}">

       <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
         <label for="password" class="control-label">Enter new password</label>
         <input type="password" name="password" class="form-control" id="password" value="">
         @if($errors->has('password'))
          <span class="help-block">{{ $errors->first('password') }}</span>
         @endif
       </div>

       <div class="form-group{{ $errors->has('repassword') ? ' has-error' : '' }}">
         <label for="repassword" class="control-label">Re-Enter new password</label>
         <input type="password" name="repassword" class="form-control" id="repassword" value="">
         @if($errors->has('repassword'))
          <span class="help-block">{{ $errors->first('repassword') }}</span>
         @endif
       </div>


      <div class="form-group">
        <button type="submit" class="btn btn-default">Update Password</button
     </div>
     <input type="hidden" name="_token" value="{{ Session::token() }}">
   </form>
 </div>
</div>
@stop
