<?php
namespace App\Services;

use App\Models\Job;
use App\Utility\Util;
use Carbon\Carbon;

class JobService
{
    public function storeJob($data)
    {
        $user = Util::Auth();
        $dateFormatted = Carbon::createFromFormat('d/m/Y', $data['submission_deadline'])->format('Y-m-d');
        $postJob = new Job();
            $postJob->user_id = $user->id;
            $postJob->job_title = $data['job_title'];
            $postJob->company_name = $data['company_name'];
            $postJob->job_description = $data['job_description'];
            $postJob->location = $data['location'];
            $postJob->employment_type = $data['employment_type'];
            $postJob->salary_range = $data['salary_range'];
            $postJob->submission_deadline = $dateFormatted;
            $postJob->category = $data['category'];
            $postJob->minim_qualification = $data['minim_qualification'];
            $postJob->experience_level = $data['experience_level'];
            $postJob->experience_length = $data['experience_length'];
            $postJob->job_requirements = $data['job_requirements'];
            $postJob->save();
            return $postJob;
    }

    public function edit($jobId, $data)
    {
        $user = Util::Auth();
        $job = Job::find($jobId);
        abort_if($job->user_id != $user->id, 403, 'Unauthorized to edit this job');
        abort_if(!$job, 404, 'job not found');
        $dateFormatted = Carbon::createFromFormat('d/m/Y', $data['submission_deadline'])->format('Y-m-d');
        $job->job_title = $data['job_title'] ?? $job->job_title;
        $job->company_name = $data['company_name'] ?? $job->company_name;
        $job->job_description = $data['job_description'] ?? $job->job_description;
        $job->location = $data['location'] ?? $job->location;
        $job->employment_type = $data['employment_type'] ?? $job->employment_type;
        $job->salary_range = $data['salary_range'] ?? $job->salary_range;
        $job->submission_deadline = $dateFormatted ?? $job->submission_deadline;
        $job->category = $data['category'] ?? $job->category;
        $job->minim_qualification = $data['minim_qualification'] ?? $job->minim_qualification;
        $job->experience_level = $data['experience_level'] ?? $job->experience_level;
        $job->experience_length = $data['experience_length'] ?? $job->experience_length;
        $job->job_requirements = $data['job_requirements'] ?? $job->job_requirements;
        $job->update();
        return $job;
    }
}