<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        for($i = 0; $i < 500; $i++){
            \DB::beginTransaction();
            for($j = 0; $j<1000; $j++){
                \DB::table('tests')->insert([
                    'first_name' => $faker->unique()->name,
                    'last_name' => $faker->unique()->name,
                    'year' => $faker->randomDigit,
                ]);
            }
            \DB::commit();
        }
    }
}
