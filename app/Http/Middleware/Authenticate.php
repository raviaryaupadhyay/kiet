<?php

namespace kietbook\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth\Gaurd;

class Authenticate
{
    protected $auth;

    public function __construct(Gaurd $auth)
    {
      $this->auth=$auth;
    }

    public function handle($request, Closure $next)
    {
      if ($this->auth->guest()) {
        if($request->ajax()){
          return response('Unautherized',401);
        }else {
          return redirect()->route('auth.signup');
        }
      }
        return $next($request);
    }
}
