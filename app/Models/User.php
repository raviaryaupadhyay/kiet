<?php

namespace kietbook\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use kietbook\Models\Status;

class User extends Model implements AuthenticatableContract
{
    use Authenticatable;

    protected $table='users';

    protected $fillable = [
        'username',
        'email',
        'password',
        'first_name',
        'last_name',
        'location',
        'OTP',
      ];
    protected $hidden = [
        'password',
        'remember_token',
    ];
    public function getName()
    {
      if($this->first_name && $this->last_name)
      {
        return "{$this->first_name} {$this->last_name}";
      }
      if($this->first_name)
      {
            return "{$this->first_name}";
      }
      return null;
    }

    public function getNameOrUsername()
    {
        return $this->getName() ? : $this->username;
    }

    public function getFirstNameOrUsername()
    {
        return $this->first_name ? : $this->username;
    }


    public function getAvatarUrl()
    {
        return "https://www.gravatar.com/avatar/{{ md5($this->email) }}?d=mm&s=40";
    }


    public function statuses()
    {
      return $this->hasMany('kietbook\Models\Status','user_id');
    }

    public function likes()
    {
      return $this->hasMany('kietbook\Models\Like','user_id');
    }


    public function friendsOfMine()
    {
      return $this->belongsToMany('kietbook\Models\User','friends','user_id','friend_id');
    }

    public function friendOf()
    {
      return $this->belongsToMany('kietbook\Models\User','friends','friend_id','user_id');
    }
    public function friends()
    {
      return $this->friendsOfMine()->wherePivot('accepted',true)->get()->merge($this->friendOf()->wherePivot('accepted',true)->get());
    }

    public function friendRequests()
    {
      return $this->friendsOfMine()->wherePivot('accepted',false)->get();
    }

    public function friendRequestsPending()
    {
      return $this->friendOf()->wherePivot('accepted',false)->get();
    }

    public function hasFriendRequestsPending(User $user)
    {
      return  (bool)$this->friendRequestsPending()->where('id',$user->id)->count();
    }

    public function hasFriendRequestsRecived(User $user)
    {
      return  (bool)$this->friendRequests()->where('id',$user->id)->count();
    }

    public function addFriend(User $user)
    {
      return  $this->friendOf()->attach($user->id);
    }

    public function deleteFriend(User $user)
    {
      $this->friendOf()->detach($user->id);
      $this->friendsOfMine()->detach($user->id);
    }
    public function acceptFriendRequest(User $user)
    {
      return  $this->friendRequests()->where('id',$user->id)->first()->pivot->update([
        'accepted'=>true,
      ]);
    }
    public function isFriendWith(User $user)
    {
      return  (bool)$this->friends()->where('id',$user->id)->count();
    }


    public function hasLikedStatus(Status $status)
    {
      return (bool) $status->likes
      ->where('user_id',$this->id)
      ->count();
    }

  }
