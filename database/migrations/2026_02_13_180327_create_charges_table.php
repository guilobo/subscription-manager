<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * 9) charges
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('charges', function (Blueprint $table) {
            $table->id()->comment('Primary key');

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete()
                ->comment('Owner user (account) that issued this charge');

            $table->foreignId('contract_id')
                ->constrained('contracts')
                ->cascadeOnDelete()
                ->comment('Source contract');

            $table->foreignId('client_id')
                ->constrained('clients')
                ->cascadeOnDelete()
                ->comment('Billed client');

            $table->foreignId('contract_client_id')
                ->constrained('contract_clients')
                ->cascadeOnDelete()
                ->comment('Subscription record used to generate this charge');

            $table->foreignId('status_id')
                ->constrained('statuses')
                ->restrictOnDelete()
                ->comment('Charge status reference (statuses.scope = charge)');

            $table->foreignId('user_payment_gateway_id')
                ->constrained('user_payment_gateways')
                ->restrictOnDelete()
                ->comment('Gateway connection used to create/process this charge');

            // Snapshot values
            $table->decimal('amount', 12, 2)->comment('Charge amount snapshot at generation time');
            $table->char('currency', 3)->comment('ISO currency code snapshot');

            $table->date('period_start')->nullable()->comment('Billing period start date (optional)');
            $table->date('period_end')->nullable()->comment('Billing period end date (optional)');

            $table->dateTime('issued_at')->comment('Datetime when the charge was generated');
            $table->dateTime('due_at')->comment('Datetime when the charge is due');

            $table->dateTime('paid_at')->nullable()->comment('Datetime when the charge was paid (if paid)');

            // External gateway metadata
            $table->string('gateway_charge_id')->nullable()->comment('External gateway charge/invoice identifier');
            $table->string('gateway_status_raw')->nullable()->comment('Last known raw gateway status (string)');

            $table->timestamps();

            $table->index(['client_id', 'status_id'], 'charges_client_status_idx');
            $table->index(['contract_client_id', 'due_at'], 'charges_cc_due_idx');
            $table->index(['user_id', 'issued_at'], 'charges_user_issued_idx');
            $table->index(['user_id', 'status_id', 'due_at'], 'charges_user_status_due_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('charges');
    }
};
