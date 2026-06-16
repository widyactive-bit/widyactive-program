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
        Schema::create('performance_metrics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('athlete_id')->constrained()->onDelete('cascade');
            $table->integer('readiness_score')->default(50);
            $table->integer('performance_score')->default(50);
            $table->float('speed')->default(5.0);
            $table->float('strength')->default(5.0);
            $table->float('endurance')->default(5.0);
            $table->integer('mental_score')->default(50);
            $table->date('recorded_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('performance_metrics');
    }
};
