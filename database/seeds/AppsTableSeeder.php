<?php

use Illuminate\Database\Seeder;
use App\App;
use App\Report;

use Faker\Factory as Faker;

class AppsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $faker = Faker::create();

      for ($i=0; $i < 400; $i++) {
        $uid = str_random(7);
        $app = App::create([
          "user_id" => 1,
          "uid" => $uid
        ]);
        $app->status = "published";
        $app->name = $faker->words(3, true);
        $app->short = $faker->words(5, true);
        $app->description = $faker->paragraphs(3, true);
        $app->save();

        Report::info("App:create", "AppsTableSeeder.php" . ": Created application $uid");
      }

    }
}
