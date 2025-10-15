<?php

namespace App\Rules\CustomRules;

use Closure;
use DB;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Contracts\Validation\ValidationRule;

class UniqueSubjectArticleCombination implements Rule
{
    protected $subjectId;

    public function __construct($subjectId)
    {
        $this->subjectId = $subjectId;
    }

    public function passes($attribute, $value)
    {
        return !DB::connection('pgsql_secondary')
            ->table('subject_article_link')
            ->where('subject_id', $this->subjectId)
            ->where('article_id', $value)
            ->exists();
    }

    public function message()
    {
        return 'Cet article a déjà été lié à ce sujet.';
    }

}
