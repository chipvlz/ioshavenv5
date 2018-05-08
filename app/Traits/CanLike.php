<?php

namespace App\Traits;

use DB;
use Carbon\Carbon;
use Auth;
use App\User;
use App\Like;

trait CanLike
{

  public function like($thing) {
    $this->can('like');
    return Like::firstOrCreate([
      "table" => $thing->getTable(),
      "user_id" => $this->id,
      "table_id" => $thing->id,
    ]);
  }

  public function unlike($thing) {
    $this->can('like');
    return Like::where([
      "table" => $thing->getTable(),
      "user_id" => $this->id,
      "table_id" => $thing->id,
    ])->delete();
  }

  public function likeCount($table=null) {
    return !!$table ?
      Like::where([
        "user_id" => $this->id,
        "table" => $table,
      ])->count()
      :
      Like::where([
        "user_id" => $this->id,
      ])->count();
  }
}
