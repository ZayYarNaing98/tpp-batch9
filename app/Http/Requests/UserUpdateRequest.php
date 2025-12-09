<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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
            'name' => 'required|string',
            'email' => 'required|unique:users,email,' . $this->id,
            'password' => 'nullable|confirmed',
            'phone' => 'required|string',
            'address' => 'required|string',
            'gender' => 'required|string',
            'status' => 'nullable',
        ];
    }
}

