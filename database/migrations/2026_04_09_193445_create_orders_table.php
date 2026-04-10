<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number', 20)->unique();
            $table->foreignId('customer_id')->constrained('users')->onDelete('cascade');
            $table->string('customer_name');
            $table->string('customer_phone', 20);
            $table->text('customer_address')->nullable();
            $table->text('description')->nullable();
            $table->decimal('total_amount', 12, 2);
            $table->decimal('deposit_amount', 12, 2)->default(0);
            $table->decimal('balance_amount', 12, 2)->default(0);
            $table->enum('status', ['pending', 'materials_ordered', 'production', 'quality_check', 'ready', 'delivered', 'cancelled'])->default('pending');
            $table->date('order_date');
            $table->date('estimated_ready_date')->nullable();
            $table->date('actual_ready_date')->nullable();
            $table->date('delivered_date')->nullable();
            $table->boolean('delivery_required')->default(false);
            $table->text('delivery_address')->nullable();
            $table->text('special_instructions')->nullable();
            $table->timestamps();

            $table->index('order_number');
            $table->index('status');
            $table->index('customer_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
};