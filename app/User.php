<?php

namespace App;

use Exception;
use Guimcaballero\LaravelFolders\Models\Folder;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use \Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Log;
use Laravel\Nova\Fields\Boolean;

/**
 * @property string $userType Should be one of [admin, accenture, accentureAdmin, client, vendor]
 * @property string $hasFinishedSetup
 * @property string|null $enterpriseId
 * @property string|null $region
 */
class User extends Authenticatable
{

    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'userType'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the owner from this user.
     */
    public function owner()
    {
        return $this->belongsTo(Owner::class, 'owner_id', 'id')->first();;
    }

    /**
     * Magia para que funcione el Nova de Owner project
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owners()
    {
        return $this->belongsTo(Owner::class, 'owner_id', 'id');
    }

    public function credentials()
    {
        return $this->hasMany(UserCredential::class, 'user_id');
    }


    public function profileFolder()
    {
        return $this->morphOne(Folder::class, 'folderable');
    }

    public function projectsClient()
    {
        return $this->hasMany(Project::class, 'client_id');
    }


    public function clientProfileQuestions()
    {
        return $this->hasMany(ClientProfileQuestionResponse::class, 'client_id');
    }

    public function vendorSolutions()
    {
        return $this->hasMany(VendorSolution::class, 'vendor_id');
    }

    public function vendorProfileQuestions()
    {
        return $this->hasMany(VendorProfileQuestionResponse::class, 'vendor_id');
    }

    public function vendorApplications()
    {
        return $this->hasMany(VendorApplication::class, 'vendor_id');
    }

    public function vendorSolutionsPractices()
    {
        return $this->vendorSolutions
            ->map(function (VendorSolution $sol) {
                return $sol->practice;
            })
            ->filter(function ($smth) {
                return $smth != null;
            })
            ->unique('id')
            ->values();
    }

    public function vendorSolutionsPracticesNames(): string
    {
        $practices = $this->vendorSolutionsPractices();

        if ($practices->count() == 0) return 'None';

        return implode(', ', $practices->pluck('name')->toArray());
    }

    /**
     * @return array that this vendor has applied on any project.
     */
    public function vendorAppliedSubpractices()
    {
        $myAppliedProjects = $this->vendorAppliedProjects()->get();
        $subpracticesApplied = [];
        $subpracticesAppliedIDs = [];

        if (!empty($myAppliedProjects)) {

            foreach ($myAppliedProjects as $project) {
                $subpracticesPivotApplied = $project->subpractices()->get();

                if (!empty($subpracticesPivotApplied)) {

                    foreach ($subpracticesPivotApplied as $subpractice) {
                        array_push($subpracticesAppliedIDs, $subpractice->pivot->subpractice_id);
                    }
                }
            }
            if (!empty($subpracticesAppliedIDs)) {
                foreach ($subpracticesAppliedIDs as $subpracticeId) {
                    $subpractice = Subpractice::find($subpracticeId);
                    array_push($subpracticesApplied, $subpractice);
                }
            }
            $subpracticesApplied = collect($subpracticesApplied);
        }
        return $subpracticesApplied->pluck('name')->toArray();
    }

    /**
     * Returns the responses from a specific scope, a sub-type of a SC Capability Response
     * The scope has to be a parameter in id, because of the database design.
     *  9: scope_id for transportFlow
     *  10: scope_id for transportMode
     *  11: scope_id for transportType
     *  4: scope_id for Planning
     *  5: scope_id for Manufacturing
     * @param int $scope_id [9,10,11,4,5]
     * @return |null
     */
    public function getVendorResponsesFromScope(int $scope_id)
    {
        $result = null;
        if (array_search($scope_id, [4, 5, 9, 10, 11])) {

            $SolutionsFromVendor = $this->vendorSolutions()->get();  // vendor_solutions
            foreach ($SolutionsFromVendor as $vs) {
                $questionsResponses = $vs->questions()
                    ->where('question_id', '=', $scope_id)
                    ->get();                                       // vendor_solution_question_responses

                foreach ($questionsResponses as $response) {
                    if (!empty($response->response)) {
                        $result = $response->response;
                    }
                }
            }
        }

        return $result;
    }

    // TODO Implement fixed and fixedQuestionIdentifier for clientProfileQuestions
    public function getClientResponse(string $label, $default = null)
    {
        $response = $this->clientProfileQuestions()->whereHas('originalQuestion', function ($query) use ($label) {
            $query->where('label', $label);
        })->first();

        return $response->response ?? $default;
    }

