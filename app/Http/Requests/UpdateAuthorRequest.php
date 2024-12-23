<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateAuthorRequest extends FormRequest
{
    /**
     * @return array<string, ValidationRule|array<string, string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|min:4|max:255',
        ];
    }
}
