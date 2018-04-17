<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Response;
use Image;
use Storage;
use App\App;
use App\Preview;

class UploadController extends Controller
{
    private function upload($request, $field, $folder, $acceptedFiles) {
      $file = $request->file($field);
      $name = uniqid("", true);
      $ext = $file->getClientOriginalExtension();
      if (!in_array($ext, $acceptedFiles)) {
        return false;
      }
      $path = $file->storeAs($folder, "$name.$ext");
      return $path;
    }

    private function image($request, $field, $folder, $acceptedFiles, $size1, $size2) {
      try {
        $folder = "public/$folder";
        $file = $request->file($field);
        $path = $file->hashName($folder);
        $ext = $file->getClientOriginalExtension();
        if (!in_array($ext, $acceptedFiles)) {
          return false;
        }
        $image = Image::make($file);
        $image->fit($size1, $size2, function ($constraint) {
          $constraint->aspectRatio();
        });
        Storage::put($path, (string) $image->encode(), 'public');
        return $path;
      } catch (\Exception $e) {
        return false;
      }
    }

    public function apk(Request $request) {
      $fileTypes = ['apk'];
      $path = $this->upload($request, 'apk-0', 'apk', $fileTypes);
      if (!$path) {
        return Response::json([
          "error" => "wrong extention",
          "accepted" => $fileTypes
        ], 501);
      }
      $app = Preview::byuid($request->uid)->first();
      $app->apk = "app/$path";
      $app->size = Storage::size($path);
      $app->save();
      return response()->json($app);
    }

    public function icon(Request $request) {
      $fileTypes = ['png', 'jpg', 'jpeg'];
      $path = $this->image($request, 'icon-0', 'icons', $fileTypes, 100, 100);
      if (!$path) {
        return Response::json([
          "error" => "wrong extention",
          "accepted" => $fileTypes
        ], 501);
      }
      $app = Preview::byuid($request->uid)->first();
      $app->icon = str_replace_first("public", "/storage", $path);
      $app->save();
      return response()->json($app);
    }

    public function banner(Request $request) {
      $fileTypes = ['png', 'jpg', 'jpeg'];
      $path = $this->image($request, 'banner-0', 'banners', $fileTypes, 1500, 500);
      if (!$path) {
        return Response::json([
          "error" => "wrong extention",
          "accepted" => $fileTypes
        ], 501);
      }
      $app = Preview::byuid($request->uid)->first();
      $app->banner = str_replace_first("public", "/storage", $path);;
      $app->save();
      return response()->json($app);
    }
}
