<?php

namespace App\Http\Requests\Fields;

use Illuminate\Foundation\Http\FormRequest;

class FieldCreateRequest extends FormRequest
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
            'type' => 'required|string|max:100',
            'label' => 'required|string|max:255',
            'default_value' => 'nullable|string',
            'description' => 'nullable|string',
            'validation_rules' => 'nullable',
            'options' => 'nullable',
            'options.*' => 'string|max:100',
            'placeholder' => 'nullable|string',
            'help_text' => 'nullable|string',
        ];
    }



    public function messages(): array
    {
        return [
            
            'type.required' => 'Le type du champ est requis.',
            'type.string' => 'Le type du champ doit être une chaîne de caractères.',
            'type.max' => 'Le type du champ ne peut pas dépasser 100 caractères.',

            'default_value.string' => 'La valeur par défaut doit être une chaîne de caractères.',

            'description.string' => 'La description doit être une chaîne de caractères.',

            'validation_rules.array' => 'Les règles de validation doivent être un tableau.',

            'options.array' => 'The options must be an array.',
            'options.*.string' => 'Each option must be a string.',
            'options.*.max' => 'Each option may not be greater than 100 characters.',

            'placeholder.string' => 'The placeholder must be a string.',

            'help_text.string' => 'The help text must be a string.',

            'label.required' => 'The field label is required.',
            'label.string' => 'The field label must be a string.',
            'label.max' => 'The field label may not be greater than 255 characters.',

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
