<?php

namespace App\Http\Controllers\Accenture;

use App\Http\Controllers\Controller;
use App\Practice;
use App\Project;
use App\User;
use Illuminate\Http\Request;

class AnalysisController extends Controller
{
    public function vendor()
    {
        return view('accentureViews.analysisVendor', [
            'practices' => Practice::all(),
            'vendors' => User::vendorUsers()->where('hasFinishedSetup', true)->get()
        ]);
    }

    public function client()
    {
        return view('accentureViews.analysisClient', [
            'practices' => Practice::all(),
            'clients' => User::clientUsers()->where('hasFinishedSetup', true)->get(),

            'industries' => collect(config('arrays.industryExperience'))->map(function($industry){
                return (object)[
                    'name' => $industry,
                    'projectCount' => Project::all()->filter(function ($project) use ($industry) {
                        return $project->industry == $industry;
                    })->count()
                ];
            }),
            'regions' => collect(config('arrays.regions'))->map(function ($region) {
                return (object)[
                    'name' => $region,
                    'projectCount' => Project::all()->filter(function ($project) use ($region) {
                        return in_array($region, $project->regions ?? []);
                    })->count()
                ];
            }),
        ]);
    }

    public function historical()
    {
        // Holy shit this code is attrocious
        // Pls clean up sometime b4 the next 3 years

        return view('accentureViews.analysisHistorical', [
            'practices' => Practice::all(),
            'years' => collect(range(2017, intval(date('Y')) ))->map(function($year){
                return (object)[
                    'year' => $year,
                    'projectCount' => Project::all()->filter(function($project) use ($year){
                        return $project->created_at->year == $year;
                    })->count(),
                ];
            }),
            'industries' => collect(config('arrays.industryExperience'))->map(function ($industry) {
                return (object) [
                    'name' => $industry,
                    'projectCounts' => collect(range(2017, intval(date('Y')) ))->map(function($year) use ($industry){
                        return Project::all()->filter(function ($project) use ($year, $industry) {
                            return $project->created_at->year == $year && $project->industry == $industry;
                        })->count();
                    }),
                ];
            }),
            'regions' => collect(config('arrays.regions'))->map(function ($region) {
                return (object) [
                    'name' => $region,
                    'projectCounts' => collect(range(2017, intval(date('Y')) ))->map(function($year) use ($region){
                        return Project::all()->filter(function ($project) use ($year, $region) {
                            return $project->created_at->year == $year && in_array($region, $project->regions ?? []);
                        })->count();
                    }),
                ];
            }),
        ]);
    }
}
