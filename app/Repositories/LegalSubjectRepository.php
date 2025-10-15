<?php

namespace App\Repositories;

use App\Interfaces\LegalSubjectInterface;
use App\Models\LegalSubject;
use App\Models\SubjectArticleLink;

class LegalSubjectRepository implements LegalSubjectInterface
{
    public function index($items = 10)
    {
        return LegalSubject::paginate(40);
    }

    public function store(array $data)
    {
        return LegalSubject::create($data);
    }

    public function show(string $id)
    {
        $legal_subject = LegalSubject::with([
            'legal_subject',           // Parent
            'legal_subjects',          // Enfants
            'subject_article_links.article.legal_text',  // Articles liés avec leur texte légal
            'jurisprudences'
        ])->findOrFail($id);

        // Récupérer les articles liés directement depuis les liens
        $legal_subject->linked_articles = $legal_subject->subject_article_links->map(function ($link) {
            return $link->article;
        })->values();

        return $legal_subject;
    }

    public function update(string $id, array $data)
    {
        $item = LegalSubject::findOrFail($id);
        $item->update($data);
        return $item;
    }

    public function destroy(string $id)
    {
        $item = LegalSubject::findOrFail($id);
        return $item->delete();
    }

    public function linkArticleToSubject(array $data)
    {
        return SubjectArticleLink::create($data);
    }


}