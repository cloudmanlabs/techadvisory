<?php


namespace App;


/**
 * @property string $name
 * @property string $description
 *
 *
 */
class UseCaseTemplate extends \Illuminate\Database\Eloquent\Model
{
    public $guarded = [];

    public function practice()
    {
        return $this->belongsTo(Practice::class);
    }

    public function useCaseQuestionUseCaseTemplatePivots()
    {
        return $this->hasMany(UseCaseQuestionUseCaseTemplatePivot::class, 'use_case_templates_id');
    }

    /**
     * @return mixed
     */
    public function useCaseQuestionsOriginals()
    {
        $questionIds = UseCaseQuestionUseCaseTemplatePivot::where('use_case_templates_id', $this->id)
            ->pluck('use_case_questions_id')->toArray();
        $uniqueIds = array_values(array_unique($questionIds));

        return UseCaseQuestion::find($uniqueIds);
    }

    /**
     * METHOD FOR NOVA
     * The questions that are NOT linked to the project yet, in order to select them.
     * @return array Array of questions: [question id] => question label
     */
    public function useCaseQuestionsAvailablesForMe()
    {
        $allQuestionsIDasArray =
            UseCaseQuestion::all('id')->pluck('id')->toArray();
        $myUseCaseQuestionsIDs =
            $this->useCaseQuestionsOriginals()->pluck('id')->toArray();

        if ($allQuestionsIDasArray) {
            foreach ($allQuestionsIDasArray as $key => $question) {
                if (in_array($question, $myUseCaseQuestionsIDs)) {
                    unset($allQuestionsIDasArray[$key]);
                }
            }
        }

        // Only for Nova Structure: [question id] => question label
        $questionsStructureForNova = [];
        foreach ($allQuestionsIDasArray as $question) {
            $useCaseQuestion = UseCaseQuestion::find($question);
            $questionsStructureForNova[$useCaseQuestion->id] = $useCaseQuestion->label;
        }

        return $questionsStructureForNova;
    }

}
