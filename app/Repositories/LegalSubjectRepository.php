<?php

namespace App\Repositories;

use App\Interfaces\LegalSubjectInterface;
use App\Models\LegalSubject;

class LegalSubjectRepository implements LegalSubjectInterface
{
    public function index($items = 10)
    {
        return LegalSubject::paginate($items);
    }

    public function store(array $data)
    {
        return LegalSubject::create($data);
    }

    public function show(string $id)
    {
        $legal_subject = LegalSubject::findOrFail($id);
        $legal_subject->load('legal_subject', 'legal_subjects', 'subject_article_links', 'jurisprudences');
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
}