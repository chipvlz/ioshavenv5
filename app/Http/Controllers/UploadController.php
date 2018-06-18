<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\StoryVersion;
use App\Preview;
use App\Story;
use App\User;
use App\App;
use Response;
use Storage;
use Report;
use Image;

class UploadController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

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
        return Storage::cloud()->url($path);
      } catch (\Exception $e) {
        return $e;
      }
    }

    public function apk(Request $request) {
      $fileTypes = ['apk'];
      $path = $this->upload($request, 'apk-0', 'apk', $fileTypes);
      Report::success([
        "message" => "uploaded apk",
        "data" => [
          "path" => $path,
        ]
      ]);
      if (!$path) {
        return Response::json([
          "error" => "wrong extension",
          "accepted" => $fileTypes
        ], 500);
      }
      return response()->json([
        "path" => $path,
        "size" => Storage::size($path),
      ]);
    }

    public function ipa(Request $request) {
      $fileTypes = ['ipa'];
      $path = $this->upload($request, 'unsigned-0', 'unsigned', $fileTypes);
      Report::success([
        "message" => "uploaded ipa",
        "data" => [
          "path" => $path,
        ]
      ]);
      if (!$path) {
        return Response::json([
          "error" => "wrong extension",
          "accepted" => $fileTypes
        ], 500);
      }
      return response()->json([
        "path" => $path,
        "size" => Storage::size($path),
      ]);
    }

    public function icon(Request $request) {
      $fileTypes = ['png', 'jpg', 'jpeg'];
      $path = $this->image($request, 'icon-0', 'icons', $fileTypes, 100, 100);
      Report::success([
        "message" => "uploaded app icon",
        "data" => [
          "path" => $path,
        ]
      ]);
      if (!$path) {
        return Response::json([
          "error" => "wrong extension",
          "accepted" => $fileTypes
        ], 500);
      }
      return response()->json([
        "path" => $path,
        "image" => $path,
      ]);
    }

    public function banner(Request $request) {
      $fileTypes = ['png', 'jpg', 'jpeg'];
      $path = $this->image($request, 'banner-0', 'banners', $fileTypes, 1500, 500);
      Report::success([
        "message" => "uploaded app banner",
        "data" => [
          "path" => $path,
        ]
      ]);
      if (!$path) {
        return Response::json([
          "error" => "wrong extension",
          "accepted" => $fileTypes
        ], 500);
      }
      return response()->json([
        "path" => $path,
        "image" => $path,
      ]);
    }

    public function avatar(Request $request) {
      $fileTypes = ['png', 'jpg', 'jpeg', 'gif'];
      $path = $this->image($request, 'avatar-0', 'avatars', $fileTypes, 200, 200);
      if ($path instanceof \Exception) {
        return response()->json($path);
      }
      Report::success([
        "message" => "uploaded user avatar",
        "data" => [
          "path" => $path,
        ]
      ]);
      if (!$path) {
        return Response::json([
          "error" => "wrong extension",
          "accepted" => $fileTypes
        ], 500);
      }
      $user = User::find($request->id);
      $user->avatar = $path;
      $user->save();
      return response()->json($user);
    }

    public function story(Request $request) {
      $fileTypes = ['png', 'jpg', 'jpeg', 'gif'];
      $path = $this->image($request, 'image-0', 'stories', $fileTypes, 600, 400);
      Report::success([
        "message" => "uploaded story image",
        "data" => [
          "path" => $path,
        ]
      ]);
      if (!$path) {
        return Response::json([
          "error" => "wrong extension",
          "accepted" => $fileTypes
        ], 500);
      }

      return response()->json([
        "path" => $path,
        "image" => $path,
      ]);
    }
}
