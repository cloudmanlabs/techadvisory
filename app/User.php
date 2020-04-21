<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use \Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Log;

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

    /**
     * Returns the project this vendor has applied to
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function vendorAppliedProjects($phase = null) : \Illuminate\Database\Eloquent\Builder
    {
        return Project::whereHas('vendorApplications', function (Builder $query) use ($phase) {
            if($phase == null){
                $query->where('vendor_id', $this->id);
            } else {
                $query->where('vendor_id', $this->id)->where('phase', $phase);
            }
        });
    }







    /**
     * Applies to project or returns the existing application
     *
     * @param Project $project Project to apply to
     * @return VendorApplication|null
     */
    public function applyToProject(Project $project) : ?VendorApplication
    {
        // Only vendors who have finished setup can apply
        if(!$this->isVendor()) return null;
        if(!$this->hasFinishedSetup) return null;

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

        return $application;
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
