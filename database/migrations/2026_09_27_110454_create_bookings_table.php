<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();

            $table->foreignId('customer_id')
                ->constrained()
                ->restrictOnDelete();

            $table->foreignId('staff_profile_id')
                ->constrained()
                ->restrictOnDelete();

            $table->foreignId('service_id')
                ->constrained()
                ->restrictOnDelete();

            $table->date('booking_date');

            $table->time('start_time');
            $table->time('end_time');

            $table->string('status')->default('confirmed');

            $table->text('notes')->nullable();

            $table->timestamps();

            $table->index([
                'staff_profile_id',
                'booking_date',
            ]);

            $table->index([
                'customer_id',
                'booking_date',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};