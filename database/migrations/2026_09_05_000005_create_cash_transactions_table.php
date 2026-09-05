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
        Schema::create('cash_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_number', 50)->unique(); // BKM-202609-0001 or BKK-202609-0001
            $table->date('transaction_date');
            $table->enum('type', ['income', 'expense'])->default('income');
            $table->string('category', 60); // tuition_student, teacher_salary, building_rent, utilities, etc.
            $table->string('title', 255);
            $table->decimal('amount', 15, 2)->default(0);
            $table->string('payment_method', 50)->default('cash_kasir'); // cash_kasir, bank_mandiri, bank_bca, bank_bni, etc.
            $table->string('reference_type', 50)->nullable(); // student, reimbursement, manual
            $table->unsignedBigInteger('reference_id')->nullable();
            $table->longText('proof_file')->nullable(); // Base64 receipt/slip or URL
            $table->text('notes')->nullable();
            $table->string('recorded_by')->nullable();
            $table->timestamps();

            $table->index(['transaction_date', 'type']);
            $table->index(['category', 'payment_method']);
            $table->index(['reference_type', 'reference_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cash_transactions');
    }
};
