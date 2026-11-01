<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('report_status_logs', function (Blueprint $table) {
            $table->bigIncrements('log_id');

            $table->unsignedBigInteger('report_id');
            $table->unsignedBigInteger('changed_by')->nullable();

            $table->string('old_status')->nullable();
            $table->string('new_status');

            $table->timestamps();

            $table->foreign('report_id')
                ->references('report_id')
                ->on('reports')
                ->cascadeOnDelete();

            $table->foreign('changed_by')
                ->references('user_id')
                ->on('users')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('report_status_logs');
    }
};