    public function getVendorResponse(string $identifier, $default = null)
    {
        $response = $this->vendorProfileQuestions()->whereHas('originalQuestion', function ($query) use ($identifier) {
            $query->where('fixed', true)->where('fixedQuestionIdentifier', $identifier);
        })->first();

        return $response->response ?? $default;
    }

    /**
     * Returns the project this vendor has applied to
     *
     * @param string[]|null $phase
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function vendorAppliedProjects($phase = null): \Illuminate\Database\Eloquent\Builder
    {
        return Project::whereHas('vendorApplications', function (Builder $query) use ($phase) {
            if ($phase == null) {
                $query->where('vendor_id', $this->id);
            } else {
                $query->where('vendor_id', $this->id)->whereIn('phase', $phase);
            }
        });
    }

    /**
     * Applies to project or returns the existing application
     *
     * @param Project $project Project to apply to
     * @return VendorApplication|null
     *
     * @throws Exception
     */
    public function applyToProject(Project $project): ?VendorApplication
    {
        // Only vendors who have finished setup can apply
        if (!$this->isVendor()) throw new \Exception('Calling applyToProject on a non-vendor User');
        if (!$this->hasFinishedSetup) throw new \Exception('Trying to apply to project with a user that hasn\'t finished setup');

        $existingApplication = VendorApplication::where([
            'project_id' => $project->id,
            'vendor_id' => $this->id
        ])->first();
        if ($existingApplication) {
            return $existingApplication;
        }

        $application = new VendorApplication([
            'project_id' => $project->id,
            'vendor_id' => $this->id,

            'phase' => 'invitation'
        ]);
        $application->save();

        // If there are no questions attached (the vendor wasn't previously in this project), we add the questions
        // If there are some questions attached, it means that when the vendor was previously attached, so we don't want to add them again
        if ($project->selectionCriteriaQuestionsForVendor($this)->count() == 0) {
            foreach (SelectionCriteriaQuestion::all() as $key2 => $question) {
                $response = new SelectionCriteriaQuestionResponse([
                    'question_id' => $question->id,
                    'project_id' => $project->id,
                    'vendor_id' => $this->id
                ]);
                $response->save();
            }
        }

        return $application;
    }

    public function hasAppliedToProject(Project $project): bool
    {
        if (!$this->isVendor()) throw new \Exception('Calling hasAppliedToProject on a non-vendor User');
        if (!$this->hasFinishedSetup) throw new \Exception('Checking if user has applied to project with a user that hasn\'t finished setup');

        $existingApplication = VendorApplication::where([
            'project_id' => $project->id,
            'vendor_id' => $this->id
        ])->first();
        if ($existingApplication) {
            return true;
        } else {
            return false;
        }
    }

    public function averageScore()
    {
        return $this->vendorApplications
            ->filter(function (VendorApplication $application) {
                return $application->project != null;
            })
            ->map(function ($application) {
                return $application->totalScore();
            })
            ->average();
    }

    public function averageScoreFitgap(){
        return $this->vendorApplications
            ->filter(function (VendorApplication $application) {
                return $application->project != null;
            })
            ->map(function ($application) {
                return $application->fitgapScore();
            })
            ->average();
    }

    public function averageScoreFitgapFunctional(){
        return $this->vendorApplications
            ->filter(function (VendorApplication $application) {
                return $application->project != null;
            })
            ->map(function ($application) {
                return $application->fitgapFunctionalScore();
            })
            ->average();
    }

    public function averageScoreFitgapTechnical(){
        return $this->vendorApplications
            ->filter(function (VendorApplication $application) {
                return $application->project != null;
            })
            ->map(function ($application) {
                return $application->fitgapTechnicalScore();
            })
            ->average();
    }

    public function averageScoreFitgapService(){
        return $this->vendorApplications
            ->filter(function (VendorApplication $application) {
                return $application->project != null;
            })
            ->map(function ($application) {
                return $application->fitgapServiceScore();
            })
            ->average();
    }

    public function averageScoreFitgapOthers(){
        return $this->vendorApplications
            ->filter(function (VendorApplication $application) {
                return $application->project != null;
            })
            ->map(function ($application) {
                return $application->fitgapOtherScore();
            })
            ->average();
    }

    public function averageScoreVendor(){
        return $this->vendorApplications
            ->filter(function (VendorApplication $application) {
                return $application->project != null;
            })
            ->map(function ($application) {
                return $application->vendorScore();
            })
            ->average();
    }

    public function averageScoreExperience(){
        return $this->vendorApplications
            ->filter(function (VendorApplication $application) {
                return $application->project != null;
            })
            ->map(function ($application) {
                return $application->experienceScore();
            })
            ->average();
    }

