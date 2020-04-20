<?php

namespace Tests\Feature\Models;

use App\User;
use App\VendorSolution;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class VendorSolutionTest extends TestCase
{
    use RefreshDatabase;

    public function testCanCreateVendorSolution()
    {
        $vendor = factory(User::class)->states('vendor')->create();

        $this->assertCount(0, VendorSolution::all());

        $solution = new VendorSolution([
            'vendor_id' => $vendor->id,
            'name' => 'New Solution'
        ]);
        $solution->save();

        $this->assertCount(1, VendorSolution::all());
    }

    public function testCanAttachSolutionsToVendor()
    {
        $vendor = factory(User::class)->states('vendor')->create();

        $this->assertCount(0, $vendor->vendorSolutions);

        $solution1 = new VendorSolution([
            'vendor_id' => $vendor->id,
            'name' => 'New Solution'
        ]);
        $vendor->vendorSolutions()->save($solution1);

        $solution2 = new VendorSolution([
            'vendor_id' => $vendor->id,
            'name' => 'New Solution 2'
        ]);
        $vendor->vendorSolutions()->save($solution2);

        $vendor->refresh();
        $this->assertCount(2, $vendor->vendorSolutions);
    }

    public function testCanGetTheSolutionsVendor()
    {
        $vendor = factory(User::class)->states('vendor')->create();

        $solution = new VendorSolution([
            'vendor_id' => $vendor->id,
            'name' => 'New Solution'
        ]);
        $vendor->vendorSolutions()->save($solution);

        $solution->refresh();
        $this->assertNotNull($solution->vendor);
    }

    public function testCanCreateSolutionWithPost()
    {
        $vendor = factory(User::class)->states(['vendor', 'finishedSetup'])->create();

        $this->assertCount(0, VendorSolution::all());

        $response = $this
            ->actingAs($vendor)
            ->post('/vendors/solution/create');

        $this->assertCount(1, VendorSolution::all());

        $response->assertRedirect('/vendors/solution/setup/'. VendorSolution::first()->id);
    }
}
