<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function view(User $user)
    {
        return true;
    }

    public function create(User $user)
    {
        return $user->isAdmin();
    }

    public function update(User $user, User $object)
    {
        return $user->isAdmin();
    }

    public function delete(User $user, User $object)
    {
        return $user->isAdmin();
    }
}
