<?php

namespace App\Http\Controllers\Documents;

use App\Http\Controllers\Controller;
use App\Http\Requests\Documents\TemplateCreateRequest;
use App\Http\Resources\Documents\TemplateResources;
use App\Interfaces\TemplateInterface;
use App\Repositories\TemplateRepository;
use App\Traits\JsonTrait;
use Illuminate\Http\Request;

class TemplateController extends Controller
{
    private TemplateRepository $templateRepository;

    use JsonTrait;

    public function __construct(
        TemplateRepository $templateRepository
    ) {
        $this->templateRepository = $templateRepository;
    }


    public function index()
    {
        try {

            $templates = $this->templateRepository->index();

            return $this->successResponseWithPaginate(TemplateResources::class, $templates);

        } catch (\Throwable $th) {

            return $this->rollback();

        }
    }


    public function store(TemplateCreateRequest $request)
    {
        $data = array_filter($request->all(), function ($value) {
            return $value !== null && $value !== '';
        });

        try {

            $template = $this->templateRepository->store($data);

            return $this->successResponse(new TemplateResources($template), 'Template créé avec succès.', 201);

        } catch (\Exception $th) {

            return $this->failed($th->getMessage(), 500);

        }

    }


    public function show(string $id)
    {
        try {
            $template = $this->templateRepository->show($id);

            return $this->successResponse(new TemplateResources($template), 'Template récupéré avec succès.', 200);

        } catch (\Throwable $th) {

            return $this->failed($th->getMessage(), 500);

        }
    }


    public function update(Request $request, string $id)
    {
        $data = array_filter($request->all(), function ($value) {
            return $value !== null ?? $value !== '';
        });

        if (isset($data['content'])) {
            $data['content'] = json_encode($data['content']);
        }

        try {
            $template = $this->templateRepository->update($id, $data);

            return $this->successResponse(new TemplateResources($template), 'Template mis à jour avec succès.', 200);

        } catch (\Throwable $th) {

            return $this->failed('Echec de la mise à jour du template', 500);

        }
    }


    public function destroy(string $id)
    {
        try {
            $this->templateRepository->destroy($id);

            return $this->deleted('Template supprimé avec succès.');

        } catch (\Throwable $th) {

            return $this->failed('Echec de la suppression du template', 500);

        }
    }


    public function documentsTemplates(string $documentId)
    {
        try {

            $templates = $this->templateRepository->getDocumentTemplates($documentId);

            return $this->successResponse($templates, 'Templates du document récupérés avec succès.', 200);

        } catch (\Throwable $th) {

            return $this->failed($th->getMessage(), 500);

        }
    }

}
