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
        Schema::create('page_views', function (Blueprint $table) {
            $table->id();
            $table->string('path');
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->string('referer')->nullable();
            $table->uuid('visitor_id')->index();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamps();
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('page_views');
    }
};
