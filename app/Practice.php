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

    public function projectsFilteredToBenchmarkOverview($regions = [], $years = [])
    {
        $query = $this->hasMany(Project::class)->select('id', 'currentPhase', 'regions', 'created_at');
        $query = $this->benchmarkOverviewFilters($query, $regions, $years);
        $query = $query->count();
        return $query;
    }

    public function applicationsInProjectsWithThisPractice($regions = [], $years = [])
    {

        $query = $this->projects()->select('id', 'currentPhase', 'regions', 'created_at');
        $query = $this->benchmarkOverviewFilters($query, $regions, $years);

        $query = $query->get()->map(function (Project $project) {
            return $project->vendorApplications->count();
        })->sum();

        return $query;

    }

    /**
     * @param array $regions
     * @param array $years
     * @return float|int
     * Shows Number of vendors released from old projects by each practice / total old projects by each practice.
     */
    public function averageReleasedApplicationsInOldProjectsWithThisPractice($regions = [], $years = [])
    {

        $query = $this->projects()->select('id', 'currentPhase', 'regions', 'created_at');
        $query = $this->benchmarkOverviewFilters($query, $regions, $years);

        // Total projects
        $totalOldProjects = $query
            ->where('currentPhase', '=', 'old')
            ->count();

        // Number of vendors
        $applicationsReleasedForOldProjectsWithThisPractice = $query->get()
            ->map(function (Project $project) {
                return $project->vendorApplications
                    ->where('phase', '=', 'evaluated')
                    ->count();
            })->sum();

        $average = 0;
        if ($totalOldProjects > 0) {
            // Vendors / Total projects.
            $average = $applicationsReleasedForOldProjectsWithThisPractice / $totalOldProjects;
        }

        return $average;
    }

    public function numberOfProjectsByVendor(User $vendor, $regions = [], $years = [])
    {
        $query = $this->projects()->select('id', 'currentPhase', 'regions', 'created_at');
        $query = $this->benchmarkOverviewFilters($query, $regions, $years);

        $query = $query->get()->filter(function (Project $project) use ($vendor) {
            return $vendor->hasAppliedToProject($project);
        })->count();

        return $query;
    }

    // Encapsulate the filters for graphics from view: Overview - general
    private function benchmarkOverviewFilters($query, $regions = [], $years = [])
    {
        $query = $query->where('currentPhase', '=', 'old');

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

}
