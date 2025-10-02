<?php

namespace App\Http\Requests\Documents;

use Illuminate\Foundation\Http\FormRequest;

class TemplateUpdateRequest extends FormRequest
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
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|nullable|string|max:1000',
            'category' => 'sometimes|required|string|max:100',
            'type' => 'sometimes|required|string|max:100',
            'content' => 'sometimes|required|string|max:1000000',
            'version' => 'sometimes|float|nullable',
            'is_premium' => 'sometimes|bool|nullable',
            'is_active' => 'sometimes|bool|nullable',
            'is_public' => 'sometimes|bool|nullable',
            'author_id' => 'sometimes|uuid|nullable',
            'language' => 'sometimes|string|nullable',
            'estimated_time_minutes' => 'sometimes|int|nullable',
            'document_id' => 'sometimes|required|uuid'
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
            'category.required' => 'La catégorie est requise.',
            'category.string' => 'La catégorie doit être une chaîne de caractères',
            'category.max' => 'La catégorie ne doit pas dépasser 100 caractères.',
            'type.required' => 'Le type est requis.',
            'type.string' => 'Le type doit être une chaîne de caractères',
            'type.max' => 'Le type ne doit pas dépasser 100 caractères.',
            'content.required' => 'Le contenu est requis.',
            'content.string' => 'Le contenu doit être une chaîne de caractères',
            'content.max' => 'Le contenu ne doit pas dépasser 1000000 caractères.',
            'version.float' => 'La version doit être un nombre décimal.',
            'is_premium.bool' => 'Le statut premium doit être un booléen.',
            'is_active.bool' => 'Le statut actif doit être un booléen.',
            'is_public.bool' => 'Le statut public doit être un booléen.',
            'author_id.uuid' => "L'ID de l'auteur doit être une UUID.",
            'language.string' => 'La langue doit être une chaîne de caractères.',
            'estimated_time_minutes.int' => "Le temps estimé en minutes doit être un nombre entier.",
            'document_id.required' => "L'ID du document est requis.",
            'document_id.uuid' => "L'ID du document doit être une UUID."
        ];
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $response = response()->json([
            'success' => false,
            'message' => 'Validation errors',
            'errors' => $validator->errors()
        ], 422);

        throw new \Illuminate\Validation\ValidationException($validator, $response);
    }
}
