<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class AddSubjectRequest extends FormRequest
{
    /**
     * @return array<string, ValidationRule|array<string, string>
     */
    public function rules(): array
    {
        return [
            'description' => 'required|string|min:5|max:20|unique:subjects',
        ];
    }
}
