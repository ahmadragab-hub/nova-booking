<?php

namespace App\Http\Requests;

use App\Models\Service;
use App\Models\StaffProfile;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class UpdateBookingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'customer_id' => [
                'required',
                'integer',
                'exists:customers,id',
            ],

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

            'status' => [
                'required',
                'string',
                'in:confirmed,cancelled,completed',
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
            function (Validator $validator) {
                if (
                    ! $this->filled('service_id') ||
                    ! $this->filled('staff_profile_id')
                ) {
                    return;
                }

                $service = Service::find($this->integer('service_id'));
                $staff = StaffProfile::find(
                    $this->integer('staff_profile_id')
                );

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