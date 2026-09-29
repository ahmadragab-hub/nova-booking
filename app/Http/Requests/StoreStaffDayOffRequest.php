<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStaffDayOffRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'date' => [
                'required',
                'date',
                'after_or_equal:today',
            ],

            'reason' => [
                'nullable',
                'string',
                'max:255',
            ],
        ];
    }
}