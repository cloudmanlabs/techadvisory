<?php

namespace App\Policies;

use App\User;
use App\VendorApplication;
use Illuminate\Auth\Access\HandlesAuthorization;

class VendorApplicationPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, VendorApplication $object)
    {
        return true;
    }

    public function create(User $user)
    {
        // They can't create one through nova cause we gotta do other stuff
        return false;
    }

    public function update(User $user, VendorApplication $object)
    {
        return true;
    }

    public function delete(User $user, VendorApplication $object)
    {
        return false;
    }
}
