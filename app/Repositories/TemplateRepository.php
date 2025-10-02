<?php

namespace App\Repositories;

use App\Interfaces\TemplateInterface;
use App\Models\AvailableDocument;
use App\Models\Template;

class TemplateRepository implements TemplateInterface
{

    public function index(int $items = 10)
    {

        $templates = Template::paginate($items);

        return $templates;

    }

    public function store(array $data)
    {

        $template = Template::create($data);

        return $template;

    }

    public function show(string $id)
    {
        $template = Template::findOrFail($id);
        $template->load('template_sections');
        return $template;
    }

    public function update(string $id, array $data)
    {

        $template = Template::findOrFail($id);
        $template->update($data);

        return $template;

    }


    public function destroy(string $id)
    {

        $template = Template::findOrFail($id);
        $template->delete();

        return true;

    }


    public function getDocumentTemplates(string $documentId)
    {

        $document = AvailableDocument::findOrFail($documentId);
        $templates = $document->templates();

        return $templates;

    }


}
