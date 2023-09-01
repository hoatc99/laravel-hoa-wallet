<?php

namespace App\Http\Requests\Saving;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class StoreSavingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'date' => 'required|date',
            'type' => 'required|boolean',
            'amount' => 'required|numeric|min:1000',
            'note' => 'nullable|string|max:255',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'date' => Carbon::createFromFormat('d/m/Y', $this->input('date'))->toDateString(),
            'amount' => intval(str_replace(',', '', $this->input('amount'))),
            'type' => $this->input('type') === 'on',
        ]);
    }
}
