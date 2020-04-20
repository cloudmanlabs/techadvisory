<?php

namespace Tests\Feature\Views\Vendor;

use App\User;
use App\VendorSolution;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SolutionsHomeTest extends TestCase
{
    use RefreshDatabase;

    public function testWorks()
    {
        $vendor = factory(User::class)->states(['vendor', 'finishedSetup'])->create();

        $response = $this
                    ->actingAs($vendor)
                    ->get('/vendors/solutions');

        $response->assertStatus(200);
    }

    public function testCanSeeOwnSolutions()
    {
        $vendor = factory(User::class)->states(['vendor', 'finishedSetup'])->create();
        $solution = new VendorSolution([
            'vendor_id' => $vendor->id,
            'name' => 'New Solution'
        ]);
        $vendor->vendorSolutions()->save($solution);

        $response = $this
            ->actingAs($vendor)
            ->get('/vendors/solutions');

        $response->assertStatus(200)
                ->assertSee('New Solution');
    }
}
