<?php

namespace App\Http\Controllers\Accenture;

use App\Http\Controllers\Controller;
use App\User;
use App\VendorSolution;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ClientVendorListController extends Controller
{
    public function createClientPost(Request $request)
    {
        $client = new User([
            'userType' => 'client',
            'name' => 'New client',
            'email' => 'newUser@example.com',
            'password' => Hash::make('password')
        ]);
        $client->save();

        return redirect()->route('accenture.clientProfileEdit', ['client' => $client]);
    }


    public function clientList()
    {
        return view('accentureViews.clientList', [
            'clients' => User::clientUsers()->get()
        ]);
    }

    public function clientProfileView(User $client)
    {
        return view('accentureViews.clientProfileView', [
            'client' => $client,
            'questions' => $client->clientProfileQuestions
        ]);
    }

    public function clientProfileEdit(User $client)
    {
        return view('accentureViews.clientProfileEdit', [
            'client' => $client,
            'questions' => $client->clientProfileQuestions
        ]);
    }



    public function createVendorPost(Request $request)
    {
        $vendor = new User([
            'userType' => 'vendor',
            'name' => 'New client',
            'email' => 'newUser@example.com',
            'password' => Hash::make('password')
        ]);
        $vendor->save();

        return redirect()->route('accenture.vendorProfileView', ['vendor' => $vendor]);
    }


    public function vendorList()
    {
        return view('accentureViews.vendorList', [
            'vendors' => User::vendorUsers()->get(),
            'vendorSolutions' => VendorSolution::all()
        ]);
    }

    public function vendorProfileView(User $vendor)
    {
        $generalQuestions = $vendor->vendorProfileQuestions->filter(function ($question) {
            return $question->original->page == 'general';
        });
        $economicQuestions = $vendor->vendorProfileQuestions->filter(function ($question) {
            return $question->original->page == 'economic';
        });
        $legalQuestions = $vendor->vendorProfileQuestions->filter(function ($question) {
            return $question->original->page == 'legal';
        });

        return view('accentureViews.vendorProfileView', [
            'vendor' => $vendor,
            'generalQuestions' => $generalQuestions,
            'economicQuestions' => $economicQuestions,
            'legalQuestions' => $legalQuestions,
        ]);
    }

    public function vendorProfileEdit(User $vendor)
    {
        $generalQuestions = $vendor->vendorProfileQuestions->filter(function ($question) {
            return $question->original->page == 'general';
        });
        $economicQuestions = $vendor->vendorProfileQuestions->filter(function ($question) {
            return $question->original->page == 'economic';
        });
        $legalQuestions = $vendor->vendorProfileQuestions->filter(function ($question) {
            return $question->original->page == 'legal';
        });

        return view('accentureViews.vendorProfileEdit', [
            'vendor' => $vendor,
            'generalQuestions' => $generalQuestions,
            'economicQuestions' => $economicQuestions,
            'legalQuestions' => $legalQuestions,
        ]);
    }
}
