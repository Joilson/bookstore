<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class AddBookRequest extends FormRequest
{
    /**
     * @return array<string, ValidationRule|array<string, string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|min:3|max:40|unique:books',
            'publisher' => 'required|string|min:3|max:40',
            'edition' => 'required|integer',
            'publicationYear' => 'required|string|regex:/^\d{4}$/',
            'price' => 'required|regex:/^\d+(\.\d{1,2})?$/',

            'subjects' => 'required',
            'subjects.*' => ['required', 'integer', 'exists:subjects,id'],
            'authors' => 'required',
            'authors.*' => ['required', 'integer', 'exists:authors,id'],
        ];
    }

    /**
     * @return string[]
     */
    public function messages(): array
    {
        return [
            'subjects.*.exists' => 'The subject at position :position does not exist.',
            'authors.*.exists' => 'The author at position :position does not exist.',
        ];
    }
}
