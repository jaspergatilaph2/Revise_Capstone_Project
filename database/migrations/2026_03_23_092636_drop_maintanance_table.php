<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::dropIfExists('maintanance');
    }

    public function down()
    {
        // Optional: recreate table if rollback is needed
        Schema::create('maintanance', function (Blueprint $table) {
            $table->id();
            $table->string('department');
            $table->dateTime('finish_at')->nullable();
            $table->timestamps();
        });
    }
};
