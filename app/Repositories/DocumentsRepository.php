<?php

namespace App\Repositories;

use App\Interfaces\DocumentsInterface;
use App\Models\AvailableDocument;

class DocumentsRepository implements DocumentsInterface
{

    public function documentsList(int $amount = 10)
    {
        // Logique pour récupérer la liste des documents depuis la source de données
        $documents = AvailableDocument::paginate($amount);

        return $documents;
        // Retourne un tableau de documents s'il y en a ou vide sinon
    }

    public function getDocumentById(string $id)
    {
        // Logique pour récupérer un document par son ID depuis la source de données
        $document = AvailableDocument::findOrFail($id);

        return $document;
        // Retourne le document s'il existe ou null sinon
    }

    public function createDocument(array $data)
    {
        // Logique pour créer un nouveau document dans la source de données
        $document = AvailableDocument::create($data);

        return $document;
        // Retourne le document créé
    }

    public function updateDocument($id, array $data)
    {
        // Logique pour mettre à jour un document existant dans la source de données
        $document = AvailableDocument::findOrFail($id);
        $document->update($data);

        return $document;
        // Retourne le document mis à jour
    }

    public function deleteDocument(string $id)
    {
        // Logique pour supprimer un document existant dans la source de données
        $document = AvailableDocument::findOrFail($id);
        $document->delete();

        return true;
        // Retourne true si la suppression a réussi ou false sinon
    }

    public function getByCategory(string $category, int $amount = 10)
    {
        // Logique pour récupérer des documents par catégorie depuis la source de données
        $documents = AvailableDocument::where('category', $category)->paginate($amount);

        return $documents;
        // Retourne une collection de documents correspondant à la catégorie donnée
    }

    public function searchDocuments(string $searchTerm, int $amount = 10)
    {
        // Logique pour rechercher des documents par titre ou description depuis la source de données
        $documents = AvailableDocument::where('name', 'LIKE', "%$searchTerm%")
            ->orWhere('category', 'LIKE', "%$searchTerm%")
            ->orWhere('description', 'LIKE', "%$searchTerm%")
            ->paginate($amount);

        return $documents;
        // Retourne une collection de documents correspondant au terme de recherche
    }
}
