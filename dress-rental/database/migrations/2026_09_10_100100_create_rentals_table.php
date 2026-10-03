<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rentals', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('dress_id')
                ->constrained('dresses')
                ->cascadeOnDelete();

            $table->date('start_date');
            $table->date('end_date');

            $table->unsignedInteger('rental_days')->default(1);

            $table->decimal('price_per_day', 10, 2);
            $table->decimal('total_price', 10, 2);

            $table->string('status')->default('pending');

            $table->text('rejection_reason')->nullable();

            $table->string('return_condition')->nullable();
            $table->text('return_note')->nullable();

            $table->timestamp('approved_at')->nullable();
            $table->timestamp('returned_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rentals');
    }
};
