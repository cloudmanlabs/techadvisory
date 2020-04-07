<?php

use App\Subpractice;
use Illuminate\Database\Seeder;

class SubpracticeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Subpractice::class)->create([
            'name' => 'Logistics Procurement'
        ]);
        factory(Subpractice::class)->create([
            'name' => 'Tactical Planning'
        ]);
        factory(Subpractice::class)->create([
            'name' => 'Order Management'
        ]);
        factory(Subpractice::class)->create([
            'name' => 'Transport Planning'
        ]);
        factory(Subpractice::class)->create([
            'name' => 'Tendering & Spot buying'
        ]);
        factory(Subpractice::class)->create([
            'name' => 'Execution & Visbility'
        ]);
        factory(Subpractice::class)->create([
            'name' => 'Document management'
        ]);
        factory(Subpractice::class)->create([
            'name' => 'Trade complaince'
        ]);
        factory(Subpractice::class)->create([
            'name' => 'FBA'
        ]);
        factory(Subpractice::class)->create([
            'name' => 'Reporting and Analytics'
        ]);
    }
}
