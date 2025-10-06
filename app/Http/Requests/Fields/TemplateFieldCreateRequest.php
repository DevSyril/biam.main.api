<?php

namespace App\Http\Requests\Fields;

use Illuminate\Foundation\Http\FormRequest;

class TemplateFieldCreateRequest extends FormRequest
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
            'template_id' => 'required|uuid|exists:templates,id',
            'section_id' => 'nullable|uuid|exists:template_sections,id',
            'field_id' => 'required|uuid|exists:form_fields,id',
            'field_order' => 'required|integer|min:1',
            'is_required' => 'nullable|boolean',
            'is_editable' => 'nullable|boolean',
            'legal_slug' => 'nullable|string|max:255',
            'visibility_rules' => 'nullable|array',
            'validation_schema' => 'nullable|array',
            'conditional_logic' => 'nullable|array',
        ];
    }


    public function messages(): array
    {
        return [
            'template_id.required' => 'The template ID is required.',
            'template_id.uuid' => 'The template ID must be a valid UUID.',
            'template_id.exists' => 'The specified template does not exist.',

            'section_id.uuid' => 'The section ID must be a valid UUID.',
            'section_id.exists' => 'The specified section does not exist.',

            'field_id.required' => 'The field ID is required.',
            'field_id.uuid' => 'The field ID must be a valid UUID.',
            'field_id.exists' => 'The specified field does not exist.',

            'field_order.required' => 'The field order is required.',
            'field_order.integer' => 'The field order must be an integer.',
            'field_order.min' => 'The field order must be at least 1.',

            'is_required.boolean' => 'The is_required field must be true or false.',

            'is_editable.boolean' => 'The is_editable field must be true or false.',

            'legal_slug.string' => 'The legal slug must be a string.',
            'legal_slug.max' => 'The legal slug may not be greater than 255 characters.',

            'visibility_rules.array' => 'The visibility rules must be an array.',

            'validation_schema.array' => 'The validation schema must be an array.',

            'conditional_logic.array' => 'The conditional logic must be an array.',
        ];
    }


    public function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $response = response()->json([
            'message' => 'Erreurs de validation',
            'success' => false,
            'errors' => $validator->errors()
        ], 422);

        throw new \Illuminate\Validation\ValidationException($validator, $response);
    }
}
