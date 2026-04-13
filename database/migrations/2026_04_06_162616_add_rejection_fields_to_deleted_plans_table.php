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
        Schema::table('deleted_plans', function (Blueprint $table) {
            $table->text('rejection_comment')->nullable()->after('deleted_by'); // replace with appropriate column
            $table->unsignedBigInteger('rejected_by')->nullable()->after('rejection_comment');

            // Optionally, add a foreign key if rejected_by references users
            $table->foreign('rejected_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('deleted_plans', function (Blueprint $table) {
            $table->dropForeign(['rejected_by']);
            $table->dropColumn(['rejection_comment', 'rejected_by']);
        });
    }
};
