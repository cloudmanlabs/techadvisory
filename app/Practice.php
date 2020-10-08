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
        $regions = ['Worldwide', 'EMEA'];
        $query = $this->projects();
        if ($regions) {
            $query = $query->where(function ($query) use ($regions) {
                for ($i = 0; $i < count($regions); $i++) {
                    $query = $query->orWhere('regions', 'like', '%' . $regions[$i] . '%');
                }
            });
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
