<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('deliveries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('driver_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('delivery_number', 50)->unique();
            $table->string('customer_name');
            $table->string('customer_phone', 20);
            $table->text('delivery_address');
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->date('scheduled_date');
            $table->string('time_slot', 50);
            $table->time('actual_departure_time')->nullable();
            $table->time('actual_arrival_time')->nullable();
            $table->string('otp_code', 6)->nullable();
            $table->string('proof_photo')->nullable();
            $table->text('delivery_notes')->nullable();
            $table->enum('status', ['pending', 'assigned', 'en_route', 'delivered', 'failed', 'rescheduled'])->default('pending');
            $table->timestamp('delivered_at')->nullable();
            $table->timestamps();

            $table->index(['driver_id', 'status']);
            $table->index('scheduled_date');
        });
    }

    public function down()
    {
        Schema::dropIfExists('deliveries');
    }
};