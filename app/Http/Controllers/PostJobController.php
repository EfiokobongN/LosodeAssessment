<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostJobRequest;
use App\Models\Job;
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
            $postJob->employment_status = $data['employment_status'];
            $postJob->salary_range = $data['salary_range'];
            $postJob->submission_deadline = $dateFormatted;
            $postJob->job_sector = $data['job_sector'];
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
}
