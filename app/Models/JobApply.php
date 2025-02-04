<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobApply extends Model
{
    use HasFactory;
    protected $fillable = ['job_id', 'firstName', 'lastName', 'email', 'location', 'phone_number', 'cv'];
}
