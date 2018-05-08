<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\CanLike;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;
    use CanLike;


    protected $fillable = [
        'username', 'email', 'password', "role_id"
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $dates = [
      "deleted_at"
    ];

    public function apps() {
      return $this->hasMany('App\App')
              ->join('app_versions', 'apps.saved_version', '=', 'app_versions.uid')
              ->select('apps.*', 'app_versions.*', 'app_versions.uid as vid', 'apps.uid as uid');
    }

    public function role() {
      return $this->belongsTo('App\Role');
    }
}
