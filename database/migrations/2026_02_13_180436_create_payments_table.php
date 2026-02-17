<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * 10) payments
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id()->comment('Primary key');

            $table->foreignId('charge_id')
                ->constrained('charges')
                ->cascadeOnDelete()
                ->comment('Related charge');

            $table->foreignId('status_id')
                ->constrained('statuses')
                ->restrictOnDelete()
                ->comment('Payment status reference (statuses.scope = payment)');

            $table->decimal('amount', 12, 2)->comment('Payment amount');
            $table->dateTime('paid_at')->nullable()->comment('Datetime when payment was confirmed');

            $table->string('method')->nullable()->comment('Payment method label (e.g., pix, card, boleto)');
            $table->string('gateway_transaction_id')->nullable()->comment('External gateway transaction identifier');

            $table->json('provider_payload')
                ->nullable()
                ->comment('Raw provider payload snapshot for auditing/debugging');

            $table->timestamps();

            $table->index(['charge_id', 'status_id'], 'payments_charge_status_idx');
            $table->index(['gateway_transaction_id'], 'payments_gateway_tx_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
