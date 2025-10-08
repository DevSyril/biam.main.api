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
            'title' => 'required|string|max:255',
            'text_type' => 'required|string|max:255',
            'official_number' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'publication_date' => 'required|date',
            'is_in_force' => 'sometimes|boolean',
            'jurisdiction' => 'required|string|max:255',
            'source' => 'nullable|string|max:255',
            'version' => 'nullable|string|max:255',
        ];
    }


    public function messages(): array
    {
        return [
            'title.required' => 'The title field is required.',
            'text_type.required' => 'The text type field is required.',
            'publication_date.required' => 'The publication date field is required.',
            'publication_date.date' => 'The publication date must be a valid date.',
            'is_in_force.required' => 'The is in force field is required.',
            'is_in_force.boolean' => 'The is in force field must be true or false.',
            'jurisdiction.required' => 'The jurisdiction field is required.',
            'jurisdiction.string' => 'The jurisdiction field must be a string.',
            'jurisdiction.max' => 'The jurisdiction field may not be greater than 255 characters.',
            'source.string' => 'The source field must be a string.',
            'source.max' => 'The source field may not be greater than 255 characters.',
            'version.string' => 'The version field must be a string.',
            'version.max' => 'The version field may not be greater than 255 characters.',
            'official_number.string' => 'The official number field must be a string.',
            'official_number.max' => 'The official number field may not be greater than 255 characters.',
            'description.string' => 'The description field must be a string.',
            'description.max' => 'The description field may not be greater than 255 characters.',
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
