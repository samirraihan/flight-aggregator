<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SearchFlightRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'from' => ['required', 'string', 'size:3'],
            'to' => ['required', 'string', 'size:3'],
            'date' => ['required', 'date'],
            'passengers' => ['required', 'integer', 'min:1'],

            'sort' => [
                'nullable',
                'string',
                'in:price,-price,departure,-departure,arrival,-arrival,duration,-duration',
            ],

            'carrier' => ['nullable', 'string', 'size:2'],

            'stops' => ['nullable', 'integer', 'min:0'],

            'max_price' => ['nullable', 'numeric', 'min:0'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'from' => strtoupper($this->from),
            'to' => strtoupper($this->to),
            'carrier' => $this->carrier
                ? strtoupper($this->carrier)
                : null,
        ]);
    }
}
