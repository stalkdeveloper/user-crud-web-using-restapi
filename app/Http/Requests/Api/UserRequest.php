<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
        $method = $this->route('id') ? 'PUT' : null;
        \Log::info($method);
        $rules = [
            'name' => 'required|string|max:255',
            'phone' => 'required|numeric|digits:10',
            'role_id' => 'required|exists:roles,id',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string',
        ];

        if (isset($method) && !empty($method) && ($method ==  'PUT')) {
            $rules['email'] = [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($this->route('id'))->whereNull('deleted_at'),
            ];
        } else {
            $rules['email'] = [
                'required',
                'email',
                Rule::unique('users', 'email')->whereNull('deleted_at'),
            ];
        }

        return $rules;
    }


    public function attributes()
    {
        return [
            'phone' => 'phone number',
            'role_id' => 'user role',
        ];
    }
}
