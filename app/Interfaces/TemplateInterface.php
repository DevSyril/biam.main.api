<?php

namespace App\Interfaces;

interface TemplateInterface
{
    public function index(int $items = 10);

    public function store(array $data);

    public function show(string $id);

    public function update(string $id, array $data);

    public function destroy(string $id);

    public function getDocumentTemplates(string $documentId);
    
    public function setHeaderFooter(array $data);

}
