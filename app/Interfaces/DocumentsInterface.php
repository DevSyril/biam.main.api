<?php

namespace App\Interfaces;

interface DocumentsInterface
{
    public function documentsList(int $amount = 10);
    public function getDocumentById(string $id);
    public function createDocument(array $data);
    public function updateDocument($id, array $data);
    public function deleteDocument(string $id);
    public function getByCategory(string $category, int $amount = 10);
    public function searchDocuments(string $searchTerm, int $amount = 10);
}
