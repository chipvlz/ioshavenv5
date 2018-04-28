<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
  protected $fillable = ["name", "label"];

  public function permissions() {
    return $this->belongsToMany('App\Permission');
  }

  public function isAllowedTo($permission) {
    return $this->permissions->contains('name', $permission);
  }
}
