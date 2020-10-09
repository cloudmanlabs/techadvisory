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

    public function projectsFiltered($regions = [], $years = [])
    {
        $query = $this->hasMany(Project::class)->select('id', 'regions', 'created_at');
        $query = $this->benchmarkOverviewFilters($query, $regions, $years);
        $query = $query->count();
        return $query;
    }

    public function applicationsInProjectsWithThisPractice($regions = [], $years = [])
    {

        $query = $this->projects()->select('id', 'regions', 'created_at');
        $query = $this->benchmarkOverviewFilters($query, $regions, $years);

        $query = $query->get()->map(function (Project $project) {
            return $project->vendorApplications->count();
        })->sum();

        return $query;

    }

    public function numberOfProjectsByVendor(User $vendor, $regions = [], $years = [])
    {
        $query = $this->projects()->select('id', 'regions', 'created_at');
        $query = $this->benchmarkOverviewFilters($query, $regions, $years);

        $query = $query->get()->filter(function (Project $project) use ($vendor) {
            return $vendor->hasAppliedToProject($project);
        })->count();

        return $query;
    }

    // Encapsulate the filters for graphics from view: Overview - general
    private function benchmarkOverviewFilters($query, $regions = [], $years = [])
    {
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
        return $query;
    }

// old methods
    /*
public function applicationsInProjectsWithThisPractice()
{
    return $this->projects->map(function (Project $project) {
        return $project->vendorApplications->count();
    })->sum();
}
*/


    /*
        public function numberOfProjectsByVendor(User $vendor)
        {
            return $this->projects->filter(function (Project $project) use ($vendor) {
                return $vendor->hasAppliedToProject($project);
            })->count();
        }*/
}
