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
    public function vendorAppliedProjects($phase = null) : \Illuminate\Database\Eloquent\Builder
    {
        return Project::whereHas('vendorApplications', function (Builder $query) use ($phase) {
            if($phase == null){
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
    public function applyToProject(Project $project) : ?VendorApplication
    {
        // Only vendors who have finished setup can apply
        if(!$this->isVendor()) throw new \Exception('Calling applyToProject on a non-vendor User');
        if(!$this->hasFinishedSetup) throw new \Exception('Trying to apply to project with a user that hasn\'t finished setup');

        $existingApplication = VendorApplication::where([
            'project_id' => $project->id,
            'vendor_id' => $this->id
        ])->first();
        if($existingApplication){
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
        if ($project->selectionCriteriaQuestionsForVendor($this)->count() == 0)
        {
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

    public function hasAppliedToProject(Project $project) : bool
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
            ->map(function ($application){
                return $application->totalScore();
            })
            ->average();
    }

    public function averageRanking()
    {
        return $this->vendorApplications
            ->map(function ($application) {
                return $application->ranking();
            })
            ->average();
    }



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
    public function isAdmin() : bool
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
    public static function accentureUsers() : Builder
    {
        return self::whereIn('userType', self::accentureTypes);
    }

    /**
     * Returns all the Client Users
     *
     * @return Builder
     */
    public static function clientUsers() : Builder
    {
        return self::whereIn('userType', self::clientTypes);
    }

    /**
     * Returns all the Vendor Users
     *
     * @return Builder
     */
    public static function vendorUsers() : Builder
    {
        return self::whereIn('userType', self::vendorTypes);
    }
}
