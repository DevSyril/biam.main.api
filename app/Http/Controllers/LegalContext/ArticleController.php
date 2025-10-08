<?php

namespace App\Http\Controllers\LegalContext;

use App\Http\Controllers\Controller;
use App\Http\Requests\LegalArticleCreateRequest;
use App\Http\Requests\LegalArticleUpdateRequest;
use App\Http\Resources\LegalArticles\ArticleResources;
use App\Repositories\ArticleRepository;
use App\Traits\JsonTrait;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    use JsonTrait;

    protected ArticleRepository $articleRepository;

    public function __construct(ArticleRepository $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    public function index()
    {

        try {
            $itemsPerPage = request()->query('items', 10);

            $articles = $this->articleRepository->index($itemsPerPage);

            return $this->successResponseWithPaginate(ArticleResources::class, $articles);

        } catch (\Throwable $th) {

            return $this->errorResponse($th->getMessage(), 500);
        }
    }


    public function show($id)
    {

        try {

            $article = $this->articleRepository->show($id);

            return $this->successResponse(new ArticleResources($article), "Article récupéré avec succès", 200);

        } catch (\Throwable $th) {

            return $this->errorResponse($th->getMessage(), 500);
        }
    }


    public function store(LegalArticleCreateRequest $request)
    {

        try {

            $data = array_filter($request->all(), function ($value) {
                return !is_null($value) && $value !== '';
            });

            $article = $this->articleRepository->store($data);

            return $this->successResponse(new ArticleResources($article), "L'article a été créé avec succès", 201);

        } catch (\Throwable $th) {

            return $this->errorResponse($th->getMessage(), 500);
        }
    }


    public function update(LegalArticleUpdateRequest $request, $id)
    {

        try {

            $data = array_filter($request->all(), function ($value) {
                return !is_null($value) && $value !== '';
            });

            $article = $this->articleRepository->update($id, $data);

            return $this->successResponse(new ArticleResources($article), "L'article a été mis à jour avec succès", 200);

        } catch (\Throwable $th) {

            return $this->errorResponse($th->getMessage(), 500);
        }
    }


    public function destroy($id)
    {

        try {

            $this->articleRepository->destroy($id);

            return $this->successResponse(null, "L'article a été supprimé avec succès", 200);

        } catch (\Throwable $th) {

            return $this->errorResponse($th->getMessage(), 500);
        }
    }
}
