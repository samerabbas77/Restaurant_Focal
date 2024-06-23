<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateDishRequest extends FormRequest
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
            'name' => ['required','string',Rule::unique('dishes')->ignore($this->route('dish'))],
            'price' => 'required|numeric',
            'descraption' => 'required|string',
            'photo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'cat_id' => 'required|exists:categories,id',
        ];
    }
}
