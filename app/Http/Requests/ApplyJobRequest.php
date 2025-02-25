<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApplyJobRequest extends FormRequest
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
            'firstName' => 'required|string|min:3',
            'lastName' => 'required|string|min:3',
            'email' => 'required|email|string',
            'location' => 'required|string',
            'phone_number' => 'required|string|min:6|max:11',
            'cv' => 'required|file|mimes:pdf,docx,txt|max:2048',
        ];
    }
}
