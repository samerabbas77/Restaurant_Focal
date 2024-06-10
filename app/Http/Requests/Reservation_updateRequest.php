<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Reservation_updateRequest extends FormRequest
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
        return [
            'user_id' => 'exists:users,id',
            'table_id' => 'exists:tables,id',
            'start_date' => 'date_format:Y-m-d\TH:i',
            'end_date' => 'date_format:Y-m-d\TH:i',
            
        ];
    }

}
