<?php

namespace App\Http\Controllers\Accenture;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class ClientVendorListController extends Controller
{
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

    public function vendorList()
    {
        return view('accentureViews.vendorList', [
            'vendors' => User::vendorUsers()->get()
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
