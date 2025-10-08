<?php

namespace App\Http\Controllers\LegalContext;

use App\Http\Controllers\Controller;
use App\Http\Requests\LegalSubjects\LegalSubjectCreateRequest;
use App\Http\Requests\LegalSubjects\LegalSubjectUpdateRequest;
use App\Http\Resources\LegalSubjects\LegalSubjectResources;
use App\Repositories\LegalSubjectRepository;
use App\Traits\JsonTrait;

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
}
