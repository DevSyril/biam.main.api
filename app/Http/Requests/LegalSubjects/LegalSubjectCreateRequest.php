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
            'level' => 'required|integer|min:1',
        ];
    }


    public function messages(): array
    {
        return [
            'label.required' => 'Le label est obligatoire.',
            'label.string' => 'Le label doit être une chaîne de caractères.',
            'label.max' => 'Le label ne doit pas dépasser 255 caractères.',
            'description.string' => 'La description doit être une chaîne de caractères.',
            'slug.required' => 'Le slug est obligatoire.',
            'slug.string' => 'Le slug doit être une chaîne de caractères.',
            'slug.max' => 'Le slug ne doit pas dépasser 255 caractères.',
            'slug.unique' => 'Il semblerait que ce slug existe déjà.',
            'parent_id.uuid' => "Le  sujet parent doit être un UUID valide.",
            'parent_id.exists' => "Le sujet parent sélectionné n'a pas été retrouvé.",
            'level.integer' => "Le niveau d'importance doit être un entier.",
            'level.min' => "Le niveau d'importance doit être égal ou supérieur à 0.",
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
