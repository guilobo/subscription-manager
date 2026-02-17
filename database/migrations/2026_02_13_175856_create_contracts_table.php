<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * 7) contracts
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->id()->comment('Primary key');

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete()
                ->comment('Owner user (account) that created this contract');

            $table->foreignId('status_id')
                ->constrained('statuses')
                ->restrictOnDelete()
                ->comment('Contract status reference (statuses.scope = contract)');

            $table->foreignId('user_payment_gateway_id')
                ->constrained('user_payment_gateways')
                ->restrictOnDelete()
                ->comment('Default payment gateway connection used by this contract');

            $table->string('name')->comment('Contract name/title');
            $table->text('description')->nullable()->comment('Optional contract description/notes');

            // Defaults
            $table->decimal('default_amount', 12, 2)->comment('Default amount per billing cycle');
            $table->char('default_currency', 3)->default('BRL')->comment('Default ISO currency code (e.g., BRL, USD)');

            $table->unsignedTinyInteger('default_due_day')
                ->nullable()
                ->comment('Default due day of month (recommended 1-28 to avoid invalid dates)');

            $table->unsignedSmallInteger('default_due_days_after_issue')
                ->nullable()
                ->comment('Default due date offset in days after issue (alternative to due_day)');

            // Recurrence
            $table->foreignId('recurrence_unit_id')
                ->constrained('recurrence_units')
                ->restrictOnDelete()
                ->comment('Recurrence unit reference (week/month/year)');

            $table->unsignedTinyInteger('recurrence_interval')
                ->default(1)
                ->comment('How many recurrence units per cycle (e.g., 2 months = bimonthly)');

            // First charge
            $table->foreignId('first_charge_mode_id')
                ->constrained('first_charge_modes')
                ->restrictOnDelete()
                ->comment('Default first charge generation mode');

            $table->date('first_charge_date')
                ->nullable()
                ->comment('Default fixed first charge date (used when first_charge_mode = fixed_date)');

            // Lifetime
            $table->date('starts_at')->nullable()->comment('Optional contract start date');
            $table->date('ends_at')->nullable()->comment('Optional contract end date');

            $table->timestamps();

            $table->index(['user_id', 'status_id'], 'contracts_user_status_idx');
            $table->index(['user_id', 'user_payment_gateway_id'], 'contracts_user_gateway_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contracts');
    }
};
