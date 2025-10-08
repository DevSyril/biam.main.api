<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LegalArticleCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "legal_text_id" => "required|uuid|exists:pgsql_secondary.legal_text,id",
            "article_number" => "required|string|max:255",
            "article_title" => "required|string|max:255",
            "content" => "required|string",
            "is_modified" => "sometimes|boolean",
            "is_abrogated" => "sometimes|boolean",
            "commentary" => "nullable|string",
            "display_order" => "required|integer",
        ];
    }


    public function messages(): array
    {
        return [
            "legal_text_id.required" => "Le champ legal_text_id est obligatoire.",
            "legal_text_id.uuid" => "Le champ legal_text_id doit être un UUID valide.",
            "legal_text_id.exists" => "Le legal_text_id spécifié n'existe pas.",
            "article_number.required" => "Le champ article_number est obligatoire.",
            "article_number.string" => "Le champ article_number doit être une chaîne de caractères.",
            "article_number.max" => "Le champ article_number ne doit pas dépasser 255 caractères.",
            "article_title.required" => "Le champ article_title est obligatoire.",
            "article_title.string" => "Le champ article_title doit être une chaîne de caractères.",
            "article_title.max" => "Le champ article_title ne doit pas dépasser 255 caractères.",
            "content.required" => "Le champ content est obligatoire.",
            "content.string" => "Le champ content doit être une chaîne de caractères.",
            "is_modified.boolean" => "Le champ is_modified doit être vrai ou faux.",
            "is_abrogated.boolean" => "Le champ is_abrogated doit être vrai ou faux.",
            "commentary.string" => "Le champ commentary doit être une chaîne de caractères.",
            "display_order.required" => "Le champ display_order est obligatoire.",
            "display_order.integer" => "Le champ display_order doit être un entier.",
        ];
    }


    public function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $response = response()->json([
            'success' => false,
            'message' => 'Validation errors',
            'errors' => $validator->errors()
        ], 422);

        throw new \Illuminate\Validation\ValidationException($validator, $response);
    }
}
