<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateWorkingHoursRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'working_hours' => ['required', 'array', 'size:7'],

            'working_hours.*.day_of_week' => [
                'required',
                'integer',
                'between:0,6',
            ],

            'working_hours.*.start_time' => [
                'required',
                'date_format:H:i',
            ],

            'working_hours.*.end_time' => [
                'required',
                'date_format:H:i',
            ],
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            foreach ($this->input('working_hours', []) as $index => $hours) {
                if (
                    isset($hours['start_time'], $hours['end_time']) &&
                    $hours['start_time'] >= $hours['end_time']
                ) {
                    $validator->errors()->add(
                        "working_hours.$index.end_time",
                        'End time must be after start time.'
                    );
                }
            }
        });
    }
}