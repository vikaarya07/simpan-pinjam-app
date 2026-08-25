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
        Schema::create('savings', function (Blueprint $table) {
            $table->id();
            $table->date('transaction_date');
            $table->enum('type', [
                'Opening',
                'Loan',
                'Loan Overdue',
                'Installment',
                'Assistance',
            ]);
            $table->decimal('debit', 15, 0)->default(0);
            $table->decimal('credit', 15, 0)->default(0);
            $table->decimal('balance', 15, 0)->default(0);
            $table->decimal('receivable', 15, 0)->default(0);
            $table->decimal('amount', 15, 0)->default(0);
            $table->decimal('interest_percent', 5, 2)->default(0);
            $table->decimal('interest_amount', 15, 0)->default(0);
            $table->text('description')->nullable();
            $table->timestamps();
            $table->unique([
                'transaction_date',
                'type',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('savings');
    }
};
