<?php

namespace App\Http\Requests\LegalSubjects;

use Illuminate\Foundation\Http\FormRequest;

class LegalSubjectCreateRequest extends FormRequest
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
            'label' => 'required|string|max:255',
            'description' => 'nullable|string',
            'slug' => 'required|string|max:255|unique:pgsql_secondary.legal_subject,slug',
            'parent_id' => 'nullable|uuid|exists:pgsql_secondary.legal_subject,id',
            'level' => 'nullable|integer|min:0',
        ];
    }


    public function messages(): array
    {
        return [
            'label.required' => 'Le champ label est obligatoire.',
            'label.string' => 'Le champ label doit être une chaîne de caractères.',
            'label.max' => 'Le champ label ne doit pas dépasser 255 caractères.',
            'description.string' => 'Le champ description doit être une chaîne de caractères.',
            'slug.required' => 'Le champ slug est obligatoire.',
            'slug.string' => 'Le champ slug doit être une chaîne de caractères.',
            'slug.max' => 'Le champ slug ne doit pas dépasser 255 caractères.',
            'slug.unique' => 'Le champ slug doit être unique.',
            'parent_id.uuid' => "Le champ parent_id doit être un UUID valide.",
            'parent_id.exists' => "Le champ parent_id doit exister dans la table legal_subject.",
            'level.integer' => "Le champ level doit être un entier.",
            'level.min' => "Le champ level doit être au moins 0.",
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
