<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;


    protected $fillable = [
        'username', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $dates = [
      "deleted_at"
    ];

    public function apps() {
      return $this->hasMany('App\App');
    }

    public function previews() {
      return $this->hasMany('App\Preview');
    }

    public function role() {
      return $this->belongsTo('App\Role');
    }
}
