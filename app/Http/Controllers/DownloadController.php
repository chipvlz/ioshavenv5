<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\App;
use App\Preview;
use Image;
use Storage;

class DownloadController extends Controller
{
    public function previewApk ($uid) {
      $app = Preview::byuid($uid)->first();
      return response()->download(storage_path($app->apk));
    }

    public function previewImage ($folder, $file) {
      return Image::make(storage_path("app/$folder/$file"))->response();
    }
}
