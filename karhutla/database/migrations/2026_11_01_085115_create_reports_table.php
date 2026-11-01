<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->bigIncrements('report_id');

            $table->unsignedBigInteger('reporter_id');
            $table->unsignedBigInteger('address_id');

            $table->text('report_description');
            $table->dateTime('incident_time');
            $table->string('evidence_file')->nullable();
            $table->enum('condition_level', [
                'low',
                'medium',
                'high'
            ]);

            $table->decimal('latitude', 10, 7);
            $table->decimal('longitude', 10, 7);

            $table->enum('status', [
                'submitted',
                'under_review',
                'reviewed',
                'forwarded',
                'closed'
            ])->default('submitted');

            $table->timestamps();

            $table->foreign('reporter_id')
                ->references('user_id')
                ->on('users')
                ->cascadeOnDelete();

            $table->foreign('address_id')
                ->references('address_id')
                ->on('addresses')
                ->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
