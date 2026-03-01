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
        Schema::create('deleted_plans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('permit_application_id')->nullable(); // the permit it belonged to
            $table->string('plan_name')->nullable();
            $table->text('file_path'); // store the file path
            $table->unsignedBigInteger('deleted_by')->nullable(); // user who deleted it

            $table->foreign('permit_application_id')
                ->references('id')->on('permit_applications')
                ->onDelete('set null');

            $table->foreign('deleted_by')
                ->references('id')->on('users')
                ->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deleted_plans');
    }
};
