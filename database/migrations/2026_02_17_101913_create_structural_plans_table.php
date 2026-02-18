<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('structural_plans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('permit_application_id');
            $table->string('plan_name');
            $table->text('description')->nullable();
            $table->json('documents')->nullable();
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
        Schema::dropIfExists('structural_plans');
    }
};
