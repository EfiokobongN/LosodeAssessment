<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Utility\Util;
use Illuminate\Http\Request;

class JobListingController extends Controller
{
    public function index()
    {
        // Retrieve all job listings from the database
        $jobListings = Job::all();
        if ($jobListings === null){
            $response = response()->json(['success'=>false,'error' => 'No job listings found'], 404);
        }else{
            // Return the job listings as a JSON response
            $response = response()->json(['success'=>true,'Message'=>'jobslisting', 'listing'=>$jobListings]);
        }
        return $response;
        
    }

    //Get user jobs post
    public function getUserJobs()
    {
        $user = Util::Auth();
        if ($user === null) {
            $response = response()->json(['success'=>false,'error' => 'User not authenticated'], 401);
        }
        $jobs = Job::where('user_id', $user->id)->get();
        if ($jobs === null){
            $response = response()->json(['success'=>false,'error' => 'No job listings found for this user'], 404);
        }else{
            $response = response()->json(['success'=>true,'message'=>'Myjob', 'listing'=>$jobs]);
        }
        return $response;
    }

    //Get Job listing by id
    public function getJobById($jobId)
    {
        $job = Job::find($jobId);
        if ($job === null){
            $response = response()->json(['success'=>false,'error' => 'Job  not found'], 404);
        }else{
            $response = response()->json(['success'=>true,'message'=>'jobdetails', 'job'=>$job]);
        }
        return $response;
    }

    //getting Search Jobs
    public function searchJobs(Request $request)
    {
        $keyword = $request->query('q');
        $jobs = Job::where('title', 'LIKE', '%'.$keyword.'%')->orWhere('description', 'LIKE', '%'.$keyword.'%')->orWhere('location', 'LIKE', '%'.$keyword.'%')->get();
        if ($jobs === null){
            $response = response()->json(['message' => 'No job listings found for this search'], 404);
        }else{
            $response = response()->json(['success'=>true,'message'=>'Search results', 'listing'=>$jobs]);
        }
        return $response;
    }

    public function search($keyword)
    {
        return $this->where(function ($q) use ($keyword) {
            return $q->where('job_title', 'LIKE', "%$keyword%")
                ->orWhere('location', 'LIKE', "%$keyword%")
                ->orWhere('employment_type', 'LIKE', "%$keyword%")
                ->orWhere('experience_level', 'LIKE', "%$keyword%")
                ->orWhere('experience_length', 'LIKE', "%$keyword%")
                ->orWhere('category', 'LIKE', "%$keyword%");
        });
    }

    // get my details
    public function getprofile()
    {
        $user = Util::Auth();
        if ($user === null) {
            $response = response()->json(['success'=>false,'error' => 'User unauthenticated'], 401);
        }
        $response = response()->json(['success'=>true,'message'=>'Myprofile', 'user'=>$user]);
        return $response;
    }
    
}
