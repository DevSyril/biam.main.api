<?php

namespace App\Interfaces;

interface LegalSubjectInterface
{
    public function index($items = 10);
    public function store(array $data);
    public function show(string $id);
    public function update(string $id, array $data);
    public function destroy(string $id);
    public function linkArticleToSubject(array $data);
}
        