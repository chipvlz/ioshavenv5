<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Permission;
use App\Role;

class CreatePermissionTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('permissions', function (Blueprint $table) {
          $table->engine = 'InnoDB';
          $table->increments('id');
          $table->string('name');
          $table->string("label");
          $table->timestamps();
      });

      Schema::create('roles', function (Blueprint $table) {
          $table->engine = 'InnoDB';
          $table->increments('id');
          $table->string('name');
          $table->timestamps();
      });


      Schema::create('permission_role', function (Blueprint $table) {
          $table->engine = 'InnoDB';
          $table->integer("permission_id")->unsigned();
          $table->integer("role_id")->unsigned();
      });

      Schema::table('permission_role', function (Blueprint $table) {
          $table->foreign('permission_id')->references('id')->on('permissions')->onDelete('cascade');
          $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
      });

      foreach(config("permissions") as $name => $label) {
        Permission::create([
          "name" => $name,
          "label" => $label
        ]);
      }

      $r = Role::create([
        "name" => "root",
      ]);
      $r->permissions()->sync([1]);

      $r = Role::create([
        "name" => "user",
      ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permission_role');
        Schema::dropIfExists('roles');
        Schema::dropIfExists('permissions');
    }
}
