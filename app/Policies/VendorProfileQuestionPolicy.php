<?php

namespace App\Policies;

use App\User;
use App\VendorProfileQuestion;
use Illuminate\Auth\Access\HandlesAuthorization;

class VendorProfileQuestionPolicy
{
    use HandlesAuthorization;


    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, VendorProfileQuestion $question)
    {
        return true;
    }

    public function create(User $user)
    {
        return true;
    }

    public function update(User $user, VendorProfileQuestion $question)
    {
        if ($user->isAdmin()) return true;
        if ($question->fixed) return false;

        return true;
    }

    public function delete(User $user, VendorProfileQuestion $question)
    {
        if ($user->isAdmin()) return true;
        if ($question->fixed) return false;

        return true;
    }
}
