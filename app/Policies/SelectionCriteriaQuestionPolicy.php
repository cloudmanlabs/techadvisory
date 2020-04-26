<?php

namespace App\Policies;

use App\SelectionCriteriaQuestion;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SelectionCriteriaQuestionPolicy
{
    use HandlesAuthorization;



    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, SelectionCriteriaQuestion $question)
    {
        return true;
    }

    public function create(User $user)
    {
        return true;
    }

    public function update(User $user, SelectionCriteriaQuestion $question)
    {
        if($user->isAdmin()) return true;
        if($question->fixed) return false;

        return true;
    }

    public function delete(User $user, SelectionCriteriaQuestion $question)
    {
        if ($user->isAdmin()) return true;
        if ($question->fixed) return false;

        return true;
    }
}