    public function averageScoreInnovation(){
        return $this->vendorApplications
            ->filter(function (VendorApplication $application) {
                return $application->project != null;
            })
            ->map(function ($application) {
                return $application->innovationScore();
            })
            ->average();
    }

    public function averageScoreImplementation(){
        return $this->vendorApplications
            ->filter(function (VendorApplication $application) {
                return $application->project != null;
            })
            ->map(function ($application) {
                return $application->implementationScore();
            })
            ->average();
    }

    public function averageScoreImplementationImplementation(){
        return $this->vendorApplications
            ->filter(function (VendorApplication $application) {
                return $application->project != null;
            })
            ->map(function ($application) {
                return $application->implementationImplementationScore();
            })
            ->average();
    }

    public function averageScoreImplementationRun(){
        return $this->vendorApplications
            ->filter(function (VendorApplication $application) {
                return $application->project != null;
            })
            ->map(function ($application) {
                return $application->implementationRunScore();
            })
            ->average();
    }

    public function averageRanking()
    {
        return $this->vendorApplications
            ->filter(function (VendorApplication $application) {
                return $application->project != null;
            })
            ->map(function (VendorApplication $application) {
                return $application->ranking();
            })
            ->average();
    }

    const allTypes = [
        'accenture' => 'Accenture',
        'accentureAdmin' => 'Accenture Admin',
        'vendor' => 'Vendor',
        'client' => 'Client'
    ];

    /**
     * Available Admin types
     *
     * @var array
     */
    const adminTypes = ['admin'];
    /**
     * Available Accenture types
     *
     * @var array
     */
    const accentureTypes = ['accenture', 'accentureAdmin'];
    /**
     * Available Client types
     *
     * @var array
     */
    const clientTypes = ['client'];
    /**
     * Available Vendor types
     *
     * @var array
     */
    const vendorTypes = ['vendor'];

    /**
     * Returns true if the user is admin
     *
     * @return boolean
     */
    public function isAdmin(): bool
    {
        return $this->userType == 'admin';
    }

    /**
     * Returns true if the user is Accenture
     *
     * @return boolean
     */
    public function isAccenture(): bool
    {
        return $this->userType == 'accenture'
            || $this->usertype == 'accenture' // It's really fun, cause sometimes with observers and nova the property gets lowercased
            || $this->userType == 'accentureAdmin'
            || $this->usertype == 'accentureAdmin';
    }

    /**
     * Returns true if the user is Accenture Admin
     *
     * @return boolean
     */
    public function isAccentureAdmin(): bool
    {
        return $this->userType == 'accentureAdmin'
            || $this->usertype == 'accentureAdmin';
    }


    /**
     * Returns true if the user is a client
     *
     * @return boolean
     */
    public function isClient(): bool
    {
        return $this->userType == 'client'
            || $this->usertype == 'client';
    }

    /**
     * Returns true if the user is a vendor
     *
     * @return boolean
     */
    public function isVendor(): bool
    {
        return $this->userType == 'vendor'
            || $this->usertype == 'vendor';
    }

    /**
     * Returns all the Accenture users
     *
     * @return Builder
     */
    public static function accentureUsers(): Builder
    {
        return self::whereIn('userType', self::accentureTypes);
    }

    /**
     * Returns all the Client Users
     *
     * @return Builder
     */
    public static function clientUsers(): Builder
    {
        return self::whereIn('userType', self::clientTypes);
    }

    /**
     * Returns all the Vendor Users
     *
     * @return Builder
     */
    public static function vendorUsers(): Builder
    {
        return self::whereIn('userType', self::vendorTypes);
    }

    // Methods for obtain general data for Benchmark & analitycs **********************************************

    public static function bestVendorsScoreOverall($numberOfVendors)
    {
        $vendors = User::vendorUsers()->where('hasFinishedSetup', true)->get();
        $vendorScores = [];
        foreach ($vendors as $vendor) {
            $vendorScores[$vendor->id] = doubleval($vendor->averageScore());
        }
        arsort($vendorScores);
        if (is_integer($numberOfVendors)) {
            $vendorScores = array_slice($vendorScores, 0, $numberOfVendors, true);
        }
        return $vendorScores;
    }

    public static function bestVendorsScoreFitgap($numberOfVendors)
    {
        $vendors = User::vendorUsers()->where('hasFinishedSetup', true)->get();
        $vendorScores = [];
        foreach ($vendors as $vendor) {
            $vendorScores[$vendor->id] = doubleval($vendor->averageScoreFitgap());
        }
        arsort($vendorScores);
        $vendorScores = array_slice($vendorScores, 0, 5, true);
        return $vendorScores;
    }

