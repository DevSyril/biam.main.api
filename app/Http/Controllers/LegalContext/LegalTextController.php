<?php

namespace App\Http\Controllers\LegalContext;

use App\Http\Controllers\Controller;
use App\Http\Requests\LegalContext\LegalTextCreateRequest;
use App\Http\Requests\LegalContext\LegalTextUpdateRequest;
use App\Http\Resources\LegalText\LegalTextResource;
use App\Repositories\LegalTextRepository;
use App\Traits\JsonTrait;
use Illuminate\Http\Request;

class LegalTextController extends Controller
{
    use JsonTrait;
    protected LegalTextRepository $legalTextRepository;
    public  function __construct(LegalTextRepository $legalTextRepository)
    {
        $this->legalTextRepository = $legalTextRepository;
    }


    public function index(Request $request)
    {
        try {
            $legal_texts = $this->legalTextRepository->index($request->get('items', 10));

            return $this->successResponseWithPaginate(LegalTextResource::class, $legal_texts);

        } catch (\Throwable $th) {

            return $this->errorResponse($th->getMessage(), 500);
        }
    }


    public function store(LegalTextCreateRequest $request)
    {
        try {
            $data = array_filter($request->all(), function ($value) {
                return $value !== null && $value !== '';
            });

            $legal_text = $this->legalTextRepository->store($data);

            return $this->successResponse(new LegalTextResource($legal_text), 'Legal text created successfully', 201);

        } catch (\Throwable $th) {

            return $this->errorResponse($th->getMessage(), 500);
        }
    }



    public function show($id)
    {
        try {
            $legal_text = $this->legalTextRepository->show($id);

            return $this->successResponse(new LegalTextResource($legal_text), 'Legal text retrieved successfully');

        } catch (\Throwable $th) {

            return $this->errorResponse($th->getMessage(), 500);
        }
    }


    public function update(LegalTextUpdateRequest $request, $id)
    {
        try {
            $data = array_filter($request->all(), function ($value) {
                return $value !== null && $value !== '';
            });

            $legal_text = $this->legalTextRepository->update($id, $data);

            return $this->successResponse(new LegalTextResource($legal_text), 'Legal text updated successfully');

        } catch (\Throwable $th) {

            return $this->errorResponse($th->getMessage(), 500);
        }
    }


    public function destroy($id)
    {
        try {
            $this->legalTextRepository->destroy($id);

            return $this->successResponse(null, 'Legal text deleted successfully');

        } catch (\Throwable $th) {

            return $this->errorResponse($th->getMessage(), 500);
        }
    }


    public function abrogate($id)
    {
        try {
            $legal_text = $this->legalTextRepository->abrogate($id);

            return $this->successResponse(new LegalTextResource($legal_text), 'Legal text abrogated successfully');

        } catch (\Throwable $th) {

            return $this->errorResponse($th->getMessage(), 500);
        }
    }
}
