<?php

namespace App\Http\Requests;

use App\Models\Service;
use App\Models\StaffProfile;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class StorePublicBookingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:255'],

            'service_id' => [
                'required',
                'integer',
                'exists:services,id',
            ],

            'staff_profile_id' => [
                'required',
                'integer',
                'exists:staff_profiles,id',
            ],

            'booking_date' => [
                'required',
                'date',
                'after_or_equal:today',
            ],

            'start_time' => [
                'required',
                'date_format:H:i',
            ],

            'notes' => [
                'nullable',
                'string',
                'max:2000',
            ],
        ];
    }

    public function after(): array
    {
        return [
            function (Validator $validator): void {
                $service = Service::query()
                    ->where('active', true)
                    ->find($this->integer('service_id'));

                $staff = StaffProfile::query()
                    ->where('active', true)
                    ->find($this->integer('staff_profile_id'));

                if (! $service || ! $staff) {
                    return;
                }

                if (! $service->staff()
                    ->whereKey($staff->id)
                    ->exists()) {
                    $validator->errors()->add(
                        'staff_profile_id',
                        'This staff member cannot provide the selected service.'
                    );
                }
            },
        ];
    }
}