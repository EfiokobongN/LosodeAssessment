<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostJobRequest extends FormRequest
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
            'job_title' => 'required|string|min:5',
            'company_name' => 'required|string|min:3',
            'job_description' => 'required|string|min:20',
            'location' => 'required|string',
            'employment_type' => 'required|string',
            'salary_range' => 'required|string',
            'submission_deadline' => 'required|date_format:d/m/Y',
            'category' => 'required|string',
            'minim_qualification' => 'required|string',
            'experience_level' => 'required|string',
            'experience_length' => 'required|string',
            'job_requirements' => 'required|string',
        ];
    }
}
