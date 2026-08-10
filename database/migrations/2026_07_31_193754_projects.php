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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description');
            $table->string('image')->nullable();
            $table->json('tech_stack')->nullable();
            $table->string('role')->nullable()->default('Frontend Developer');
            $table->year('year')->nullable()->default(now()->year);
            $table->string('industry')->nullable()->default('Technology');
            $table->string('client')->nullable()->default('Self');
            $table->string('client_url')->nullable();
            $table->json('client_comment')->nullable();
            $table->string('github_url')->nullable();
            $table->enum('project_type', ['web', 'mobile', 'desktop', 'other'])->default('web');
            $table->enum('view_type', ['live', 'preview'])->default('live');
            $table->string('live_url')->nullable();
            $table->boolean('featured')->default(false);
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->json('metrics')->nullable();
            $table->text('other_details')->nullable();
            $table->json('meta')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
