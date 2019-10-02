<?php

use App\Plan;
use Illuminate\Database\Seeder;

class PlanTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $plan = new Plan([
            'name' => 'Basic',
        ]);
        $plan->save();

        $plan = new Plan([
            'name' => 'Standard',
        ]);
        $plan->save();

        $plan = new Plan([
            'name' => 'Full',
        ]);
        $plan->save();
    }
}
