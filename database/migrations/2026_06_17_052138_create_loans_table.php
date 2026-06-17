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
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->string('loan_number')->unique();
            $table->string('slug')->unique();
            $table->date('loan_date');
            $table->enum('type', [
                'loan',
                'loan_overdue'
            ])->default('loan');
            $table->decimal('principal', 15, 0);
            $table->decimal('interest_percent', 5, 0)->default(5);
            $table->decimal('interest_amount', 15, 0)->default(0);
            $table->decimal('amount', 15, 0)->default(0);
            $table->decimal('remaining', 15, 0)->default(0);
            $table->enum('status', [
                'running',
                'finish'
            ])->default('running');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};
