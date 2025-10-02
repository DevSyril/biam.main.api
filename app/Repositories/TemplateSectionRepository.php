<?php

namespace App\Repositories;

use App\Interfaces\TemplateSectionInterface;
use App\Models\Template;
use App\Models\TemplateSection;

class TemplateSectionRepository implements TemplateSectionInterface
{
    public function index(int $items = 10)
    {
        return TemplateSection::all();
    }

    public function show(string $id)
    {
        $template = TemplateSection::findOrFail($id);
        $template->load('template_fields');
        return $template;
    }

    public function store(array $data)
    {
        return TemplateSection::create($data);
    }

    public function update(string $id, array $data)
    {
        return TemplateSection::findOrFail($id)->update($data);
    }

    public function destroy(string $id)
    {
        return TemplateSection::findOrFail($id)->delete();
    }

    public function getTemplateSections(string $templateId)
    {
        $template = Template::findOrFail($templateId);
        $sections = $template->template_sections();

        return $sections;
    }
}
