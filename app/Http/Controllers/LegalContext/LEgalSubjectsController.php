<?php

namespace App\Http\Controllers\LegalContext;

use App\Http\Controllers\Controller;
use App\Http\Requests\LegalSubjects\LegalSubjectCreateRequest;
use App\Http\Requests\LegalSubjects\LegalSubjectUpdateRequest;
use App\Http\Resources\LegalSubjects\LegalSubjectResources;
use App\Repositories\LegalSubjectRepository;
use App\Rules\CustomRules\UniqueSubjectArticleCombination;
use App\Traits\JsonTrait;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class LEgalSubjectsController extends Controller
{
    use JsonTrait;

    protected LegalSubjectRepository $legalSubjectRepository;
    public function __construct(LegalSubjectRepository $legalSubjectRepository)
    {
        $this->legalSubjectRepository = $legalSubjectRepository;
    }


    public function index()
    {
        try {

            $items = request()->get('items', 10);

            $data = $this->legalSubjectRepository->index($items);

            return $this->successResponseWithPaginate(LegalSubjectResources::class, $data, 'data');

        } catch (\Throwable $th) {

            return $this->errorResponse($th->getMessage(), 500);
        }
    }


    public function show($id)
    {
        try {

            $data = $this->legalSubjectRepository->show($id);
            return $this->successResponse(new LegalSubjectResources($data), 'data');

        } catch (\Throwable $th) {

            return $this->errorResponse($th->getMessage(), 500);
        }
    }


    public function store(LegalSubjectCreateRequest $request)
    {
        try {
            $data = array_filter($request->all(), function ($value) {
                return $value !== null && $value !== '';
            });

            $legal_subject = $this->legalSubjectRepository->store($data);

            return $this->successResponse(new LegalSubjectResources($legal_subject), 'Legal subject created successfully', 201);

        } catch (\Throwable $th) {

            return $this->errorResponse($th->getMessage(), 500);
        }
    }


    public function update(LegalSubjectUpdateRequest $request, $id)
    {
        try {
            $data = array_filter($request->all(), function ($value) {
                return $value !== null && $value !== '';
            });

            $legal_subject = $this->legalSubjectRepository->update($id, $data);

            return $this->successResponse(new LegalSubjectResources($legal_subject), 'Legal subject updated successfully', 200);

        } catch (\Throwable $th) {

            return $this->errorResponse($th->getMessage(), 500);
        }
    }


    public function destroy($id)
    {
        try {

            $this->legalSubjectRepository->destroy($id);
            return $this->successResponse(null, 'Legal subject deleted successfully', 200);

        } catch (\Throwable $th) {

            return $this->errorResponse($th->getMessage(), 500);
        }
    }


    public function linkArticleToSubject(Request $request)
    {
        try {
            $data = $request->validate([
                'subject_id' => 'required|uuid|exists:pgsql_secondary.legal_subject,id',
                'article_id' => [
                    'required',
                    'uuid',
                    'exists:pgsql_secondary.article,id',
                    Rule::unique('pgsql_secondary.subject_article_link')
                        ->where('subject_id', $request->subject_id)
                        ->where('article_id', $request->article_id)
                ],
                'relevance' => 'nullable|integer',
                'context_commentary' => 'nullable|string',
                'usage_example' => 'nullable|string',
            ], [
                // Messages pour subject_id
                'subject_id.required' => 'Le champ subject_id est requis.',
                'subject_id.uuid' => 'Le subject_id doit être un UUID valide.',
                'subject_id.exists' => 'Le subject_id spécifié n\'existe pas.',

                // Messages pour article_id
                'article_id.required' => 'Le champ article_id est requis.',
                'article_id.uuid' => 'L\'article_id doit être un UUID valide.',
                'article_id.exists' => 'L\'article_id spécifié n\'existe pas.',
                'article_id.unique' => 'Cet article est déjà lié à ce sujet.',

                // Message pour relevance
                'relevance.integer' => 'La pertinence doit être un nombre entier.',
            ]);

            $link = $this->legalSubjectRepository->linkArticleToSubject($data);

            return $this->successResponse($link, 'Article lié au sujet avec succès', 201);

        } catch (\Throwable $th) {

            return $this->errorResponse($th->getMessage(), 500);
        }
    }

}
