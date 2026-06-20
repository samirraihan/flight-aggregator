<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateBookingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'flight_id' => [
                'required',
                'string',
            ],

            'passengers' => [
                'required',
                'array',
                'min:1',
            ],

            'passengers.*.first_name' => [
                'required',
                'string',
                'max:255',
            ],

            'passengers.*.last_name' => [
                'required',
                'string',
                'max:255',
            ],
        ];
    }
}