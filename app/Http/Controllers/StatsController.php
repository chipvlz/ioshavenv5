<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Download;
use App\Like;
use App\View;
use Carbon\Carbon;
use DB;
use App\App;
use App\Story;

class StatsController extends Controller
{
    private function parseRaw($raw, $thing, $str='[') {
      foreach($raw as $item) {
        $type = gettype($item->$thing);
        if ($type === "string") $str .= "\"{$item->$thing}\",";
        elseif ($type === 'integer') $str .= "{$item->$thing},";
      }
      return rtrim($str, ',') . ']';
    }

    public function getDownloads($format='Y-_m-_d', $limit=7) {
      $format = str_replace('_', "%", $format);
      // dd(Auth::user()->apps()->get());
      $app_ids = Auth::user()->isAdmin() ? App::all()->pluck('id')->toArray() : Auth::user()->apps()->pluck('main_id')->toArray();
      $raw = Download::whereIn('app_id', $app_ids)
           ->select(DB::raw("DATE_FORMAT(created_at, '%$format') as date"), DB::raw('count(*) as count'))
           ->limit($limit)
           ->groupBy('date')
           ->orderBy('date', 'DESC')
           ->get();

     return response()->json([
       "count" => $this->parseRaw($raw, 'count'),
       "dates" => $this->parseRaw($raw, 'date'),
       "chart" => "downloads",
     ]);
    }




    public function getLikes($type, $format='Y-_m-_d', $limit=7) {
      $format = str_replace('_', "%", $format);
      if ($type === 'apps') {
        $ids = Auth::user()->isAdmin() ? App::all()->pluck('id')->toArray() : Auth::user()->apps()->pluck('main_id')->toArray();
      } elseif ($type === 'stories') {
        $ids = Auth::user()->isAdmin() ? Story::all()->pluck('id')->toArray() : Auth::user()->stories()->pluck('main_id')->toArray();
      } else {
        abort(404);
      }

      $raw = Like::where('table', $type)
              ->whereIn('table_id', $ids)
              ->select(DB::raw("DATE_FORMAT(created_at, '%$format') as date"), DB::raw('count(*) as count'))
              ->limit($limit)
              ->groupBy('date')
              ->orderBy('date', 'DESC')
              ->get();

      return response()->json([
        "count" => $this->parseRaw($raw, 'count'),
        "dates" => $this->parseRaw($raw, 'date'),
        "chart" => "likes",
      ]);
    }




    public function getViews($type, $format='Y-_m-_d', $limit=7) {
      $format = str_replace('_', "%", $format);
      // dd($format);
      if ($type === 'apps') {
        $ids = Auth::user()->isAdmin() ? App::all()->pluck('id')->toArray() : Auth::user()->apps()->pluck('main_id')->toArray();
      } elseif ($type === 'stories') {
        $ids = Auth::user()->isAdmin() ? Story::all()->pluck('id')->toArray() : Auth::user()->stories()->pluck('main_id')->toArray();
      } else {
        abort(404);
      }

      $raw = View::where('table', $type)
              ->whereIn('table_id', $ids)
              ->select(DB::raw("DATE_FORMAT(created_at, '%$format') as date"), DB::raw('count(*) as count'))
              ->limit($limit)
              ->groupBy('date')
              ->orderBy('date', 'DESC')
              ->get();

      return response()->json([
        "count" => $this->parseRaw($raw, 'count'),
        "dates" => $this->parseRaw($raw, 'date'),
        "chart" => "views",
      ]);
    }
}
