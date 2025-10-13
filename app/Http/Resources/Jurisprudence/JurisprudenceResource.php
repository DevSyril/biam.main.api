<?php

namespace App\Http\Resources\Jurisprudence;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JurisprudenceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'reference' => $this->reference,
            'summary' => $this->summary,
            'official_link' => $this->official_link,
            'linked_article_id' => $this->linked_article_id,
            'linked_subject_id' => $this->linked_subject_id,
            'created_at' => $this->created_at->toIso8601String(),
            'updated_at' => $this->updated_at->toIso8601String(),
            'article' => new \App\Http\Resources\LegalArticles\ArticleResources($this->whenLoaded('article')),
            'legal_subject' => new \App\Http\Resources\LegalSubjects\LegalSubjectResources($this->whenLoaded('legal_subject')),
        ];
    }
}
