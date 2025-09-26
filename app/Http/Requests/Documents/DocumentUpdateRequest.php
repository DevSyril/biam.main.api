<?php

namespace App\Http\Requests\Documents;

use Illuminate\Foundation\Http\FormRequest;

class DocumentUpdateRequest extends FormRequest
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
            'name' => 'sometimes|string|max:300|unique:available_documents',
            'category' => 'sometimes|required|string|max:100',
            'description' => 'sometimes|string|max:1000|nullable',
            'type' => 'sometimes|string|max:100'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Le nom du document est requis.',
            'name.string' => 'Le nom du document doit être une chaîne de caractères.',
            'name.max' => 'Le nom du document ne doit pas dépasser 300 caractères.',
            'name.unique' => 'Un document avec ce nom existe déjà.',

            'category.required' => 'La catégorie du document est requise.',
            'category.string' => 'La catégorie du document doit être une chaîne de caractères.',
            'category.max' => 'La catégorie du document ne doit pas dépasser 100 caractères.',

            'description.string' => 'La description doit être une chaîne de caractères.',
            'description.max' => 'La description ne doit pas dépasser 1000 caractères.',

            'type.required' => 'Le type du document est requis.',
            'type.string' => 'Le type du document doit être une chaîne de caractères.',
            'type.max' => 'Le type du document ne doit pas dépasser 100 caractères.',
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
