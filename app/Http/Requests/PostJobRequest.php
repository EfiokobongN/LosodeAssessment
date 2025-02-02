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
            'job_title' => 'required',
            'company_name' => 'required',
            'job_description' => 'required',
            'location' => 'required',
            'employment_status' => 'required',
            'salary_range' => 'required',
            'submission_deadline' => 'required|date_format:d/m/Y',
            'job_sector' => 'required',
            'minim_qualification' => 'required',
            'experience_level' => 'required',
            'experience_length' => 'required',
            'job_requirements' => 'required'
        ];
    }
}
