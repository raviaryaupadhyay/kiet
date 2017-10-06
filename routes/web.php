<?php
//home

Route::get('/',[
  'uses'=>'\kietbook\Http\Controllers\HomeController@index',
  'as'=>'home',
]);

//alert

Route::get('/alert',function(){
  return redirect()->route('home')->with('info','you are loged in!');
});

//Authentication


Route::get('/signup',[
  'uses'=>'\kietbook\Http\Controllers\AuthController@getSignup',
  'as'=>'auth.signup',
  'middleware'=>['guest']
]);


Route::post('/signup',[
  'uses'=>'\kietbook\Http\Controllers\AuthController@postSignup',
  'middleware'=>['guest']
]);

Route::get('/OTPConfirm',[
  'uses'=>'\kietbook\Http\Controllers\AuthController@getOTPConfirm',
  'as'=>'auth.OTPConfirm',
  'middleware'=>['guest']
]);

Route::post('/OTPConfirm',[
  'uses'=>'\kietbook\Http\Controllers\AuthController@postOTPConfirm',
  'middleware'=>['guest']
]);

Route::get('/OTP',[
  'uses'=>'\kietbook\Http\Controllers\AuthController@getOTP',
  'as'=>'auth.OTP',
  'middleware'=>['guest']
]);

Route::post('/OTP',[
  'uses'=>'\kietbook\Http\Controllers\AuthController@postOTP',
  'middleware'=>['guest']
]);


Route::get('/signin',[
  'uses'=>'\kietbook\Http\Controllers\AuthController@getSignin',
  'as'=>'auth.signin',
  'middleware'=>['guest']
]);


Route::post('/signin',[
  'uses'=>'\kietbook\Http\Controllers\AuthController@postSignin',
  'middleware'=>['guest']
]);


Route::get('/signout',[
  'uses'=>'\kietbook\Http\Controllers\AuthController@getSignout',
  'as'=>'auth.signout',
]);


//forget
Route::get('/forget',[
  'uses'=>'\kietbook\Http\Controllers\AuthController@getForget',
  'as'=>'auth.forget',
  'middleware'=>['guest']
]);

Route::post('/forget',[
  'uses'=>'\kietbook\Http\Controllers\AuthController@postForget',
  'middleware'=>['guest']
]);


Route::get('/search',[
  'uses'=>'\kietbook\Http\Controllers\SearchController@getResults',
  'as'=>'search.results'

]);

Route::get('/profile/edit/rePassword',[
  'uses'=>'\kietbook\Http\Controllers\ProfileController@getRePassword',
  'as'=>'profile.rePassword',
  'middleware'=>['auth']
]);

Route::post('/profile/edit/rePassword',[
  'uses'=>'\kietbook\Http\Controllers\ProfileController@postRePassword',
  'middleware'=>['auth']
]);

Route::get('/user/{username}',[
  'uses'=>'\kietbook\Http\Controllers\ProfileController@getProfile',
  'as'=>'profile.index'
]);

Route::get('/profile/edit',[
  'uses'=>'\kietbook\Http\Controllers\ProfileController@getEdit',
  'as'=>'profile.edit',
  'middleware'=>['auth'],
]);

Route::post('/profile/edit',[
  'uses'=>'\kietbook\Http\Controllers\ProfileController@postEdit',
  'middleware'=>['auth'],
]);

Route::get('/friends',[
  'uses'=>'\kietbook\Http\Controllers\FriendController@getIndex',
  'as'=>'friend.index',
  'middleware'=>['auth'],
]);

Route::get('/friends/adds/{username}',[
  'uses'=>'\kietbook\Http\Controllers\FriendController@getAdd',
  'as'=>'friend.add',
  'middleware'=>['auth'],
]);

Route::get('/friends/accept/{username}',[
  'uses'=>'\kietbook\Http\Controllers\FriendController@getAccept',
  'as'=>'friend.accept',
  'middleware'=>['auth'],
]);

Route::get('/friends/delete/{username}',[
  'uses'=>'\kietbook\Http\Controllers\FriendController@getDelete',
  'as'=>'friend.delete',
  'middleware'=>['auth'],
]);


Route::post('/status',[
  'uses'=>'\kietbook\Http\Controllers\StatusController@postStatus',
    'as'=>'status.post',
  'middleware'=>['auth'],
]);

Route::post('/status/{statusId}/reply',[
  'uses'=>'\kietbook\Http\Controllers\StatusController@postReply',
    'as'=>'status.reply',
  'middleware'=>['auth'],
]);

Route::get('/status/{statusId}/like',[
  'uses'=>'\kietbook\Http\Controllers\StatusController@getLike',
  'as'=>'status.like',
  'middleware'=>['auth'],
]);
?>
