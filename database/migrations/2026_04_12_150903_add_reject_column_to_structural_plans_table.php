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
        Schema::table('structural_plans', function (Blueprint $table) {
            $table->text('rejection_comment')->nullable()->after('status');
            $table->unsignedBigInteger('rejected_by')->nullable()->after('rejection_comment');

            // Optional: If you want to link rejected_by to users table
            $table->foreign('rejected_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('structural_plans', function (Blueprint $table) {
            $table->dropForeign(['rejected_by']);
            $table->dropColumn(['rejection_comment', 'rejected_by']);
        });
    }
};
