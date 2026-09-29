<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AvailabilityRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'staff_profile_id' => [
                'required',
                'integer',
                'exists:staff_profiles,id',
            ],

            'service_id' => [
                'required',
                'integer',
                'exists:services,id',
            ],

            'date' => [
                'required',
                'date',
                'after_or_equal:today',
            ],
        ];
    }
}