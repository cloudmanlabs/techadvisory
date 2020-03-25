<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use \Illuminate\Database\Eloquent\Builder;

/**
 * @property string $userType Should be one of [admin, accenture, accentureAdmin, client, vendor]
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
        return $this->userType == 'accenture' || $this->userType == 'accentureAdmin';
    }

    /**
     * Returns true if the user is a client
     *
     * @return boolean
     */
    public function isClient(): bool
    {
        return $this->userType == 'client';
    }

    /**
     * Returns true if the user is a vendor
     *
     * @return boolean
     */
    public function isVendor(): bool
    {
        return $this->userType == 'vendor';
    }

    /**
     * Returns all the Accenture users
     *
     * @return Builder
     */
    public static function accentureUsers() : Builder
    {
        return User::whereIn('userType', User::accentureTypes);
    }

    /**
     * Returns all the Client Users
     *
     * @return Builder
     */
    public static function clientUsers() : Builder
    {
        return User::whereIn('userType', User::clientTypes);
    }

    /**
     * Returns all the Vendor Users
     *
     * @return Builder
     */
    public static function vendorUsers() : Builder
    {
        return User::whereIn('userType', User::vendorTypes);
    }
}
