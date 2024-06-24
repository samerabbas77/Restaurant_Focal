<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class StoreReservationRequest extends FormRequest
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
        $currentDateTime = Carbon::now()->toDateTimeString();

        return [
            'table_id' => 'required|exists:tables,id',
            'start_date' => 'required|date_format:Y-m-d H:i|after_or_equal:' . $currentDateTime,
            'end_date' => 'required|date_format:Y-m-d H:i|after:start_date',
        ];
    }
}
