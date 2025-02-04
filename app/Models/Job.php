<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;
    protected $fillable = ['job_title', 'company_name', 'location', 'job_description', 'salary_range', 'employment_type', 'submission_deadline', 'category', 'minim_qualification', 'experience_level', 'experience_length','job_requirements'];

    public static function jobId($id){
        $jobId = Job::find($id);
        abort_if(!$jobId, 404, 'Job not found');
        return $jobId;
    }
}
