<?php

namespace App\Http\Controllers\Accenture;

use App\Http\Controllers\Controller;
use App\Practice;
use App\Project;
use App\User;
use Illuminate\Http\Request;

class AnalysisController extends Controller
{
    public function projectVendor()
    {
        return view('accentureViews.analysisProjectVendor', [
            'practices' => Practice::all(),
            'vendors' => User::vendorUsers()->where('hasFinishedSetup', true)->get()
        ]);
    }

    public function projectClient()
    {
        return view('accentureViews.analysisProjectClient', [
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

    public function projectHistorical()
    {
        // Holy shit this code is attrocious
        // Pls clean up sometime b4 the next 3 years

        return view('accentureViews.analysisProjectHistorical', [
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

    public function projectCustom()
    {
        return view('accentureViews.analysisProjectCustom', [
            'practices' => Practice::pluck('name')->toArray(),
            'clients' => User::clientUsers()->where('hasFinishedSetup', true)->pluck('name')->toArray(),
            'vendors' => User::vendorUsers()->where('hasFinishedSetup', true)->pluck('name')->toArray(),
            'regions' => collect(config('arrays.regions')),
            'industries' => collect(config('arrays.industryExperience')),
            'years' => collect(range(2017, intval(date('Y')))),

            'projects' => Project::all(),
        ]);
    }


    public function vendorGraphs()
    {
        return view('accentureViews.analysisVendorGraphs', [
            'practices' => Practice::all()->map(function(Practice $practice) {
                return (object)[
                    'name' => $practice->name,
                    'count' => User::vendorUsers()->get()->filter(function(User $vendor) use ($practice){
                        return $vendor->getVendorResponse('vendorPractice') == $practice->name;
                    })->count(),
                ];
            }),
            'industries' => collect(config('arrays.industryExperience'))->map(function ($industry) {
                return (object) [
                    'name' => $industry,
                    'count' => User::vendorUsers()->get()->filter(function (User $vendor) use ($industry) {
                        return $vendor->getVendorResponse('vendorIndustry') == $industry;
                    })->count(),
                ];
            }),
            'regions' => collect(config('arrays.regions'))->map(function ($region) {
                return (object) [
                    'name' => $region,
                    'count' => User::vendorUsers()->get()->filter(function (User $vendor) use ($region) {
                        return in_array($region, json_decode($vendor->getVendorResponse('vendorRegions')) ?? []);
                    })->count(),
                ];
            }),
        ]);
    }

    public function vendorCustom()
    {
        return view('accentureViews.analysisVendorCustom', [
            'practices' => Practice::all(),
            'vendors' => User::vendorUsers()->where('hasFinishedSetup', true)->get()
        ]);
    }
}
