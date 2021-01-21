<?php


namespace App;

use Illuminate\Database\Eloquent\Model;
use Guimcaballero\LaravelFolders\Models\Folder;
use \Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Collection;

/**
 * @property string $name
 * @property string $description
 * @property string $practice
 *
 * @property Collection $useCaseQuestions
 *
 */
class UseCaseTemplate extends Model
{
    public $guarded = [];

    public function practice()
    {
        return $this->belongsTo(Practice::class);
    }

    public function subpractice()
    {
        return $this->belongsTo(Subpractice::class);
    }

    public function useCaseQuestions()
    {
        return $this->hasMany(UseCaseTemplateQuestionResponse::class, 'use_case_templates_id');
    }
}
