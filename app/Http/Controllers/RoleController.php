<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Permission;
use App\Role;
use Carbon;
use Report;
use Gate;


class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:manage roles');
    }

    public function showEditPage($id) {
      return view('dashboard.editRole', [
        "role" => Role::find($id),
        "permissions" => Permission::get(),
        "hasBottomNav" => true
      ]);
    }

    public function edit(Request $r) {
      try {
        $role = Role::find($r->role);
        $role->permissions()->sync($r->ids);
        $role->name = $r->name;
        $role->updated_at = null;
        $role->save();
        Report::warning([
          "message" => "role/permissions changed!",
          "data" => [
            "permissions" => $role->permissions,
            "role" => $role->name,
          ]
        ]);
        return back();
      } catch (\Exception $e) {
        Report::danger([
          "message" => "failed to change role/permissions!",
          "data" => [
            "error" => Report::e($e),
          ]
        ]);
      }
    }

    public function delete($id) {
      try {
        $role = Role::find($id);
        $role->delete();
        Report::warning([
          "message" => "deleted role!",
          "data" => [
            "role" => $role
          ]
        ]);
        return redirect("/dashboard/roles");
      } catch (\Exception $e) {
        Report::danger([
          "message" => "failed to delete role!",
          "data" => [
            "error" => Report::e($e),
          ]
        ]);
      }
    }

    public function create() {
      try {
        $r = Role::create([
          "name" => str_random(10)
        ]);
        Report::warning([
          "message" => "created role!",
          "data" => [
            "role" => $r
          ]
        ]);
        return back();
      } catch (\Exception $e) {
        Report::danger([
          "message" => "failed to create role!",
          "data" => [
            "error" => Report::e($e),
          ]
        ]);
      }
    }
}
