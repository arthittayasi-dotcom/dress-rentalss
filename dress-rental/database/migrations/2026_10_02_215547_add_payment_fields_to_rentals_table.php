<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rentals', function (Blueprint $table) {
            $table->string('slip_path')->nullable();
            $table->string('slip_hash', 64)->nullable()->unique();
            $table->string('payment_status')->default('unpaid');
            $table->string('payment_message')->nullable();
            $table->string('payment_reference')->nullable()->unique();
            $table->timestamp('paid_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('rentals', function (Blueprint $table) {
            $table->dropUnique(['slip_hash']);
            $table->dropUnique(['payment_reference']);
            $table->dropColumn(['slip_path', 'slip_hash', 'payment_status', 'payment_message', 'payment_reference', 'paid_at']);
        });
    }
};
