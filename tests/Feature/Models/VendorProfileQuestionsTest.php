<?php

namespace Tests\Feature\Models;

use App\User;
use App\VendorProfileQuestion;
use App\VendorProfileQuestionResponse;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class VendorProfileQuestionsTest extends TestCase
{
    use RefreshDatabase;

    public function testCanCreateVendorProfileQuestion()
    {
        $this->assertCount(0, VendorProfileQuestion::all());

        $question = new VendorProfileQuestion([
            'label' => 'How are you?',
            'type' => 'text'
        ]);
        $question->save();

        $this->assertCount(1, VendorProfileQuestion::all());
    }

    public function testCanCreateVendorProfileQuestionWithPlaceholder()
    {
        $this->assertCount(0, VendorProfileQuestion::all());

        $question = new VendorProfileQuestion([
            'label' => 'How are you?',
            'type' => 'text',

            'placeholder' => 'HELLOOOOO'
        ]);
        $question->save();

        $this->assertCount(1, VendorProfileQuestion::all());
    }

    public function testCanCreateVendorProfileQuestionWithPage()
    {
        $this->assertCount(0, VendorProfileQuestion::all());

        $question = new VendorProfileQuestion([
            'label' => 'How are you?',
            'type' => 'text',

            'page' => 'legal'
        ]);
        $question->save();

        $this->assertCount(1, VendorProfileQuestion::all());
    }

    public function testCanRespondQuestion()
    {
        // Create the question
        $question = factory(VendorProfileQuestion::class)->create();
        $vendor = factory(User::class)->states(['vendor', 'finishedSetup'])->create();
        $response = new VendorProfileQuestionResponse([
            'vendor_id' => $vendor->id,
            'question_id' => $question->id,
        ]);
        $response->save();

        $this->assertNull($response->response);
        $response->response = 'answer';
        $response->save();
        $this->assertNotNull($response->response);
    }

    public function testResponseIsDeletedWhenQuestionIsDeleted()
    {
        $question = factory(VendorProfileQuestion::class)->create();
        $vendor = factory(User::class)->states(['vendor', 'finishedSetup'])->create();

        $this->assertCount(1, $vendor->vendorProfileQuestions);

        $question->delete();

        $vendor->refresh();
        $this->assertCount(0, $vendor->vendorProfileQuestions);
    }

    public function testChangingAQuestionResetsTheResponses()
    {
        $question = factory(VendorProfileQuestion::class)->create([
            'type' => 'selectMultiple',
            'label' => 'Transport Type',
            'presetOption' => 'transportTypes'
        ]);
        $vendor = factory(User::class)->states(['vendor', 'finishedSetup'])->create();

        // Set a response
        $response = VendorProfileQuestionResponse::first();
        $this->assertNull($response->response);
        $response->response = 'hello';
        $response->save();

        $response->refresh();
        $this->assertNotNull($response->response);

        // Change the question
        $question->type = 'selectSingle';
        $question->save();

        // CHekc that the response was reset
        $response->refresh();
        $this->assertNull($response->response);
    }


    public function testCanChangeResponseWithPost()
    {
        $question = factory(VendorProfileQuestion::class)->create();
        $vendor = factory(User::class)->states('vendor')->create();

        $qResponse = new VendorProfileQuestionResponse([
            'question_id' => $question->id,
            'vendor_id' => $vendor->id,
        ]);
        $qResponse->save();

        $response = $this->actingAs($vendor)
            ->post('/vendors/profile/changeResponse', [
                'changing' => $qResponse->id,
                'value' => 'newText'
            ]);

        $response->assertOk();

        $qResponse->refresh();
        $this->assertEquals('newText', $qResponse->response);
    }

    public function testVendorCanOnlyChangeOwnProfileQuestionResponses()
    {
        $question = factory(VendorProfileQuestion::class)->create();
        $owner = factory(User::class)->states('vendor')->create();
        $changer = factory(User::class)->states('vendor')->create();

        $qResponse = new VendorProfileQuestionResponse([
            'question_id' => $question->id,
            'vendor_id' => $owner->id,
        ]);
        $qResponse->save();

        $response = $this->actingAs($changer)
            ->post('/vendors/profile/changeResponse', [
                'changing' => $qResponse->id,
                'value' => 'newText'
            ]);

        $response->assertStatus(403);

        $qResponse->refresh();
        $this->assertNull($qResponse->response);
    }

    public function testCanCreateFixedQuestion()
    {
        $this->assertCount(0, VendorProfileQuestion::all());

        $question = new VendorProfileQuestion([
            'label' => 'How are you?',
            'type' => 'text',

            'fixed' => true,
            'fixedQuestionIdentifier' => 'vendorPractice',
        ]);
        $question->save();

        $this->assertCount(1, VendorProfileQuestion::all());
    }

    public function testCanGetFixedQuestionFromVendor()
    {
        factory(VendorProfileQuestion::class)->create([
            'page' => 'general',
            'label' => 'Practice',
            'type' => 'selectSingle',
            'presetOption' => 'practices',

            'fixed' => true,
            'fixedQuestionIdentifier' => 'vendorPractice',
        ]);
        $vendor = factory(User::class)->states(['vendor', 'finishedSetup'])->create();

        // Set a response
        $response = VendorProfileQuestionResponse::first();
        $response->response = 'hello';
        $response->save();

        $this->assertEquals('hello', $vendor->getVendorResponse('vendorPractice'));
    }

    public function testAQuestionNotAnsweredReturnsTheDefaultValue()
    {
        factory(VendorProfileQuestion::class)->create([
            'page' => 'general',
            'label' => 'Practice',
            'type' => 'selectSingle',
            'presetOption' => 'practices',

            'fixed' => true,
            'fixedQuestionIdentifier' => 'vendorPractice',
        ]);
        $vendor = factory(User::class)->states(['vendor', 'finishedSetup'])->create();
        $this->assertEquals('default', $vendor->getVendorResponse('vendorPractice', 'default'));
    }
}
