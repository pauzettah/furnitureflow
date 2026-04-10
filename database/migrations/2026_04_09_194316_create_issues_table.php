<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('issues', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reported_by')->constrained('users')->onDelete('cascade');
            $table->foreignId('order_id')->nullable()->constrained()->onDelete('set null');
            $table->string('issue_number', 50)->unique();
            $table->enum('type', [
                'missing_materials',
                'unclear_specs',
                'damaged_materials',
                'incorrect_dimensions',
                'customer_not_available',
                'wrong_address',
                'vehicle_breakdown',
                'other'
            ]);
            $table->text('description');
            $table->enum('urgency', ['low', 'medium', 'high'])->default('medium');
            $table->enum('status', ['open', 'in_progress', 'resolved', 'closed'])->default('open');
            $table->text('resolution_notes')->nullable();
            $table->foreignId('resolved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('resolved_at')->nullable();
            $table->timestamps();

            $table->index(['status', 'urgency']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('issues');
    }
};