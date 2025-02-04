<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Job extends Model
{
    use HasFactory;
    protected $fillable = ['job_title', 'company_name', 'location', 'job_description', 'salary_range', 'employment_type', 'submission_deadline', 'category', 'minim_qualification', 'experience_level', 'experience_length','job_requirements'];

    public static function jobId($id){
        $jobId = Job::find($id);
        abort_if(!$jobId, 404, 'Job not found');
        return $jobId;
    }

    
    public static function Search(Request $request) {
        $keyword = $request->query('q');
        $jobs = Job::where('job_title', 'LIKE', '%'.$keyword.'%')->orWhere('location', 'LIKE', '%'.$keyword.'%') ->orWhere('employment_type', 'LIKE', '%'.$keyword.'%')->orWhere('experience_level', 'LIKE', '%'.$keyword.'%')->orWhere('experience_length', 'LIKE', '%'.$keyword.'%')->orWhere('category', 'LIKE', '%'.$keyword.'%')->get();
        return $jobs;
    }
}
