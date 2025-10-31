<?php

namespace App\Http\Requests\Documents;

use Illuminate\Foundation\Http\FormRequest;

class TemplateCreateRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'description' => 'string|max:1000|nullable',
            'version' => 'int|nullable',
            'is_premium' => 'bool|nullable',
            'is_active' => 'bool|nullable',
            'is_public' => 'bool|nullable',
            'author_id' => 'uuid|nullable',
            'language' => 'string|nullable',
            'estimated_time_minutes' => 'int|nullable',
            'document_id' => 'required|uuid'
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Le titre est requis.',
            'title.string' => 'Le titre doit être une chaîne de caractères',
            'title.max' => 'Le titre ne doit pas dépasser 255 caractères.',
            'description.string' => 'La description doit être une chaîne de caractères',
            'description.max' => 'La description ne doit pas dépasser 1000 caractères.',
            'content.required' => 'Le contenu est requis.',
            'version.int' => 'La version doit être un nombre entier.',
            'is_premium.bool' => 'Le statut premium doit être un booléen.',
            'is_active.bool' => 'Le statut actif doit être un booléen.',
            'is_public.bool' => 'Le statut public doit être un booléen.',
            'author_id.uuid' => 'L\'ID de l\'auteur doit être une UUID.',
            'language.string' => 'La langue doit être une chaîne de caractères.',
            'estimated_time_minutes.int' => 'Le temps est5imé en minutes doit être un nombre entier.',
            'document_id.required' => 'Veuillez sélectionner un document.',
            'document_id.uuid' => 'L\'ID du document doit être une UUID.'
        ];
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        throw new \Illuminate\Http\Exceptions\HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Validation errors',
            'data' => $validator->errors()
        ], 422));
    }
}
