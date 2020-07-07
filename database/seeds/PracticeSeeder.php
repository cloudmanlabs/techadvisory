<?php

use App\Practice;
use Illuminate\Database\Seeder;

class PracticeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Practice::class)->create([
            'name' => 'Transport'
        ]);
        factory(Practice::class)->create([
            'name' => 'Planning'
        ]);
        factory(Practice::class)->create([
            'name' => 'Manufacturing'
        ]);
        factory(Practice::class)->create([
            'name' => 'Warehousing'
        ]);
        factory(Practice::class)->create([
            'name' => 'Sourcing'
        ]);
    }
}
