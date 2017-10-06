<nav class="navbar navbar-default" role="navigation"  style="background-color:#5DADE2">
  <div class="container" >
      <div class="navbar navbar-default" style="border:none;background-color:#5DADE2">
    <div class="navbar-header">
      <a class="navbar-brand" href="{{ route('home') }}" style="color:#641E16" >KIETBOOK</a>
    </div>
      @if (Auth::check())
      <ul class="nav navbar-nav">
        <li><a href="{{ route('home') }}">Timeline</a></li>
        <li><a href="{{ route('friend.index') }}">Friends</a></li>
      </ul>
      <form class="navbar-form navbar-left" role="search" action="{{ route('search.results') }}">
        <div class="form-group">
          <input type="text" class="form-control" name="query" placeholder="Search">
        </div>
        <button type="submit" class="btn btn-default"  style="background-color:#5DADE2">Search</button>
      </form>
      @endif
      <ul class="nav navbar-nav navbar-right">
        @if (Auth::check())
        <li><a href="{{ route('profile.index',['username'=> Auth::user()->username]) }}" style="color:#641E16">{{ Auth::user()->getNameOrUsername()}}</a></li>
        <li><a href="{{ route('profile.edit') }}">Update Profile</a></li>
        <li><a href="{{ route('auth.signout') }}">Sign out</a></li>
        @else
        <li><a href="{{ route('auth.signup') }}">Sign up</a></li>
        <li><a href="{{ route('auth.signin') }}">Sign in</a></li>
        <li><a href="{{ route('auth.forget') }}">Forget Password</a></li>
        @endif
      </ul>
    </div>
  </div>
</nav>
