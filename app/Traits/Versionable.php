<?php

namespace App\Traits;

use DB;
use Carbon\Carbon;
use Auth;
use App\User;

trait Versionable
{
  private static $short;
  private $commitMessage;
  private $lastAttributes;

  private static function table() {
    static::$short = strtolower((new \ReflectionClass(get_called_class()))->getShortName());
    $table = static::$short . "_versions";
    return DB::table($table);
  }

  public function published() {
    $res = static::table()->where('uid', $this->published_version)->first();
    if (is_null($res)) return $res;
    $res->released_at = new Carbon($res->released_at);
    $res->created_at = new Carbon($res->created_at);
    $res->updated_at = new Carbon($res->updated_at);
    return $res;
  }

  public static function mergeVersions() {
    $table = with(new static)->getTable();
    static::table();
    return static::join(static::$short.'_versions', "$table.saved_version", '=', static::$short.'_versions.uid')
           ->select("$table.*", static::$short.'_versions.*', static::$short.'_versions.uid as vid', "$table.uid as uid");
  }

  public function isPublished() {
    return !!$this->published();
  }

  public function current() {
    $res = static::table()->where('uid', $this->saved_version)->first();
    if (is_null($res)) return $res;
    $res->released_at = new Carbon($res->released_at);
    $res->created_at = new Carbon($res->created_at);
    $res->updated_at = new Carbon($res->updated_at);
    return $res;
  }

  public function queued() {
    $res = static::table()->where('uid', $this->queued_version)->first();
    if (is_null($res)) return $res;
    $res->released_at = new Carbon($res->released_at);
    $res->created_at = new Carbon($res->created_at);
    $res->updated_at = new Carbon($res->updated_at);
    return $res;
  }

  public function isQueued() {
    return !!$this->queued();
  }

  public function setVersion($vid) {
    $this->specifiedVersion = $vid;
    return $this;
  }

  public function version($vid) {
    $this->setVersion($vid);
    $res = static::table()->where('uid', $vid)->first();
    if (is_null($res)) return $res;
    $res->released_at = new Carbon($res->released_at);
    $res->created_at = new Carbon($res->created_at);
    $res->updated_at = new Carbon($res->updated_at);
    return $res;
  }

  public function versions() {
    $versions = static::table()->where(static::$short . '_id', $this->id)->get();
    foreach($versions as $version) {
      $version->user = User::find($version->user_id);
    }
    return collect($versions);
  }

  public static function byuid($uid) {
    return static::where('uid', $uid);
  }

  public function summary($message) {
    $this->commitMessage = $message;
    return $this;
  }

  public function commit(array $data) {
    static::table();
    $parent_id = static::$short . '_id';
    $vid = str_random(20);
    $time = Carbon::now();
    $attributes = [
      "$parent_id" => $this->id,
      "user_id" => Auth::id(),
    ] + $data;

    if (! is_null($this->lastQueryResult = static::table()->where($attributes)->first())) {
        $this->lastAttributes = $attributes;
        return $this;
    }

    static::table()->insert($attributes + [
      "uid" => $vid,
      "commit" => !!$this->commitMessage ? $this->commitMessage : "Unnamed commit: $vid",
      "created_at" => $time,
      "updated_at" => $time,
    ]);

    $this->lastAttributes = $attributes;
    return $this;
  }

  public static function make($data=[], $data2=[]) {
    static::table();
    $uid = str_random(7);
    $vid = str_random(20);
    $parent_id = static::$short . '_id';
    $time = Carbon::now();

    $parent = static::create($data + [
      "uid" => $uid,
      "user_id" => Auth::id(),
      "saved_version" => $vid,
      "created_at" => $time,
      "updated_at" => $time,
    ]);

    static::table()->insert($data2 + [
      'uid' => $vid,
      "$parent_id" => $parent->id,
      'user_id' => Auth::id(),
      'commit' => 'Initial commit',
      "created_at" => $time,
      "updated_at" => $time,
    ]);

    return static::where($data + [
      "uid" => $uid,
      "user_id" => Auth::id(),
      "saved_version" => $vid,
    ])->first();
  }

  public function modify($data) {
    $version = $this->specifiedVersion ?? $this->saved_version;
    $query = static::table()->where('uid', $version);
    $query->update($data);
    return $query->first();
  }

  public function setAsCurrent() {
    $query = static::table()->where($this->lastAttributes);
    $version = $query->first();
    static::byuid($this->uid)->update([
      "saved_version" => $version->uid
    ]);
  }

  public function publish() {
    $query = static::table()->where($this->lastAttributes);
    $version = $query->first();
    if (!$version->released_at) {
      $query->update(["released_at" => Carbon::now()]);
    }
    static::byuid($this->uid)->update([
      "published_version" => $version->uid
    ]);
  }

  public function queue() {
    $query = static::table()->where($this->lastAttributes);
    $version = $query->first();
    static::byuid($this->uid)->update([
      "queued_version" => $version->uid
    ]);
  }

  public function accept() {
    $query = static::table()->where($this->lastAttributes);
    $version = $query->first();
    $current = static::byuid($this->uid)->first();
    $current->update([
      "published_version" => $current->queued_version,
      "queued_version" => "",
    ]);
  }

}
