<?php

namespace Tests\Feature\Views\Vendor;

use App\User;
use App\VendorProfileQuestion;
use App\VendorProfileQuestionResponse;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function testVendorCanAccessProfilePage()
    {
        $vendor = factory(User::class)->states(['vendor', 'finishedSetup'])->create();

        $response = $this->actingAs($vendor)
            ->get('vendors/profile');

        $response->assertOk();
    }

    public function testCanSeeOwnName()
    {
        $vendor = factory(User::class)->states(['vendor', 'finishedSetup'])->create();

        $response = $this->actingAs($vendor)
            ->get('vendors/profile');

        $response->assertOk();
        $response->assertSee($vendor->name);
    }

    public function testCanSeeAddedQuestionsInGeneralPage()
    {
        $question = factory(VendorProfileQuestion::class)->create([
            'page' => 'general'
        ]);
        $vendor = factory(User::class)->states(['vendor', 'finishedSetup'])->create();

        $qResponse = new VendorProfileQuestionResponse([
            'question_id' => $question->id,
            'vendor_id' => $vendor->id,
        ]);
        $qResponse->save();

        $response = $this->actingAs($vendor)
            ->get('vendors/profile');

        $response->assertOk();
        $response->assertSee($question->label);
    }

    public function testCanSeeAddedQuestionsInEconomicPage()
    {
        $question = factory(VendorProfileQuestion::class)->create([
            'page' => 'economic'
        ]);
        $vendor = factory(User::class)->states(['vendor', 'finishedSetup'])->create();

        $qResponse = new VendorProfileQuestionResponse([
            'question_id' => $question->id,
            'vendor_id' => $vendor->id,
        ]);
        $qResponse->save();

        $response = $this->actingAs($vendor)
            ->get('vendors/profile');

        $response->assertOk();
        $response->assertSee($question->label);
    }

    public function testCanSeeAddedQuestionsInLegalPage()
    {
        $question = factory(VendorProfileQuestion::class)->create([
            'page' => 'legal'
        ]);
        $vendor = factory(User::class)->states(['vendor', 'finishedSetup'])->create();

        $qResponse = new VendorProfileQuestionResponse([
            'question_id' => $question->id,
            'vendor_id' => $vendor->id,
        ]);
        $qResponse->save();

        $response = $this->actingAs($vendor)
            ->get('vendors/profile');

        $response->assertOk();
        $response->assertSee($question->label);
    }

    public function testCanNotAccessIfVendorHasNotFinishedSetUp()
    {
        $user = factory(User::class)->states('vendor')->create();
        $response = $this
            ->actingAs($user)
            ->get('/vendors/profile');

        $response->assertStatus(404);
    }
}
