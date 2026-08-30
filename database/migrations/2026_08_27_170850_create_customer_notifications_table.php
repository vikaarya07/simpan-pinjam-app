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

        Schema::create('customer_notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignId('loan_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();
            $table->foreignId('payment_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();
            $table->foreignId('meeting_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();
            $table->string('type');
            $table->string('title');
            $table->text('message');
            $table->json('data')
                ->nullable();
            $table->timestamp('read_at')
                ->nullable();
            $table->timestamp('sent_at')
                ->nullable();
            $table->timestamps();
            $table->index([
                'member_id',
                'type',
            ]);
            $table->index([
                'member_id',
                'read_at',
            ]);
            $table->index([
                'member_id',
                'sent_at',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_notifications');
    }
};
