<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $name
 */
class Practice extends Model
{
    public $guarded = [];

    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    public function selectionCriteriaQuestions()
    {
        return $this->hasMany(SelectionCriteriaQuestion::class);
    }

    public function applicationsInProjectsWithThisPractice()
    {
        return $this->projects->map(function (Project $project) {
            return $project->vendorApplications->count();
        })->sum();
    }

    // METHODS FOR BENCHMARK *****************************************************************
    public function numberOfProjectsByVendor(User $vendor)
    {
        return $this->projects->filter(function (Project $project) use ($vendor) {
            return $vendor->hasAppliedToProject($project);
        })->count();
    }

    // Next two dont work
    public function numberOfProjectsByVendorFilterRegion(User $vendor)
    {
        $region = 'Worldwide';
        return $this->projects->where('regions', 'like', '%' . $region . '%')
            ->filter(function (Project $project) use ($vendor) {
                return $vendor->hasAppliedToProject($project);
            })->count();
    }
    public function numberOfProjectsByVendorFilterYear(User $vendor)
    {
        $region = 'Worldwide';
        return $this->projects->where('regions', 'like', '%' . $region . '%')
            ->filter(function (Project $project) use ($vendor) {
                return $vendor->hasAppliedToProject($project);
            })->count();
    }

}
