<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            // UpdateUserRequest receives 'user' route parameter which is ID string
            'email' => 'required|email|unique:users,email,' . $this->route('user'),
            'password' => 'nullable|string|min:8|max:20',
            'role' => 'required',
        ];
    }
}
