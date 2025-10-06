<?php

namespace App\Http\Controllers\Fields;

use App\Http\Controllers\Controller;
use App\Http\Requests\Fields\TemplateFieldCreateRequest;
use App\Http\Requests\Fields\TemplateFieldUpdateRequest;
use App\Http\Resources\Fields\TemplateFieldResources;
use App\Repositories\TemplateFieldRepository;
use App\Traits\JsonTrait;
use Illuminate\Http\Request;

class TemplateFieldController extends Controller
{
    private TemplateFieldRepository $templateFieldRepository;

    public function __construct(TemplateFieldRepository $templateFieldRepository)
    {
        $this->templateFieldRepository = $templateFieldRepository;
    }

    use JsonTrait;

    public function index()
    {
        try {

            $template_fields = $this->templateFieldRepository->index();

            return $this->successResponseWithPaginate(TemplateFieldResources::class, $template_fields);

        } catch (\Throwable $th) {

            return $this->errorResponse($th->getMessage(), 500);
        }
    }



    public function store(TemplateFieldCreateRequest $request)
    {
        try {

            $data = array_filter($request->all(), function ($value) {
                return $value !== null && $value !== '';
            });

            if (isset($data['visibility_rules'])) {
                $data['visibility_rules'] = json_encode($data['visibility_rules']);
            }

            if (isset($data['validation_schema'])) {
                $data['validation_schema'] = json_encode($data['validation_schema']);
            }

            if (isset($data['conditional_logic'])) {
                $data['conditional_logic'] = json_encode($data['conditional_logic']);
            }

            $template_field = $this->templateFieldRepository->store($data);

            return $this->successResponse($template_field, 'Template field created successfully', 201);

        } catch (\Throwable $th) {

            return $this->errorResponse($th->getMessage(), 500);
        }
    }


    public function show($id)
    {
        try {

            $template_field = $this->templateFieldRepository->show($id);

            return $this->successResponse($template_field, 'Template field retrieved successfully');

        } catch (\Throwable $th) {

            return $this->errorResponse($th->getMessage(), 500);
        }
    }


    public function update(TemplateFieldUpdateRequest $request, $id)
    {
        try {

            $data = array_filter($request->all(), function ($value) {
                return $value !== null && $value !== '';
            });

            if (isset($data['visibility_rules'])) {
                $data['visibility_rules'] = json_encode($data['visibility_rules']);
            }
            if (isset($data['validation_schema'])) {
                $data['validation_schema'] = json_encode($data['validation_schema']);
            }
            if (isset($data['conditional_logic'])) {
                $data['conditional_logic'] = json_encode($data['conditional_logic']);
            }

            $template_field = $this->templateFieldRepository->update($id, $data);

            return $this->successResponse($template_field, 'Template field updated successfully');

        } catch (\Throwable $th) {

            return $this->errorResponse($th->getMessage(), 500);
        }
    }


    public function destroy($id)
    {
        try {

            $this->templateFieldRepository->destroy($id);

            return $this->successResponse(null, 'Template field deleted successfully');

        } catch (\Throwable $th) {

            return $this->errorResponse($th->getMessage(), 500);
        }
    }
}
