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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('loan_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignId('meeting_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->decimal('amount', 15, 2);
            $table->date('payment_date');
            $table->unsignedTinyInteger('payment_count');
            $table->enum('method', ['cash', 'transfer', 'qris'])
                ->default('cash');
            $table->text('note')->nullable();
            $table->unique(['loan_id', 'payment_count']);
            $table->unique(['loan_id', 'meeting_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
