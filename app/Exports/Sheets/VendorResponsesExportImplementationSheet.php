<?php

namespace App\Exports\Sheets;

use App\SelectionCriteriaQuestionResponse;
use App\VendorApplication;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;

class VendorResponsesExportImplementationSheet implements FromCollection, WithTitle
{
    /** @var VendorApplication $application */
    private $application;

    public function __construct(VendorApplication $application)
    {
        $this->application = $application;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $result = [
            [
                'Implementation'
            ],
            [
                'Solutions used',
                implode(', ', $this->application->solutionsUsed ?? []) // TODO Change this to display the names
            ],
        ];

        if($this->application->deliverables != null){
            $result[] = [''];
            $result[] = [
                'Deliverables per phase',
                'Title',
                'Deliverable'
            ];
            foreach ($this->application->deliverables as $key => $deliverable) {
                $result[] = [
                    $key + 1,
                    $deliverable['title'],
                    $deliverable['deliverable']
                ];
            }
        }


        if($this->application->raciMatrix != null){
            $result[] = [''];
            $result[] = [
                'RACI Matrix'
            ];
            $result[] = [
                '',
                'Title',
                'Client',
                'Vendor',
                'Accenture'
            ];
            foreach ($this->application->raciMatrix as $key => $row) {
                $result[] = [
                    $key + 1,
                    $row['title'],
                    $row['client'],
                    $row['vendor'],
                    $row['accenture']
                ];
            }
        }

        $result[] = [''];
        $result[] = [
            'Implementation Cost',
        ];
        if($this->application->project->isBinding){
            if($this->application->staffingCost != null){
                $result[] = [''];
                $result[] = [
                    'Staffing Cost',
                ];
                $result[] = [
                    'Title',
                    'Estimated number of hours',
                    'Hourly rate',
                    'Staffing cost'
                ];
                $totalStaffing = 0;
                foreach ($this->application->staffingCost as $key => $row) {
                    $result[] = [
                        $row['title'],
                        $row['hours'],
                        $row['rate'],
                        $row['cost']
                    ];
                    $totalStaffing += $row['cost'];
                }
                $result[] = [
                    '',
                    '',
                    '',
                    $totalStaffing
                ];
            }
            if ($this->application->travelCost != null) {
                $result[] = [''];
                $result[] = [
                    'Travel Cost',
                ];
                $result[] = [
                    'Title',
                    'Monthly travel cost',
                ];
                $totalStaffing = 0;
                foreach ($this->application->travelCost as $key => $row) {
                    $result[] = [
                        $row['title'],
                        $row['cost'],
                    ];
                    $totalStaffing += $row['cost'];
                }
                $result[] = [
                    '',
                    $totalStaffing
                ];
            }
            if ($this->application->additionalCost != null) {
                $result[] = [''];
                $result[] = [
                    'Additional Cost',
                ];
                $result[] = [
                    'Title',
                    'Cost',
                ];
                $totalAdditional = 0;
                foreach ($this->application->additionalCost as $key => $row) {
                    $result[] = [
                        $row['title'],
                        $row['cost'],
                    ];
                    $totalAdditional += $row['cost'];
                }
                $result[] = [
                    '',
                    $totalAdditional
                ];
            }

            $result[] = [''];
            $result[] = [
                'Overall Implementation Cost',
                $this->application->implementationCost()
            ];
        } else {
            $result[] = [''];
            $result[] = ['Overall Implementation Cost'];
            $result[] = [
                'Min',
                $this->application->overallImplementationMin ?? ''
            ];
            $result[] = [
                'Max',
                $this->application->overallImplementationMax ?? ''
            ];

            $result[] = ['Total Staffing cost (%)'];
            $result[] = [
                'Percentage',
                $this->application->staffingCostNonBinding ?? ''
            ];
            $result[] = [
                'Comments',
                $this->application->staffingCostNonBindingComments ?? ''
            ];


            $result[] = ['Total Travel cost (%)'];
            $result[] = [
                'Percentage',
                $this->application->travelCostNonBinding ?? ''
            ];
            $result[] = [
                'Comments',
                $this->application->travelCostNonBindingComments ?? ''
            ];


            $result[] = ['Total Additional cost (%)'];
            $result[] = [
                'Percentage',
                $this->application->additionalCostNonBinding ?? ''
            ];
            $result[] = [
                'Comments',
                $this->application->additionalCostNonBindingComments ?? ''
            ];
        }

        $result[] = [''];
        $result[] = [''];
        $result[] = [
            'Run',
        ];

        // TODO Add nonbinding here

        if ($this->application->project->isBinding) {
            if ($this->application->estimate5Years != null) {
                $result[] = [''];
                $result[] = [
                    'Estimate first 5 years billing plan',
                ];
                $totalRun = 0;
                foreach ($this->application->estimate5Years as $key => $value) {
                    $result[] = [
                        'Year ' . (intval($key) + 1),
                        $value,
                    ];
                    $totalRun += $value;
                }

                $result[] = [
                    'Total Run Cost',
                    $totalRun,
                ];
                $result[] = [
                    'Average Yearly Cost',
                    $this->application->averageRunCost(),
                ];
            }
        } else {
            $result[] = ['Average yearly cost'];
            $result[] = [
                'Min',
                $this->application->averageYearlyCostMin ?? ''
            ];
            $result[] = [
                'Max',
                $this->application->averageYearlyCostMax ?? ''
            ];

            $result[] = ['Total run cost'];
            $result[] = [
                'Min',
                $this->application->totalRunCostMin ?? ''
            ];
            $result[] = [
                'Max',
                $this->application->totalRunCostMax ?? ''
            ];

            if ($this->application->estimate5Years != null) {
                $result[] = [''];
                $result[] = [
                    'Estimate first 5 years billing plan',
                ];
                foreach ($this->application->estimate5Years as $key => $value) {
                    $result[] = [
                        'Year ' . (intval($key) + 1) . ' (% out of total run cost)',
                        $value,
                    ];
                }

                $result[] = [
                    'Average Yearly Cost',
                    $this->application->averageRunCost(),
                ];
            }
        }

        return collect($result);
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Implementation';
    }
}
