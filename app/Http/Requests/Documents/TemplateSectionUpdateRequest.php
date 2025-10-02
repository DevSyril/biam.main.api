<?php

namespace App\Http\Requests\Documents;

use Illuminate\Foundation\Http\FormRequest;

class TemplateSectionUpdateRequest extends FormRequest
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
            'description' => 'nullable|string',
            'template_id' => 'sometimes|required|exists:templates,id',
            'section_order' => 'sometimes|required|integer',
            'is_required' => 'nullable|boolean',
            'is_repeatable' => 'nullable|boolean',
            'legal_slug' => 'nullable|string|max:100',
            'content' => 'nullable'
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Le titre de la section est requis.',
            'title.string' => 'Le titre de la section doit être une chaîne de caractères.',
            'title.max' => 'Le titre de la section ne doit pas dépasser 255 caractères.',

            'content.string' => 'Le contenu de la section doit être une chaîne de caractères.',

            'template_id.required' => 'L\'ID du modèle est requis.',
            'template_id.exists' => 'Le modèle spécifié n\'existe pas.',

            'section_order.required' => 'L\'ordre de la section est requis.',
            'section_order.integer' => 'L\'ordre de la section doit être un entier.',

            'is_required.boolean' => 'Le champ "is_required" doit être vrai ou faux.',
            'is_repeatable.boolean' => 'Le champ "is_repeatable" doit être vrai ou faux.',

            'legal_slug.string' => 'Le slug légal doit être une chaîne de caractères.',
            'legal_slug.max' => 'Le slug légal ne doit pas dépasser 100 caractères.',

            'content.required' => 'Le contenu de la section est requis.',
        ];
    }


    public function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        throw new \Illuminate\Http\Exceptions\HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Validation errors',
            'data' => $validator->errors()
        ], 422));
    }
}
