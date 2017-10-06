<?php

namespace kietbook\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Status extends Model
{
    protected $table='statuses';

    protected $fillable=[
      'user_id',
      'body'
    ];

    public function user()
    {
      return $this->belongsTO('kietbook\Models\User','user_id');
    }

    public function scopeNotReply($query)
    {
      return $query->whereNull('parent_id');
    }

    public function replies()
    {
      return $this->hasMany('kietbook\Models\Status','parent_id');
    }

    public function likes()
    {
      return $this->morphMany('kietbook\Models\Like','likeable');
    }

}
