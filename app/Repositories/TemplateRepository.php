<?php

namespace App\Repositories;

use App\Interfaces\TemplateInterface;
use App\Models\AvailableDocument;
use App\Models\LegalSubject;
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
        // $template->template_sections->load('template_fields');
        // $template->template_sections->each(function ($section) {
        //     $section->template_fields->load('form_field');
        //     // $section->template_fields->legal_articles = $this->getSectionLegalSubjects($section->template_fields->legal_slug); 
        //     $section->legal_basis = $this->getSectionLegalSubjects($section->legal_slug);
        // });

        $template->template_sections->each(function ($section) {
            $section->content = json_decode($section->content, true);
        });

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

    public function getSectionLegalSubjects(string $slug)
    {
        $legal_subjects = LegalSubject::where('slug', $slug)->get();
        $legal_articles = $legal_subjects->flatMap(function ($subject) {
            return $subject->subject_article_links->map(function ($link) {
                $article = $link->article;
                $article->load('legal_text');
                return $article;
            });
        });
        return $legal_articles;
    }


}
