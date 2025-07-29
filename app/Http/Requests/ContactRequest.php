<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // ✅ Allow all authenticated users
    }

    public function rules(): array
    {
        return [
            'name'  => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'company' => 'nullable|string|max:255',
            'notes'   => 'nullable|string',
            'photo'   => 'nullable|image|max:2048', // 2MB max
        ];
    }
}
