<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->string('payment_number', 50)->unique();
            $table->decimal('amount', 12, 2);
            $table->enum('type', ['deposit', 'balance'])->default('deposit');
            $table->enum('method', ['mpesa', 'bank_transfer', 'cash', 'card'])->default('mpesa');
            $table->string('mpesa_code', 50)->nullable()->unique();
            $table->string('phone', 20)->nullable();
            $table->enum('status', ['pending', 'completed', 'failed', 'refunded'])->default('pending');
            $table->timestamp('payment_date')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index('order_id');
            $table->index('status');
            $table->index('mpesa_code');
        });
    }

    public function down()
    {
        Schema::dropIfExists('payments');
    }
};