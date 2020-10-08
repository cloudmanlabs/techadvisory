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


    // METHODS FOR BENCHMARK *****************************************************************

    public function applicationsInProjectsWithThisPractice()
    {
        return $this->projects->map(function (Project $project) {
            return $project->vendorApplications->count();
        })->sum();
    }

    // FILTERED
    public function applicationsInProjectsWithThisPractice2()
    {
        $region = 'Worldwide';
        $query = $this->projects();
        if ($region) {
            $query = $query->where('regions', 'like', '%' . $region . '%');
        }
        $query = $query->get()->map(function (Project $project) {
            return $project->vendorApplications->count();
        })->sum();

        return $query;
    }

    public function numberOfProjectsByVendor(User $vendor)
    {
        return $this->projects->filter(function (Project $project) use ($vendor) {
            return $vendor->hasAppliedToProject($project);
        })->count();
    }


}
