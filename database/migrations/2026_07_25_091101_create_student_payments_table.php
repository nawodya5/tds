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
        Schema::create('student_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
            $table->foreignId('class_id')->constrained();
            $table->unsignedTinyInteger('payment_month');
            $table->unsignedSmallInteger('payment_year');
            $table->decimal('monthly_fee', 10, 2);
            $table->decimal('paid_amount', 10, 2)->default(0);
            $table->date('payment_date')->nullable();
            $table->enum('payment_status', ['Paid', 'Unpaid'])->default('Unpaid');
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['student_id', 'class_id', 'payment_month', 'payment_year'],'student_payment_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_payments');
    }
};
