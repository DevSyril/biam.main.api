<?php

namespace App\Http\Requests\LegalContext;

use Illuminate\Foundation\Http\FormRequest;

class LegalTextUpdateRequest extends FormRequest
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
            "title" => "sometimes|string|max:255",
            "text_type" => "sometimes|string|max:255",
            "official_number" => "sometimes|string|max:255",
            "description" => "sometimes|string|max:255",
            "publication_date" => "sometimes|date",
            "is_in_force" => "sometimes|boolean",
            "jurisdiction" => "sometimes|string|max:255",
            "source" => "sometimes|string|max:255",
            "version" => "sometimes|string|max:255",
        ];
    }

    public function messages(): array
    {
        return [
            "title.string" => "The title field must be a string.",
            "title.max" => "The title field may not be greater than 255 characters.",
            "text_type.string" => "The text type field must be a string.",
            "text_type.max" => "The text type field may not be greater than 255 characters.",
            "official_number.string" => "The official number field must be a string.",
            "official_number.max" => "The official number field may not be greater than 255 characters.",
            "description.string" => "The description field must be a string.",
            "publication_date.date" => "The publication date must be a valid date.",
            "is_in_force.boolean" => "The is in force field must be true or false.",
            "jurisdiction.string" => "The jurisdiction field must be a string.",
            "jurisdiction.max" => "The jurisdiction field may not be greater than 255 characters.",
            "source.string" => "The source field must be a string.",
            "source.max" => "The source field may not be greater than 255 characters.",
            "version.string" => "The version field must be a string.",
            "version.max" => "The version field may not be greater than 255 characters.",
            "description.max" => "The description field may not be greater than 255 characters.",
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
