<?php

namespace Tests\Feature\Views\Vendor;

use App\User;
use App\VendorSolution;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SolutionsEditTest extends TestCase
{
    use RefreshDatabase;

    public function testWorks()
    {
        factory(User::class)
            ->states(['vendor', 'finishedSetup'])
            ->create()
            ->each(function ($user) {
                $user->vendorSolutions()->save(factory(VendorSolution::class)->make());
            });
        $vendor = User::vendorUsers()->first();
        $solution = $vendor->vendorSolutions->first();

        $response = $this
            ->actingAs($vendor)
            ->get('/vendors/solution/edit/'. $solution->id);

        $response->assertStatus(200)
                    ->assertSee($solution->name);
    }
}
