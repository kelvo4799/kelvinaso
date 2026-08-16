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
        Schema::create('contact_replies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contact_id')->constrained('contacts')->onDelete('cascade');
            $table->enum('sender_type', ['visitor', 'admin'])->default('admin');
            $table->string('sender_name');
            $table->string('sender_email');
            $table->text('message');
            $table->boolean('sent_via_email')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_replies');
    }
};
