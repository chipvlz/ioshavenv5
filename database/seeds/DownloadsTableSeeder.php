<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Download;
use App\Like;
use App\View;

class DownloadsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $faker = Faker::create();

      for ($i=0; $i < 4000; $i++) {
        $d = new Download;
        $d->user_id = 2;
        $d->app_id = 3;
        $time = $faker->dateTimeThisYear();
        $d->created_at = $time;
        $d->updated_at = $time;
        $d->save();

        $l = new Like;
        $tables = ['apps', 'stories'];
        $l->table = $tables[$faker->numberBetween(0, 1)];
        $l->user_id = 2;
        $l->table_id = 3;
        $time = $faker->dateTimeThisYear();
        $l->created_at = $time;
        $l->updated_at = $time;
        $l->save();
      }

      for ($i=0; $i < 10000; $i++) {
        $v = new View;
        $tables = ['apps', 'stories'];
        $v->table = $tables[$faker->numberBetween(0, 1)];
        $v->user_id = 2;
        $v->table_id = 3;
        $time = $faker->dateTimeThisYear();
        $v->created_at = $time;
        $v->updated_at = $time;
        $v->save();
      }
    }
}