    public static function bestVendorsScoreFitgapFunctional($numberOfVendors)
    {
        $vendors = User::vendorUsers()->where('hasFinishedSetup', true)->get();
        $vendorScores = [];
        foreach ($vendors as $vendor) {
            $vendorScores[$vendor->id] = doubleval($vendor->averageScoreFitgapFunctional());
        }
        arsort($vendorScores);
        $vendorScores = array_slice($vendorScores, 0, 5, true);
        return $vendorScores;
    }

    public static function bestVendorsScoreFitgapTechnical($numberOfVendors)
    {
        $vendors = User::vendorUsers()->where('hasFinishedSetup', true)->get();
        $vendorScores = [];
        foreach ($vendors as $vendor) {
            $vendorScores[$vendor->id] = doubleval($vendor->averageScoreFitgapTechnical());
        }
        arsort($vendorScores);
        $vendorScores = array_slice($vendorScores, 0, 5, true);
        return $vendorScores;
    }

    public static function bestVendorsScoreFitgapService($numberOfVendors)
    {
        $vendors = User::vendorUsers()->where('hasFinishedSetup', true)->get();
        $vendorScores = [];
        foreach ($vendors as $vendor) {
            $vendorScores[$vendor->id] = doubleval($vendor->averageScoreFitgapService());
        }
        arsort($vendorScores);
        $vendorScores = array_slice($vendorScores, 0, 5, true);
        return $vendorScores;
    }

    public static function bestVendorsScoreFitgapOthers($numberOfVendors)
    {
        $vendors = User::vendorUsers()->where('hasFinishedSetup', true)->get();
        $vendorScores = [];
        foreach ($vendors as $vendor) {
            $vendorScores[$vendor->id] = doubleval($vendor->averageScoreFitgapOthers());
        }
        arsort($vendorScores);
        $vendorScores = array_slice($vendorScores, 0, 5, true);
        return $vendorScores;
    }

    public static function bestVendorsScoreVendor($numberOfVendors)
    {
        $vendors = User::vendorUsers()->where('hasFinishedSetup', true)->get();
        $vendorScores = [];
        foreach ($vendors as $vendor) {
            $vendorScores[$vendor->id] = doubleval($vendor->averageScoreVendor());
        }
        arsort($vendorScores);
        $vendorScores = array_slice($vendorScores, 0, 5, true);
        return $vendorScores;
    }

    public static function bestVendorsScoreExperience($numberOfVendors)
    {
        $vendors = User::vendorUsers()->where('hasFinishedSetup', true)->get();
        $vendorScores = [];
        foreach ($vendors as $vendor) {
            $vendorScores[$vendor->id] = doubleval($vendor->averageScoreExperience());
        }
        arsort($vendorScores);
        $vendorScores = array_slice($vendorScores, 0, 5, true);
        return $vendorScores;
    }

    public static function bestVendorsScoreInnovation($numberOfVendors)
    {
        $vendors = User::vendorUsers()->where('hasFinishedSetup', true)->get();
        $vendorScores = [];
        foreach ($vendors as $vendor) {
            $vendorScores[$vendor->id] = doubleval($vendor->averageScoreInnovation());
        }
        arsort($vendorScores);
        $vendorScores = array_slice($vendorScores, 0, 5, true);
        return $vendorScores;
    }

    public static function bestVendorsScoreImplementation($numberOfVendors)
    {
        $vendors = User::vendorUsers()->where('hasFinishedSetup', true)->get();
        $vendorScores = [];
        foreach ($vendors as $vendor) {
            $vendorScores[$vendor->id] = doubleval($vendor->averageScoreImplementation());
        }
        arsort($vendorScores);
        $vendorScores = array_slice($vendorScores, 0, 5, true);
        return $vendorScores;
    }

    public static function bestVendorsScoreImplementationImplementation($numberOfVendors)
    {
        $vendors = User::vendorUsers()->where('hasFinishedSetup', true)->get();
        $vendorScores = [];
        foreach ($vendors as $vendor) {
            $vendorScores[$vendor->id] = doubleval($vendor->averageScoreImplementationImplementation());
        }
        arsort($vendorScores);
        $vendorScores = array_slice($vendorScores, 0, 5, true);
        return $vendorScores;
    }

    public static function bestVendorsScoreImplementationRun($numberOfVendors)
    {
        $vendors = User::vendorUsers()->where('hasFinishedSetup', true)->get();
        $vendorScores = [];
        foreach ($vendors as $vendor) {
            $vendorScores[$vendor->id] = doubleval($vendor->averageScoreImplementationRun());
        }
        arsort($vendorScores);
        $vendorScores = array_slice($vendorScores, 0, 5, true);
        return $vendorScores;
    }
}
