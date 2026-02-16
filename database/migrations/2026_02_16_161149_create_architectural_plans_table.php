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
        Schema::create('architectural_plans', function (Blueprint $table) {
            $table->id();
            // Foreign key to permit application
            $table->unsignedBigInteger('permit_application_id');

            $table->string('plan_name'); // e.g. Floor Plan, Site Plan
            $table->string('file_path'); // file storage path
            $table->text('description')->nullable();

            $table->foreign('permit_application_id')
                ->references('id')
                ->on('permit_applications')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('architectural_plans');
    }
};
