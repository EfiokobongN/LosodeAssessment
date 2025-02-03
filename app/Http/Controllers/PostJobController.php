<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApplyJobRequest;
use App\Http\Requests\PostJobRequest;
use App\Models\Job;
use App\Models\JobApply;
use App\Services\JobService;
use App\Utility\Util;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostJobController extends Controller
{
    protected $jobservice;
    public function __construct(JobService $jobservice)
    {
        $this->jobservice = $jobservice;
    }
    public function storeJob(PostJobRequest $request)
    {
        $data = $request->validated();
        // Perform database operations to store the job data
        DB::beginTransaction();
        try {
            $postJob = $this->jobservice->storeJob($data);
            DB::commit();
            $response = response()->json(['success'=>true, 'message' => 'Job posted successfully', 'jobdetails'=>$postJob], 201);
        } catch (\Throwable $th) {
            DB::rollBack();
            $response = response()->json(['success'=>false, 'error' => $th->getMessage()], 500);
        }
        return $response;
    }


    //Edit Job Dateils Function Method
    public function editJob(PostJobRequest $request,$jobId)
    {
        $data = $request->validated();
        // Perform database operations to update the job data
        DB::beginTransaction();
        try {
            $editJob = $this->jobservice->edit($jobId,$data);
            DB::commit();
            $response = response()->json(['success'=>true, 'message' => 'Job updated successfully', 'jobdetails'=>$editJob], 200);
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
