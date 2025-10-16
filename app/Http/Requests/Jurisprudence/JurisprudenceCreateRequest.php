<?php

namespace App\Http\Requests\Jurisprudence;

use Illuminate\Foundation\Http\FormRequest;

class JurisprudenceCreateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'case_reference' => 'required|string|max:500',
            'defendant_names' => 'required|string|max:500',
            'claimant_names' => 'required|string|max:500',
            'court' => 'required|string|max:500',
            'summary' => 'required|string|max:500',
            'full_decision' => 'nullable|string',
            'decision_date' => 'required|date',
            'official_link' => 'nullable|string|max:500',
            'linked_subject_id' => 'nullable|uuid|exists:pgsql_secondary.legal_subject,id',
        ];
    }

    public function messages(): array
    {
        return [
            'case_reference.required' => 'Le numéro de la décision est obligatoire.',
            'case_reference.string' => 'Le numéro de la décision doit être une chaîne de caractères',
            'case_reference.max' => 'Le numéro de la décision ne doit pas dépasser 500 caractères',

            'defendant_names.required' => 'Les noms des défendeurs sont obligatoires',
            'defendant_names.string' => 'Les noms des défendeurs',
            'defendant_names.max' => 'Les noms des défendeurs ne doivent pas dépasser 500 caractères',

            'claimant_names.required' => 'Les noms des demandeurs sont obligatoires.',
            'claimant_names.string' => 'Les noms des demandeurs doivent être en chaîne de caractères.',
            'claimant_names.max' => 'Les noms des demandeurs ne peuvent dépasser 500 caractères',

            'court.required' => 'Le nom du tribunal est obligatoire.',
            'court.string' => 'Le nom du tribunal doit être une chaîne de caractères',
            'court.max' => 'Le nom du tribunal ne doit pas dépasser 500 caractères',

            'summary.required' => 'Le résumé de la décision est obligatoire.',
            'summary.string' => 'Le résumé de la décision doit être une chaîne de caractères',
            'summary.max' => 'Le résumé de la décision ne doit pas dépasser 500 caractères',

            'full_decision.string' => 'Le détail de la décision doit être une chaîne de caractères',

            'decision_date.required' => 'La date de décision est obligatoire.',
            'decision_date.date' => 'La date de décision doit être une date valide',

            'official_link.string' => 'Le lien officiel doit être une chaîne de caractères',
            'official_link.max' => 'Le lien officiel ne doit pas dépasser 500 caractères',

            'linked_subject_id.uuid' => 'L\'ID du sujet lié doit être une UUID valide',
            'linked_subject_id.exists' => 'Le sujet lié spécifié n\'existe pas',
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
