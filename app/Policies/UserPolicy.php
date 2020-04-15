<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, User $object)
    {
        if ($object->isAdmin()) return false;

        return true;
    }

    public function create(User $user)
    {
        return $user->isAdmin() || $user->isAccenture();
    }

    public function update(User $user, User $object)
    {
        if($object->isAdmin()) return false;

        return $user->isAdmin() || $user->isAccenture();
    }

    public function delete(User $user, User $object)
    {
        if ($object->isAdmin()) return false;

        if($user->id == $object->id) return false;

        return $user->isAdmin() || $user->isAccenture();
    }
}
