<?php


namespace App\Http\Controllers\Accenture;


use App\Http\Controllers\Controller;

class BenchmarkController extends Controller
{
    /**
     * To the father structure.
     * @return \Illuminate\View\View
     */
    public function benchmark()
    {
        $example = 1;

        return View('accentureViews.benchmarkStructure', [
            'example' => $example,
        ]);
    }

    public function overviewGeneral()
    {
        $example = 1;

        return View('accentureViews.benchmarkStructure', [
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

    }

    public function projectResultsFitgap()
    {

    }

    public function projectResultsVendor()
    {

    }

}
