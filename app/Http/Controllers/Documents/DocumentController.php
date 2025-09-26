<?php

namespace App\Http\Controllers\Documents;

use App\Http\Controllers\Controller;
use App\Http\Requests\Documents\DocumentCreateRequest;
use App\Http\Requests\Documents\DocumentUpdateRequest;
use App\Http\Resources\Documents\DocumentsResources;
use App\Interfaces\DocumentsInterface;
use App\Repositories\DocumentsRepository;
use App\Traits\JsonTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private DocumentsInterface $documentsInterface;
    private DocumentsRepository $documentsRepository;

    use JsonTrait;

    public function __construct(
        DocumentsInterface $documentsInterface,
        DocumentsRepository $documentsRepository
    ) {
        $this->documentsInterface = $documentsInterface;
        $this->documentsRepository = $documentsRepository;
    }


    public function index()
    {
        try {

            $documents = $this->documentsRepository->documentsList();

            return $this->successResponseWithPaginate(DocumentsResources::class, $documents);

        } catch (\Throwable $th) {

            return $this->rollback();
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DocumentCreateRequest $request)
    {
        try {

            $data = array_filter($request->all(), function ($value) {
                return $value !== null && $value !== '';
            });

            DB::beginTransaction();

            $document = $this->documentsRepository->createDocument($data);

            DB::commit();

            return response()->json([
                'success' => true,
                'data' => new DocumentsResources($document),
                'message' => 'Document créé avec succès.'
            ], 201);

        } catch (\Throwable $th) {

            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Echec de la création du document.',
                'error' => $th->getMessage()
            ], 500);

        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {

            $document = $this->documentsRepository->getDocumentById($id);

            return response()->json([
                'success' => true,
                'data' => new DocumentsResources($document),
                'message' => 'Document récupéré avec succès.'
            ], 200);

        } catch (\Throwable $th) {

            $this->rollback();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DocumentUpdateRequest $request, string $id)
    {
        try {

            $data = array_filter($request->all(), function ($value) {
                return $value !== null && $value !== '';
            });

            $document = $this->documentsRepository->updateDocument($id, $data);

            return response()->json([
                'success' => true,
                'data' => new DocumentsResources($document),
                'message' => 'Document mis à jour avec succès.'
            ], 200);

        } catch (\Throwable $th) {

            return response()->json([
                'success' => false,
                'message' => 'Echec de la mise à jour du document.',
                'error' => $th->getMessage()
            ], 500);

        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {

            $this->documentsRepository->deleteDocument($id);

            return response()->json([
                'success' => true,
                'data' => null,
                'message' => 'Document supprimé avec succès.'
            ], 200);

        } catch (\Throwable $th) {

            return response()->json([
                'success' => false,
                'message' => 'Echec de la suppression du document.',
                'error' => $th->getMessage()
            ], 500);

        }
    }

    public function getByCategory(string $category)
    {
        try {

            $documents = $this->documentsRepository->getByCategory($category);

            return $this->successResponseWithPaginate(DocumentsResources::class, $documents);

        } catch (\Throwable $th) {

            return response()->json([
                'success' => false,
                'message' => 'Echec de la récupération des documents par catégorie.',
                'error' => $th->getMessage()
            ], 500);

        }
    }

    public function searchDocuments(Request $request)
    {
        try {
            $searchTerm = $request->query('q', '');

            $documents = $this->documentsRepository->searchDocuments($searchTerm);

            return $this->successResponseWithPaginate(DocumentsResources::class, $documents);

        } catch (\Throwable $th) {

            return response()->json([
                'success' => false,
                'message' => 'Echec de la recherche des documents.',
                'error' => $th->getMessage()
            ], 500);

        }
    }
}
