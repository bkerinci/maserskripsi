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
        Schema::table('subscription_plans', function (Blueprint $table) {
            $table->decimal('discount_price', 10, 2)->nullable()->after('price');
            $table->string('promo')->nullable()->after('discount_price');
            $table->integer('duration_days')->default(30)->after('features');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->timestamp('subscription_ends_at')->nullable()->after('role');
            $table->foreignId('active_plan_id')->nullable()->constrained('subscription_plans')->nullOnDelete()->after('subscription_ends_at');
            $table->foreignId('next_plan_id')->nullable()->constrained('subscription_plans')->nullOnDelete()->after('active_plan_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('subscription_plans', function (Blueprint $table) {
            $table->dropColumn(['discount_price', 'promo', 'duration_days']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['active_plan_id']);
            $table->dropForeign(['next_plan_id']);
            $table->dropColumn(['subscription_ends_at', 'active_plan_id', 'next_plan_id']);
        });
    }
};
