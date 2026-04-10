<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('carpenter_id')->constrained('users')->onDelete('cascade');
            $table->string('task_name');
            $table->text('description')->nullable();
            $table->enum('status', ['assigned', 'in_progress', 'completed', 'reported'])->default('assigned');
            $table->date('assigned_date');
            $table->date('due_date')->nullable();
            $table->date('completed_date')->nullable();
            $table->date('started_date')->nullable();
            $table->json('materials_used')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['carpenter_id', 'status']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('tasks');
    }
};