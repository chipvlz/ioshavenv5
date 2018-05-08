<?php

namespace App\Traits;

use DB;
use Carbon\Carbon;
use Auth;
use App\User;
use App\Like;

trait Likeable
{

  public function like() {
    return Like::firstOrCreate([
      "table" => $this->getTable(),
      "user_id" => Auth::id(),
      "table_id" => $this->id,
    ]);
  }

  public function unlike() {
    return Like::where([
      "table" => $this->getTable(),
      "user_id" => Auth::id(),
      "table_id" => $this->id,
    ])->delete();
  }

  public function likeCount() {
    return Like::where([
      "table" => $this->getTable(),
      "table_id" => $this->id,
    ])->count();
  }

  public function isLiked() {
    return Like::where([
      "table" => $this->getTable(),
      "user_id" => Auth::id(),
      "table_id" => $this->id,
    ])->exists();
  }
}
