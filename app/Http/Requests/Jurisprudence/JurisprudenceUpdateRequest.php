<?php

namespace App\Http\Requests\Jurisprudence;

use Illuminate\Foundation\Http\FormRequest;

class JurisprudenceUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'reference' => 'sometimes|string|max:255',
            'summary' => 'sometimes|string',
            'official_link' => 'sometimes|nullable|url',
            'linked_article_id' => 'sometimes|nullable|uuid|exists:pgsql_secondary.article,id',
            'linked_subject_id' => 'sometimes|nullable|uuid|exists:pgsql_secondary.legal_subject,id',
        ];
    }

    public function messages(): array
    {
        return [
            'official_link.url' => 'The official link must be a valid URL.',
            'linked_article_id.uuid' => 'The linked article ID must be a valid UUID.',
            'linked_article_id.exists' => 'The specified article does not exist.',
            'linked_subject_id.uuid' => 'The linked subject ID must be a valid UUID.',
            'linked_subject_id.exists' => 'The specified subject does not exist.',
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
