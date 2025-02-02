<?php

namespace App\Http\Controllers;

use App\Models\Job;
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
}
