<?php

namespace App\Http\Controllers\Documents;

use App\Http\Controllers\Controller;
use App\Http\Requests\Documents\TemplateSectionCreateRequest;
use App\Http\Requests\Documents\TemplateSectionUpdateRequest;
use App\Interfaces\TemplateSectionInterface;
use App\Repositories\TemplateSectionRepository;
use App\Traits\JsonTrait;
use Illuminate\Http\Request;

class TemplateSectionController extends Controller
{

    use JsonTrait;
    private TemplateSectionRepository $templateSectionRepository;
    public function __construct(TemplateSectionRepository $templateSectionRepository)
    {
        $this->templateSectionRepository = $templateSectionRepository;
    }


    public function index()
    {
        try {

            $sections = $this->templateSectionRepository->index();
            return $this->successResponse($sections, 'Template sections retrieved successfully');

        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }


    public function show($id)
    {
        try {

            $section = $this->templateSectionRepository->show($id);
            return $this->successResponse($section, 'Template section retrieved successfully');

        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }


    public function store(TemplateSectionCreateRequest $request)
    {
        try {

            $data = array_filter(
                $request->all(),
                fn($value) => !is_null($value) && $value !== ''
            );

            $data['content'] = json_encode($data['content']);

            $section = $this->templateSectionRepository->store($data);
            return $this->successResponse($section, 'Template section created successfully', 201);

        } catch (\Exception $e) {

            return $this->errorResponse($e->getMessage(), 500);

        }
    }


    public function update(TemplateSectionUpdateRequest $request, $id)
    {
        try {

            $data = array_filter(
                $request->all(),
                fn($value) => !is_null($value) && $value !== ''
            );

            $section = $this->templateSectionRepository->update($id, $data);
            return $this->successResponse($section, 'Template section updated successfully');

        } catch (\Exception $e) {

            return $this->errorResponse($e->getMessage(), 500);

        }
    }


    public function destroy(string $id)
    {
        try {

            $this->templateSectionRepository->destroy($id);
            return $this->successResponse(null, 'Template section deleted successfully');

        } catch (\Exception $e) {

            return $this->errorResponse($e->getMessage(), 500);

        }
    }

    public function getTemplateSections(string $templateId)
    {
        try {

            $sections = $this->templateSectionRepository->getTemplateSections($templateId);
            return $this->successResponse($sections, 'Template sections retrieved successfully');

        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }
}
