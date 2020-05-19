<?php

namespace App\Policies;

use App\User;
use App\SelectionCriteriaQuestionResponse;
use Illuminate\Auth\Access\HandlesAuthorization;

class SelectionCriteriaQuestionResponsePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, SelectionCriteriaQuestionResponse $question)
    {
        return true;
    }

    public function create(User $user)
    {
        return true;
    }

    public function update(User $user, SelectionCriteriaQuestionResponse $question)
    {
        return true;
    }

    public function delete(User $user, SelectionCriteriaQuestionResponse $question)
    {
        if ($user->isAdmin()) return true;
        if ($question->originalQuestion->fixed) return false;

        return true;
    }
}
