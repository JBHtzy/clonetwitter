<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoomtypeRequest extends FormRequest
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
            //
            'title' => 'max:255 | required',
            'detail' => 'max:255 | required'
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'The title field is empty. Please fill it in.',
            'detail.required' => 'Please provide some details.',
        ];
    }
}
