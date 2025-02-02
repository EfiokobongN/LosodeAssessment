<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('job_title');
            $table->string('company_name');
            $table->text('job_description');
            $table->string('location');
            $table->string('employment_status');
            $table->string('salary_range');
            $table->date('submission_deadline');
            $table->string('job_sector');
            $table->string('minim_qualification');
            $table->string('experience_level');
            $table->string('experience_length');
            $table->longText('job_requirements');
            $table->string('candidates')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
};
