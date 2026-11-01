<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('report_reviews', function (Blueprint $table) {
            $table->bigIncrements('review_id');

            $table->unsignedBigInteger('report_id');
            $table->unsignedBigInteger('volunteer_id');

            $table->text('review_data')->nullable();
            $table->text('review_note')->nullable();
            $table->boolean('follow_up_required')->default(false);

            $table->timestamps();

            $table->foreign('report_id')
                ->references('report_id')
                ->on('reports')
                ->cascadeOnDelete();

            $table->foreign('volunteer_id')
                ->references('user_id')
                ->on('users')
                ->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('report_reviews');
    }
};
