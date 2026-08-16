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
        Schema::table('chat_conversations', function (Blueprint $table) {
            $table->string('client_name')->nullable()->after('user_agent');
            $table->string('client_email')->nullable()->after('client_name');
            $table->string('client_phone')->nullable()->after('client_email');
            $table->text('project_summary')->nullable()->after('client_phone');
            $table->string('estimated_budget')->nullable()->after('project_summary');
            $table->string('lead_score')->default('COLD')->after('estimated_budget');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('chat_conversations', function (Blueprint $table) {
            $table->dropColumn(['client_name', 'client_email', 'client_phone', 'project_summary', 'estimated_budget', 'lead_score']);
        });
    }
};
