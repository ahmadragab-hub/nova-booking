<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('category')?->id ?? $this->route('category');
        
        return [
            'name' => [
                'required', 
                'string', 
                'max:255', 
                Rule::unique('categories', 'name')->ignore($id)
            ],
            'description' => ['nullable', 'string']
        ];
    }

}
