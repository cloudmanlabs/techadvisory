<?php

namespace Tests\Feature\Views\Accenture;

use App\User;
use App\VendorProfileQuestion;
use App\VendorProfileQuestionResponse;
use App\VendorSolution;
use App\VendorSolutionQuestion;
use App\VendorSolutionQuestionResponse;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class VendorListTest extends TestCase
{
    use RefreshDatabase;

    public function testWorks()
    {
        $user = factory(User::class)->states('accenture')->create();
        $response = $this
                ->actingAs($user)
                ->get('accenture/vendorList');

        $response->assertStatus(200);
    }

    public function testShowsVendors()
    {
        $user = factory(User::class)->states('accenture')->create();

        $vendor1 = factory(User::class)->states('vendor')->create();
        $vendor2 = factory(User::class)->states('vendor')->create();


        $response = $this
            ->actingAs($user)
            ->get('accenture/vendorList');

        $response->assertStatus(200)
            ->assertSee($vendor1->name)
            ->assertSee($vendor2->name);
    }

    public function testCanCreateVendorWithPost()
    {
        $user = factory(User::class)->states('accenture')->create();

        $this->assertCount(0, User::vendorUsers()->get());

        $response = $this->actingAs($user)
            ->post('accenture/createVendor');

        $response->assertRedirect();

        $this->assertCount(1, User::vendorUsers()->get());
    }

    public function testVendorSolutionsShow()
    {
        $accenture = factory(User::class)->states('accenture')->create();
        $vendor = factory(User::class)->states('vendor')->create();

        $solution1 = new VendorSolution([
            'vendor_id' => $vendor->id,
            'name' => 'First Solution'
        ]);
        $vendor->vendorSolutions()->save($solution1);
        $solution2 = new VendorSolution([
            'vendor_id' => $vendor->id,
            'name' => 'Second SOlution'
        ]);
        $vendor->vendorSolutions()->save($solution2);

        $response = $this
            ->actingAs($accenture)
            ->get('accenture/vendorList');

        $response->assertStatus(200)
                    ->assertSee('First Solution')
                    ->assertSee('Second SOlution');
    }

    public function testCanViewSolutionAnswers()
    {
        $accenture = factory(User::class)->states('accenture')->create();

        $question = factory(VendorSolutionQuestion::class)->create([
            'type' => 'text'
        ]);
        factory(User::class)
            ->states(['vendor', 'finishedSetup'])
            ->create()
            ->each(function ($user) {
                $user->vendorSolutions()->save(factory(VendorSolution::class)->make());
            });
        $vendor = User::vendorUsers()->first();
        $solution = $vendor->vendorSolutions->first();
        $qResponse = $solution->questions->first();
        $qResponse->response = 'hello';
        $qResponse->save();

        $response = $this
            ->actingAs($accenture)
            ->get('accenture/vendorSolution/' . $solution->id);

        $response->assertStatus(200)
            ->assertSee('hello');
    }

    public function testCanEditSolution()
    {
        $accenture = factory(User::class)->states('accenture')->create();

        $question = factory(VendorSolutionQuestion::class)->create([
            'type' => 'text'
        ]);
        factory(User::class)
            ->states(['vendor', 'finishedSetup'])
            ->create()
            ->each(function ($user) {
                $user->vendorSolutions()->save(factory(VendorSolution::class)->make());
            });
        $vendor = User::vendorUsers()->first();
        $solution = $vendor->vendorSolutions->first();

        $response = $this
            ->actingAs($accenture)
            ->get('accenture/vendorSolution/edit/' . $solution->id);

        $response->assertStatus(200);
    }

    public function testCanChangeVendorResponse()
    {
        $user = factory(User::class)->states('accenture')->create();

        $question = factory(VendorProfileQuestion::class)->create();
        $vendor = factory(User::class)->states('vendor')->create();

        $qResponse = new VendorProfileQuestionResponse([
            'question_id' => $question->id,
            'vendor_id' => $vendor->id,
        ]);
        $qResponse->save();

        $response = $this->actingAs($user)
            ->post('/accenture/vendorProfileEdit/changeResponse', [
                'changing' => $qResponse->id,
                'value' => 'newText'
            ]);

        $response->assertOk();

        $qResponse->refresh();
        $this->assertEquals('newText', $qResponse->response);
    }

    public function testCanChangeVendorName()
    {
        $user = factory(User::class)->states('accenture')->create();
        $vendor = factory(User::class)->states('vendor')->create();

        $response = $this->actingAs($user)
            ->post('/accenture/vendorProfileEdit/changeName', [
                'vendor_id' => $vendor->id,
                'value' => 'newText'
            ]);

        $response->assertOk();

        $vendor->refresh();
        $this->assertEquals('newText', $vendor->name);
    }
}
