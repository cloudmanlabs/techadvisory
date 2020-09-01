<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property string|null $response
 * @property int $score
 *
 * @property SelectionCriteriaQuestion $originalQuestion
 * @property Project $project
 * @property User $vendor
 */
class SelectionCriteriaQuestionResponse extends Model
{
    public $guarded = [];

    public function originalQuestion()
    {
        return $this->belongsTo(SelectionCriteriaQuestion::class, 'question_id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function vendor()
    {
        return $this->belongsTo(User::class, 'vendor_id');
    }

    /**
     * Returns the responses of the most recent similar open project if exists, with their questions.
     * @param $vendor vendor
     * @param $project current
     * @return mixed. null if project not exists
     */
    public static function getResponsesFromSimilarProject($vendor, $project)
    {
        $current_date = date('Y-m-d');
        $date_limit = Carbon::parse($current_date)->addMonths(-12)->format('Y-m-d');    // Date range limit: 1 year ago

        // Query for similar project.
        $similar_project = Project::select('projects.id')
            ->join('selection_criteria_question_responses as scqr', 'scqr.project_id', '=', 'projects.id')
            ->where('projects.practice_id', '=', $project->practice_id)
            ->whereDate('projects.created_at', '>=', $date_limit)
            ->where('projects.id', '!=', $project->id)
            ->where(function ($query) {
                $query->where('projects.currentPhase', '=', 'open')
                    ->orWhere('projects.currentPhase', '=', 'old');
            })->where('scqr.vendor_id', '=', $vendor->id)
            ->whereNotNull('scqr.response')
            ->orderby('projects.created_at', 'DESC')
            ->first();

        if ($similar_project == null) {
            return [];
        }

        return self::select('question_id', 'response')
            ->where('project_id', '=', $similar_project->id)
            ->whereNotNull('response')
            ->where('vendor_id', '=', $vendor->id)
            ->get();
    }
}
