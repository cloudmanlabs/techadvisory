<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Practice;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home()
    {
        $practices = Practice::all()->pluck('name');

        return view('vendorViews.home', [
            'practices' => $practices,
        ]);
    }
}
