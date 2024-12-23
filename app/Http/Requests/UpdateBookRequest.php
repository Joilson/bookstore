<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;

class UpdateBookRequest extends AddBookRequest
{
    /**
     * @return array<string, ValidationRule|array<string, string>
     */
    public function rules(): array
    {
        $rules = parent::rules();

        // Remove the unique key
        $rules['title'] = 'required|string|min:4|max:40';

        return $rules;
    }
}
