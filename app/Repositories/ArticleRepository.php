<?php

namespace App\Repositories;

use App\Interfaces\ArticleInterface;
use App\Models\Article;

class ArticleRepository implements ArticleInterface
{
    public function index($items = 10)
    {
        return Article::paginate($items);
    }

    public function store(array $data)
    {
        return Article::create($data);
    }

    public function show(string $id)
    {
        $article = Article::findOrFail($id);
        $article->load('legal_text', 'jurisprudences', 'subject_article_links.subject', 'text_modifications');
        return $article;
    }

    public function update(string $id, array $data)
    {
        $item = Article::findOrFail($id);
        $item->update($data);
        return $item;
    }

    public function destroy(string $id)
    {
        $item = Article::findOrFail($id);
        return $item->delete();
    }
}