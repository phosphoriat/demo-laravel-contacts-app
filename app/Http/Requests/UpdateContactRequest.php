<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateContactRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name'    => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'phone'   => 'required|regex:/\+7\s\(\d{3}\)\s\d{3}\-\d{2}\-\d{2}/',
            'email'   => 'sometimes|nullable|email',
        ];
    }
}
