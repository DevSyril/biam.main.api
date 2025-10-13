<?php

namespace App\Http\Requests\LegalContext;

use Illuminate\Foundation\Http\FormRequest;

class LegalTextCreateRequest extends FormRequest
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
            'title' => 'required|string|max:255|unique:pgsql_secondary.legal_text,title',
            'text_type' => 'required|string|max:255',
            'official_number' => 'nullable|min:4|string|max:255',
            'description' => 'nullable|string',
            'promulgation_date' => 'required|date',
            'is_in_force' => 'sometimes|nullable',
            'jurisdiction' => 'sometimes|string|max:255',
            'source' => 'nullable|string|max:255',
            'version' => 'nullable|string|max:255',
        ];
    }


    public function messages(): array
    {
        return [
            'title.required' => 'Le titre du texte de loi est requis.',
            'title.unique' => 'Il semblerait que ce texte de loi existe déjà.',
            'text_type.required' => 'Veuiilez préciser le type de texte de loi.',
            'official_number.required' => 'Le numéro officiel du texte de loi est requis',
            'promulgation_date.required' => 'La date de publication est requise.',
            'promulgation_date.date' => 'Le format de la date de publication est invalide.',
            'is_in_force.required' => 'Le statut du texte est requis.',
            'is_in_force.boolean' => 'Le statut du texte doit être un booléen.',
            'jurisdiction.required' => 'La juridiction est requise.',
            'source.required' => 'La source est requise',
            'version.required' => 'La version est requise.',
            'description.required' => 'La description est requise.',
            'title.string' => 'Le titre du texte de loi doit être une chaîne de caractères.',
            'title.max' => 'Le titre du texte de loi ne doit pas dépasser 255 caractères.',
            'text_type.string' => 'Le type du texte de loi doit être une chaîne de caractères.',
            'text_type.max' => 'Le type du texte de loi ne doit pas dépasser 255 caractères.',
            'official_number.string' => 'Le numéro officiel du texte de loi doit être une chaîne de caractères.',
            'official_number.max' => 'Le numéro officiel du texte de loi ne doit pas dépasser 255 caractères.',
            'description.string' => 'La description du texte de loi doit être une chaîne de caractères.',
            'jurisdiction.string' => 'La juridiction doit être une chaîne de caractères.',
            'jurisdiction.max' => 'La juridiction ne doit pas dépasser 255 caractères.',
            'source.string' => 'La source doit être une chaîne de caractères.',
            'source.max' => 'La source ne doit pas dépasser 255 caractères.',
            'version.string' => 'La version doit être une chaîne de caractères.',
            'version.max' => 'La version ne doit pas dépasser 255 caractères.',
            'description.max' => 'La description ne doit pas dépasser 255 caractères.',
            'official_number.min' => 'Le numéro officiel du texte de loi doit être au moins 4 caractères',
        ];
    }


    public function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        throw new \Illuminate\Validation\ValidationException($validator, response()->json([
            'success' => false,
            'message' => 'Validation errors',
            'errors' => $validator->errors()
        ], 422));
    }
}
