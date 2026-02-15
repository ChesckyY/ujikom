<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserListUpdateRequest extends FormRequest
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
            'name' => ['sometimes', 'string', 'max:255'],
            'email' => ['sometimes', 'string', 'email', 'max:255', Rule::unique('users')->ignore($this->id)],
            'password' => ['nullable', 'string', 'min:8'],
            'no_telp' => ['sometimes', 'string', 'max:15'],
            'user_image' => ['sometimes', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'user_role_id' => ['sometimes', 'integer', 'exists:user_roles,id'],
        ];
    }
}
