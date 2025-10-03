<?php

namespace App\Http\Requests\Fields;

use Illuminate\Foundation\Http\FormRequest;

class FieldUpdateteRequest extends FormRequest
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
            'label' => 'sometimes|required|string|max:255',
            'type' => 'sometimes|required|string|max:100',
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

            'label.required' => 'The field label is required.',
            'label.string' => 'The field label must be a string.',
            'label.max' => 'The field label may not be greater than 255 characters.',

            'type.required' => 'The field type is required.',
            'type.string' => 'The field type must be a string.',
            'type.max' => 'The field type may not be greater than 100 characters.',

            'default_value.string' => 'The default value must be a string.',

            'description.string' => 'The description must be a string.',

            'validation_rules.array' => 'The validation rules must be an array.',

            'options.array' => 'The options must be an array.',
            'options.*.string' => 'Each option must be a string.',
            'options.*.max' => 'Each option may not be greater than 100 characters.',

            'placeholder.string' => 'The placeholder must be a string.',

            'help_text.string' => 'The help text must be a string.',
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
