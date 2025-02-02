<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApplyJobRequest;
use App\Http\Requests\PostJobRequest;
use App\Models\Job;
use App\Models\JobApply;
use App\Utility\Util;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostJobController extends Controller
{
    public function storeJob(PostJobRequest $request)
    {
        $user = Util::Auth();
        $data = $request->validated();
        $dateFormatted = Carbon::createFromFormat('d/m/Y', $data['submission_deadline'])->format('Y-m-d');
        // Perform database operations to store the job data
        DB::beginTransaction();

        try {
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
            DB::commit();
            $response = response()->json(['success'=>true, 'message' => 'Job posted successfully', 'jobdetails'=>$postJob], 201);
        } catch (\Throwable $th) {
            DB::rollBack();
            $response = response()->json(['success'=>false, 'error' => $th->getMessage()], 500);
        }
        return $response;
    }


    //Edit Job Dateils Function Method
    public function editJob(PostJobRequest $request,$id)
    {
        $user = Util::Auth();
        $job = Job::find($id);
        if (!$job || $job->user_id!= $user->id) {
            return response()->json(['success'=>false, 'error' => 'Job not found or not belong to you'], 404);
        }
        $data = $request->all();
        $dateFormatted = Carbon::createFromFormat('d/m/Y', $data['submission_deadline'])->format('Y-m-d');
        // Perform database operations to update the job data
        DB::beginTransaction();

        try {
            $job->job_title = $data['job_title'];
            $job->company_name = $data['company_name'];
            $job->job_description = $data['job_description'];
            $job->location = $data['location'];
            $job->employment_type = $data['employment_type'];
            $job->salary_range = $data['salary_range'];
            $job->submission_deadline = $dateFormatted;
            $job->category = $data['category'];
            $job->minim_qualification = $data['minim_qualification'];
            $job->experience_level = $data['experience_level'];
            $job->experience_length = $data['experience_length'];
            $job->job_requirements = $data['job_requirements'];
            $job->update();
            DB::commit();
            $response = response()->json(['success'=>true, 'message' => 'Job updated successfully', 'jobdetails'=>$job], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            $response = response()->json(['success'=>false, 'error' => $th->getMessage()], 500);
        }
        return $response;
    }

    //Delete Job Function Method
    public function deleteJob($id)
    {
        $user = Util::Auth();
        $job = Job::find($id);
        if (!$job || $job->user_id!= $user->id) {
            return response()->json(['success'=>false, 'error' => 'Job not found or not belong to you'], 404);
        }
        // Perform database operations to delete the job
        DB::beginTransaction();

        try {
            $job->delete();
            DB::commit();
            $response = response()->json(['success'=>true, 'message' => 'Job deleted successfully'], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            $response = response()->json(['success'=>false, 'error' => $th->getMessage()], 500);
        }
        return $response;
    }

    // Apply for Job Function Method
    public function applyForJob(ApplyJobRequest $request, $id)
    {
        $data = $request->validated();
        $job = Job::find($id);
        if (!$job) {
            return response()->json(['success'=>false, 'error' => 'Job not found'], 404);
        }
        // Perform database operations to apply for the job
        DB::beginTransaction();
        try {
            $appliedJob = new JobApply();
            $appliedJob->job_id = $job->id;
            $appliedJob->firstName = $data['firstName'];
            $appliedJob->lastName = $data['lastName'];
            $appliedJob->email = $data['email'];
            $appliedJob->location = $data['location'];
            $appliedJob->phone_number = $data['phone_number'];
            $appliedJob->cv = $data['cv'];
            $appliedJob->save();

            $job->increment('candidates');
            DB::commit();
            $response = response()->json(['success'=>true, 'message' => 'Applied for the job successfully'], 201);
        } catch (\Throwable $th) {
            DB::rollBack();
            $response = response()->json(['success'=>false, 'error' => $th->getMessage()], 500);
        }
        return $response;
    }
}
