<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApplyJobRequest;
use App\Http\Requests\PostJobRequest;
use App\Models\Job;
use App\Post\PostJobs;
use App\Utility\Util;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class PostJobController extends Controller
{
    protected $jobpost;
    public function __construct(PostJobs $jobpost)
    {
        $this->jobpost = $jobpost;
    }

    // Perform database operations to store the job data
    public function storeJob(PostJobRequest $request): JsonResponse
    {
        $data = $request->validated();
        DB::beginTransaction();
        try {
            $postJob = $this->jobpost->storeJob($data);
            DB::commit();
            $response = response()->json(['success' => true, 'message' => 'Job posted successfully', 'jobdetails' => $postJob], 201);
        } catch (\Throwable $th) {
            DB::rollBack();
            $response = response()->json(['success' => false, 'error' => $th->getMessage()], 500);
        }
        return $response;
    }


    /*Edit Job Dateils Function Method
    Perform database operations to update the job data
    */
    public function editJob(PostJobRequest $request, $jobId): JsonResponse
    {
        $data = $request->validated();
        DB::beginTransaction();
        try {
            $editJob = $this->jobpost->edit($jobId, $data);
            DB::commit();
            $response = response()->json(['success' => true, 'message' => 'Job updated successfully', 'jobdetails' => $editJob], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            $response = response()->json(['success' => false, 'error' => $th->getMessage()], 500);
        }
        return $response;
    }

    /*Delete Job Function Method
    Perform database operations to delete the job
    */
    public function deleteJob($id)
    {
        $user = Util::Auth();
        $job = Job::jobId($id);
        if ($job->user_id != $user->id) {
            return response()->json(['success' => false, 'error' => 'Job not belong to you'], 404);
        }
        DB::beginTransaction();
        try {
            $job->delete();
            DB::commit();
            $response = response()->json(['success' => true, 'message' => 'Job deleted successfully'], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            $response = response()->json(['success' => false, 'error' => $th->getMessage()], 500);
        }
        return $response;
    }
    /* Apply for Job Function Method
    Perform database operations to apply for the job
    */
    public function applyForJob(ApplyJobRequest $request, $jobId): JsonResponse
    {
        $data = $request->validated(); 
        DB::beginTransaction();
        try {
            $editJob = $this->jobpost->applyJob($jobId, $data);
            DB::commit();
            $response = response()->json(['success' => true, 'message' => 'Applied for the job successfully'], 201);
        } catch (\Throwable $th) {
            DB::rollBack();
            $response = response()->json(['success' => false, 'error' => $th->getMessage()], 500);
        }
        return $response;
    }
}
