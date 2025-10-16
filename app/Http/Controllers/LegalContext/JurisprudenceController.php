<?php

namespace App\Http\Controllers\LegalContext;

use App\Http\Controllers\Controller;
use App\Http\Requests\Jurisprudence\JurisprudenceCreateRequest;
use App\Http\Requests\Jurisprudence\JurisprudenceUpdateRequest;
use App\Http\Resources\Jurisprudence\JurisprudenceResource;
use App\Repositories\JurisprudenceRepository;
use App\Traits\JsonTrait;

class JurisprudenceController extends Controller
{
    use JsonTrait;

    protected JurisprudenceRepository $jurisprudenceRepository;

    public function __construct(JurisprudenceRepository $jurisprudenceRepository)
    {
        $this->jurisprudenceRepository = $jurisprudenceRepository;
    }

    public function index()
    {
        try {
            $items = request()->get('items', 10);

            $data = $this->jurisprudenceRepository->index($items);

            return $this->successResponseWithPaginate(JurisprudenceResource::class, $data);

        } catch (\Throwable $th) {

            return $this->errorResponse($th->getMessage(), 500);
            
        }
    }

    public function store(JurisprudenceCreateRequest $request)
    {
        try {
            $data = $request->validated();
            $jurisprudence = $this->jurisprudenceRepository->store($data);
            return $this->successResponse(new JurisprudenceResource($jurisprudence), 'Jurisprudence created successfully', 201);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage(), 500);
        }
    }

    public function show($id)
    {
        try {
            $jurisprudence = $this->jurisprudenceRepository->show($id);
            return $this->successResponse(new JurisprudenceResource($jurisprudence));
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage(), 500);
        }
    }

    public function update(JurisprudenceUpdateRequest $request, $id)
    {
        try {
            $data = $request->validated();
            $jurisprudence = $this->jurisprudenceRepository->update($id, $data);
            return $this->successResponse(new JurisprudenceResource($jurisprudence), 'Jurisprudence updated successfully');
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage(), 500);
        }
    }

    public function destroy($id)
    {
        try {
            $this->jurisprudenceRepository->destroy($id);
            return $this->successResponse(null, 'Jurisprudence deleted successfully');
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage(), 500);
        }
    }
}
