<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * 8) contract_clients
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contract_clients', function (Blueprint $table) {
            $table->id()->comment('Primary key');

            $table->foreignId('contract_id')
                ->constrained('contracts')
                ->cascadeOnDelete()
                ->comment('Related contract');

            $table->foreignId('client_id')
                ->constrained('clients')
                ->cascadeOnDelete()
                ->comment('Related client');

            $table->foreignId('status_id')
                ->constrained('statuses')
                ->restrictOnDelete()
                ->comment('Subscription status reference (statuses.scope = subscription)');

            // Overrides (nullable => use contract defaults)
            $table->decimal('custom_amount', 12, 2)
                ->nullable()
                ->comment('Custom amount for this client (overrides contract default_amount)');

            $table->char('custom_currency', 3)
                ->nullable()
                ->comment('Custom ISO currency code (overrides contract default_currency)');

            $table->unsignedTinyInteger('custom_due_day')
                ->nullable()
                ->comment('Custom due day of month (overrides contract default_due_day)');

            $table->unsignedSmallInteger('custom_due_days_after_issue')
                ->nullable()
                ->comment('Custom due date offset in days after issue (overrides contract default_due_days_after_issue)');

            // First charge override (optional)
            $table->foreignId('first_charge_mode_id')
                ->nullable()
                ->constrained('first_charge_modes')
                ->restrictOnDelete()
                ->comment('Optional first charge mode override for this client');

            $table->date('first_charge_date')
                ->nullable()
                ->comment('Optional fixed first charge date override (used when first_charge_mode = fixed_date)');

            // Scheduling
            $table->date('starts_at')->nullable()->comment('When this client starts this contract (optional)');
            $table->date('ends_at')->nullable()->comment('When this client ends this contract (optional)');

            $table->dateTime('next_charge_at')
                ->nullable()
                ->comment('Cached next charge datetime to optimize scheduler queries');

            $table->timestamps();

            $table->unique(['contract_id', 'client_id'], 'contract_clients_unique');
            $table->index(['status_id', 'next_charge_at'], 'contract_clients_status_next_idx');
            $table->index(['client_id', 'status_id'], 'contract_clients_client_status_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contract_clients');
    }
};
