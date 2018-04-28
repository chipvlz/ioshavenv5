<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Log;
use Illuminate\Support\Facades\Hash;

use Faker\Factory as Faker;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $faker = Faker::create();

      for ($i=0; $i < 200; $i++) {
        $app = User::create([
          "username" => $faker->unique()->userName,
          "email" => $faker->unique()->email,
          "password" => Hash::make('asdfasdf')
        ]);

        Log::info("User:create", "UsersTableSeeder.php" . ": User signed up.");
      }

    }
}
