<?php


namespace App\Http\Controllers\Accenture;


use App\Http\Controllers\Controller;

class BenchmarkController extends Controller
{

    public function overviewGeneral()
    {
        $example = 1;

        return View('accentureViews.benchmarkOverview', [
            'example' => $example,
        ]);
    }

    public function overviewHistorical()
    {

    }

    public function overviewVendor()
    {

    }

    public function projectResults()
    {
        $this->projectResultsOverall();
    }

    public function projectResultsOverall()
    {
        $example = 2;

        return View('accentureViews.benchmarkProjectResults', [
            'example' => $example,
        ]);
    }

    public function projectResultsFitgap()
    {

    }

    public function projectResultsVendor()
    {

    }

}
