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

    /*
   public function applicationsInProjectsWithThisPracticeOld()
    {
        return $this->projects->map(function (Project $project) {
            return $project->vendorApplications->count();
        })->sum();
    }
    */

    // FILTERED
    public function applicationsInProjectsWithThisPractice($regions = [], $years = [])
    {

        $query = $this->projects()->select('id', 'regions', 'created_at');
        if ($regions) {
            $query = $query->where(function ($query) use ($regions) {
                for ($i = 0; $i < count($regions); $i++) {
                    $query = $query->orWhere('regions', 'like', '%' . $regions[$i] . '%');
                }
            });
        }

        if ($years) {
            $query = $query->where(function ($query) use ($years) {
                for ($i = 0; $i < count($years); $i++) {
                    $query = $query->orWhere('created_at', 'like', '%' . $years[$i] . '%');
                }
            });
        }

        $query = $query->get()->map(function (Project $project) {
            return $project->vendorApplications->count();
        })->sum();

        return $query;

    }
/*
    public function numberOfProjectsByVendor(User $vendor)
    {
        return $this->projects->filter(function (Project $project) use ($vendor) {
            return $vendor->hasAppliedToProject($project);
        })->count();
    }*/

    public function numberOfProjectsByVendor(User $vendor, $regions = [], $years = [])
    {
        $query = $this->projects()->select('id', 'regions', 'created_at');
        if ($regions) {
            $query = $query->where(function ($query) use ($regions) {
                for ($i = 0; $i < count($regions); $i++) {
                    $query = $query->orWhere('regions', 'like', '%' . $regions[$i] . '%');
                }
            });
        }

        if ($years) {
            $query = $query->where(function ($query) use ($years) {
                for ($i = 0; $i < count($years); $i++) {
                    $query = $query->orWhere('created_at', 'like', '%' . $years[$i] . '%');
                }
            });
        }

        $query = $query->get()->filter(function (Project $project) use ($vendor) {
            return $vendor->hasAppliedToProject($project);
        })->count();

        return $query;
    }


}
