<?php

namespace App\Http\Controllers\Fields;

use App\Http\Controllers\Controller;
use App\Http\Requests\Fields\FieldCreateRequest;
use App\Http\Requests\Fields\FieldUpdateteRequest;
use App\Http\Resources\Fields\FieldResource;
use App\Interfaces\FieldInterface;
use App\Repositories\FieldRepository;
use App\Traits\JsonTrait;
use Illuminate\Http\Request;

class FieldController extends Controller
{
    use JsonTrait;

    private FieldInterface $fieldInterface;
    private FieldRepository $fieldRepository;

    public function __construct(FieldInterface $fieldInterface, FieldRepository $fieldRepository)
    {
        $this->fieldInterface = $fieldInterface;
        $this->fieldRepository = $fieldRepository;
    }


    public function index(Request $request)
    {
        $items = $request->query('items', 10);

        try {

            $fields = $this->fieldRepository->index((int) $items);

            return $this->successResponseWithPaginate(FieldResource::class, $fields);

        } catch (\Exception $e) {

            return $this->errorResponse($e->getMessage(), 500);
        }
    }


    public function show(string $id)
    {
        try {

            $field = $this->fieldRepository->show($id);

            return $this->successResponse(new FieldResource($field), 'Field retrieved successfully');

        } catch (\Exception $e) {

            return $this->errorResponse($e->getMessage(), 500);
        }
    }


    public function store(FieldCreateRequest $request)
    {
        $data = array_filter($request->all(), function ($value) {
            return $value !== null && $value !== '';
        });

        if (isset($data['validation_rules']))
            $data['validation_rules'] = json_encode($data['validation_rules']);

        if (isset($data['options']))
            $data['options'] = json_encode($data['options']);

        try {

            $field = $this->fieldRepository->store($data);

            return $this->successResponse(new FieldResource($field), 'Field created successfully', 201);

        } catch (\Exception $e) {

            return $this->errorResponse($e->getMessage(), 500);
        }
    }


    public function update(FieldUpdateteRequest $request, string $id)
    {
        $data = array_filter($request->all(), function ($value) {
            return $value !== null && $value !== '';
        });

        if (isset($data['validation_rules']))
            $data['validation_rules'] = json_encode($data['validation_rules']);

        if (isset($data['options']))
            $data['options'] = json_encode($data['options']);

        try {

            $this->fieldRepository->update($id, $data);
            $field = $this->fieldRepository->show($id);

            return $this->successResponse(new FieldResource($field), 'Field updated successfully', 200);

        } catch (\Exception $e) {

            return $this->errorResponse($e->getMessage(), 500);
        }
    }


    public function destroy(string $id)
    {
        try {

            $this->fieldRepository->destroy($id);

            return $this->successResponse(null, 'Field deleted successfully', 200);

        } catch (\Exception $e) {

            return $this->errorResponse($e->getMessage(), 500);
        }
    }

}
