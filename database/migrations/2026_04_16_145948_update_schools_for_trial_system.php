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
        Schema::table('schools', function (Blueprint $table) {
            // 1. Drop subscription_amount if it exists (since we are moving to fixed plans)
            if (Schema::hasColumn('schools', 'subscription_amount')) {
                $table->dropColumn('subscription_amount');
            }

            // 2. Only add 'plan' if it does NOT exist
            if (!Schema::hasColumn('schools', 'plan')) {
                $table->string('plan')->default('trial')->after('address');
            } else {
                // If it exists, we just make sure the default is 'trial'
                $table->string('plan')->default('trial')->change();
            }

            // 3. Add trial and expiry dates if they don't exist
            if (!Schema::hasColumn('schools', 'trial_ends_at')) {
                $table->timestamp('trial_ends_at')->nullable()->after('plan');
            }
            
            if (!Schema::hasColumn('schools', 'subscription_expires_at')) {
                $table->timestamp('subscription_expires_at')->nullable()->after('trial_ends_at');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
