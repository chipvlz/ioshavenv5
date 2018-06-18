<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Role;
use Session;
use Report;
use Auth;
use Gate;
use Hash;

class UserController extends Controller
{

    public function __construct()
    {
        // $this->middleware('can:manage users');
    }

    public function showUser($username) {
      $user = User::withTrashed()->where('username', $username)->first();
      return view('dashboard.profile', [
        "isAuth" => $user->username == Auth::user()->username,
        "user" => $user,
        "hasBottomNav" => true,
        "roles" => Role::get(),
      ]);
    }

    public function edit(Request $r) {
      // dd($r->all());
      $session_messages = [];
      $user = User::withTrashed()->find($r->id);

      if ($r->username != $user->username) {
        $r->validate([
          'username' => 'required|string|alpha_num|min:3|max:255|unique:users',
        ]);
        $user->username = $r->username;
        array_push($session_messages, 'Username updated successfully!');
      }

      if (Gate::allows('manage roles') && $r->role){
        $user->role_id = $r->role;
        array_push($session_messages, 'Role updated successfully');
      }

      if (Gate::allows('manage users') && $r->ban){
        $user->ban_reason = $r->ban_reason;
        $user->delete();
        Session::flash('success', ['User banned successfully!']);
        return redirect('/dashboard/users');
      }

      if (Gate::allows('manage users') && $r->restore){
        $user->ban_reason = "";
        $user->restore();
        Session::flash('success', ['User restored successfully!']);
        return redirect('/dashboard/users');
      }

      if ($r->email != $user->email) {
        $r->validate([
          'email' => 'required|string|email|max:255|unique:users'
        ]);
        $user->email = $r->email;
        array_push($session_messages, 'Email updated successfully!');
      }

      if (Hash::check($r->old_password, $user->password)) {
        if ($r->password) {
          $r->validate([
            'password' => 'required|string|min:6|confirmed',
          ]);
          $user->password = Hash::make($r->password);
          array_push($session_messages, 'Password updated successfully!');
        }
      } else if ($r->old_password) {
        Session::flash('danger', ['Wrong password']);
      }

      $user->save();
      Session::flash('success', $session_messages);
      return redirect("/user/edit/$user->username");
    }
}
