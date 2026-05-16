<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('folio')->unique();
            $table->foreignId('client_id')->constrained('clients')->cascadeOnDelete();
            $table->foreignId('client_membership_id')->nullable()->constrained('client_memberships')->nullOnDelete();
            $table->foreignId('membership_plan_id')->constrained('membership_plans');
            $table->decimal('amount', 10, 2);
            $table->enum('payment_method', ['cash', 'card', 'transfer', 'other'])->default('cash');
            $table->enum('status', ['paid', 'pending', 'cancelled'])->default('paid');
            $table->foreignId('registered_by')->constrained('users');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
