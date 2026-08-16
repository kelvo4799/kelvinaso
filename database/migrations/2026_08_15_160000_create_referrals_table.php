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
        // Add referral_code to users table if not exists
        if (!Schema::hasColumn('users', 'referral_code')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('referral_code')->nullable()->unique()->after('email');
            });
        }

        // Create referrals table
        Schema::create('referrals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('referrer_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('referred_user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('visitor_ip')->nullable();
            $table->text('user_agent')->nullable();
            $table->enum('status', ['pending', 'converted', 'paid'])->default('pending');
            $table->decimal('commission_amount', 10, 2)->default(0.00);
            $table->string('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('referrals');

        if (Schema::hasColumn('users', 'referral_code')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('referral_code');
            });
        }
    }
};
