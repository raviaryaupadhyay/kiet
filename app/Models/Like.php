<?php

namespace kietbook\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Like extends Model
{
  protected $table='likeable';

  protected $fillable = [
      'user_id',
      'likeable_id',
      'likeable_type',
    ];

  public function likeable()
  {
    return $this->morphTo();
  }
  public function user()
  {
    return $this->belongsTO('kietbook\Models\User','user_id');
  }

}
