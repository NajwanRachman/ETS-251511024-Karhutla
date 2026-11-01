<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('report_forwardings', function (Blueprint $table) {
            $table->bigIncrements('forwarding_id');

            $table->unsignedBigInteger('report_id');
            $table->unsignedBigInteger('coordinator_id');

            $table->dateTime('forwarded_at');
            $table->text('forwarding_note')->nullable();
            $table->string('destination_name');

            $table->timestamps();

            $table->foreign('report_id')
                ->references('report_id')
                ->on('reports')
                ->cascadeOnDelete();

            $table->foreign('coordinator_id')
                ->references('user_id')
                ->on('users')
                ->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('report_forwardings');
    }
};
