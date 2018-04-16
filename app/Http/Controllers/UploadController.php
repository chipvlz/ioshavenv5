<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Response;
use App\App;

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

    public function apk(Request $request) {
      $fileTypes = ['apk'];
      $path = $this->upload($request, 'apk-0', 'apk', $fileTypes);
      if (!$path) {
        return Response::json([
          "error" => "wrong extention",
          "accepted" => $fileTypes
        ], 501);
      }
      $app = App::byuid($request->uid)->first();
      $app->android = $path;
      $app->save();
      return response()->json($path);
    }
}
