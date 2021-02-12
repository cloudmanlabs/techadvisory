<?php

namespace App\Exports\Sheets;

use App\SelectionCriteriaQuestionResponse;
use App\Project;
use App\UseCase;
use App\User;
use App\UserCredential;
use App\VendorApplication;
use App\VendorUseCasesEvaluation;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;

class AnalyticsExportUseCasesSheet implements FromCollection, WithTitle
{
    /** @var Project $project */
    private $project;
    /** @var array $vendorIds */
    private $vendorIds;

    public function __construct(Project$project, array $vendorIds)
    {
        $this->project = $project;
        $this->vendorIds = $vendorIds;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $vendorIds = $this->vendorIds;
        $useCases = UseCase::findByProject($this->project->id);
        $useCaseIds = [];
        foreach ($useCases as $useCase) {
            $useCaseIds[] = $useCase->id;
        }

        $useCaseIndexedEvaluations = VendorUseCasesEvaluation::getGroupedByUseCaseAndVendor($useCaseIds, $vendorIds);
//        error_log('$indexedEvaluations: '.json_encode($useCaseIndexedEvaluations));
        $return = [];

        foreach ($useCaseIndexedEvaluations as $useCaseId => $userIndexedEvaluations) {
            $useCase = UseCase::find($useCaseId);
            foreach ($userIndexedEvaluations as $userCredentialId => $evaluations) {
                foreach ($evaluations as $evaluation) {
                    error_log('$userCredentialId: '.$userCredentialId);
                    error_log('$evaluation->evaluation_type: '.$evaluation->evaluation_type);
                    $user = $evaluation->evaluation_type === 'client' ? UserCredential::find($userCredentialId) : User::find($userCredentialId);
                    error_log('$user: '.json_encode($user));
                    $vendor = User::find($evaluation->vendor_id);
                    $return[] = [
                        'Use Case' => $useCase->name,
                        'User' => $user->name,
                        'Vendor' => $vendor->name,
                        'Solution Fit' => $evaluation->solution_fit,
                        'Usability' => $evaluation->usability,
                        'Performance' => $evaluation->performance,
                        'Look $ Feel' => $evaluation->look_feel,
                        'Others' => $evaluation->others,
                    ];
                }

            }
        }

        $return = collect($return);

        $return->prepend([
            'Use Case',
            'User',
            'Vendor',
            'Solution Fit',
            'Usability',
            'Performance',
            'Look $ Feel',
            'Others',
        ]);

        return $return;
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Use Cases';
    }
}
