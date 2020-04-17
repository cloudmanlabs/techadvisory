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

    public function vendorList()
    {
        return view('accentureViews.vendorList', [
            'vendors' => User::vendorUsers()->get()
        ]);
    }
}
