<?php

use Illuminate\Database\Seeder;
use App\Preview;
use App\Log;

use Faker\Factory as Faker;

class PreviewsTableSeeder extends Seeder
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
        $app = Preview::create([
          "user_id" => 1,
          "uid" => $uid
        ]);
        $app->status = "unpublished";
        $app->name = $faker->words(3, true);
        $app->short = $faker->words(5, true);
        $app->description = $faker->paragraphs(3, true);
        $app->save();

        Log::info("Preview:create", "PreviewTableSeeder.php" . ": Created application $uid");
      }

    }
}
