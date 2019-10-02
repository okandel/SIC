<?php

use Illuminate\Database\Seeder; 
class CountriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Eloquent::unguard();
 
        \DB::unprepared('Delete from countries');
        \DB::unprepared('Delete from states');
        \DB::unprepared('Delete from cities'); 



        //--https://github.com/dr5hn/countries-states-cities-database
        $path = 'database/seeds_script/countries.sql';
        \DB::unprepared(file_get_contents($path));
        $this->command->info('Country table seeded!');

        $path = 'database/seeds_script/states.sql';
        \DB::unprepared(file_get_contents($path));
        $this->command->info('State table seeded!');

        $path = 'database/seeds_script/cities.sql';
        \DB::unprepared(file_get_contents($path));
        
        $path = 'database/seeds_script/cities_2.sql';
        \DB::unprepared(file_get_contents($path));
        
        $this->command->info('City table seeded!');
    }
}
