<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Role;
use App\Permission;
use Carbon;
use Gate;

class RoleController extends Controller
{
    public function showEditPage($id) {
      if (Gate::denies('manage roles')) abort(404);
      return view('dashboard.editRole', [
        "role" => Role::find($id),
        "permissions" => Permission::get(),
        "hasBottomNav" => true
      ]);
    }

    public function edit(Request $r) {
      if (Gate::denies('manage roles')) abort(404);
      $role = Role::find($r->role);
      $role->permissions()->sync($r->ids);
      $role->name = $r->name;
      $role->updated_at = null;
      $role->save();
      return back();
    }

    public function delete($id) {
      if (Gate::denies('manage roles')) abort(404);
      $role = Role::find($id);
      $role->delete();
      return redirect("/dashboard/roles");
    }

    public function create() {
      if (Gate::denies('manage roles')) abort(404);
      $r = Role::create([
        "name" => str_random(10)
      ]);
      return back();
    }
}
