<?php

namespace App\Policies;

use App\SelectionCriteriaQuestionProjectPivot;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SelectionCriteriaQuestionProjectPivotPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, SelectionCriteriaQuestionProjectPivot $question)
    {
        return true;
    }

    public function create(User $user)
    {
        return true;
    }

    public function update(User $user, SelectionCriteriaQuestionProjectPivot $question)
    {
        if($user->isAdmin()) return true;
        if($question->question->fixed) return false;

        return true;
    }

    public function delete(User $user, SelectionCriteriaQuestionProjectPivot $question)
    {
        if ($user->isAdmin()) return true;
        if ($question->question->fixed) return false;

        return true;
    }
}
