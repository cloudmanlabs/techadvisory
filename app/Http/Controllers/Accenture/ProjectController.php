<?php

namespace App\Http\Controllers\Accenture;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProjectController extends Controller
{
    public function home()
    {
        return view('accentureViews.projectHome');
    }

    public function edit()
    {
        return view('accentureViews.projectEdit');
    }

    public function view()
    {
        return view('accentureViews.projectView');
    }

    public function valueTargeting()
    {
        return view('accentureViews.projectValueTargeting');
    }

    public function orals()
    {
        return view('accentureViews.projectOrals');
    }

    public function conclusions()
    {
        return view('accentureViews.projectConclusions');
    }

    public function benchmark()
    {
        return view('accentureViews.projectBenchmark');
    }

    public function benchmarkFitgap()
    {
        return view('accentureViews.projectBenchmarkFitgap');
    }

    public function benchmarkVendor()
    {
        return view('accentureViews.projectBenchmarkVendor');
    }

    public function benchmarkExperience()
    {
        return view('accentureViews.projectBenchmarkExperience');
    }

    public function benchmarkInnovation()
    {
        return view('accentureViews.projectBenchmarkInnovation');
    }

    public function benchmarkImplementation()
    {
        return view('accentureViews.projectBenchmarkImplementation');
    }

}
