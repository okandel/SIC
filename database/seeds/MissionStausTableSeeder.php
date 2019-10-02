<?php

use Illuminate\Database\Seeder;

class MissionStausTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $status = new \App\MissionStatus([
            'name' => 'New',
            'order' => '1'
        ]);
        $status->save();

        $status = new \App\MissionStatus([
            'name' => 'Pending',
            'order' => '2'
        ]);
        $status->save();

        $status = new \App\MissionStatus([
            'name' => 'Completed',
            'order' => '3'
        ]);
        $status->save();

        $status = new \App\MissionStatus([
            'name' => 'Re-arranged',
            'order' => '4'
        ]);
        $status->save();

        $status = new \App\MissionStatus([
            'name' => 'Canceled',
            'order' => '5'
        ]);
        $status->save();
    }
}
