<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStaffServicesRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'service_ids' => [
                'nullable',
                'array',
            ],

            'service_ids.*' => [
                'integer',
                'exists:services,id',
            ],
        ];
    }
}