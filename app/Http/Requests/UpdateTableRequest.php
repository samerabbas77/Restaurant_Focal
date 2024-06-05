<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateTableRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $id = $this->route('table');
        return [
            'Number' => [
                    'required',
                    'integer',
                    Rule::unique('tables')->ignore($id),],
            'chair_number' => 'required|integer|min:1',
            'Is_available' => 'required|in:available,unavailable',

        ];
    }
}
