<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * 6) user_payment_gateways
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_payment_gateways', function (Blueprint $table) {
            $table->id()->comment('Primary key');

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete()
                ->comment('Owner user (account) that owns this gateway connection');

            $table->foreignId('payment_provider_id')
                ->constrained('payment_providers')
                ->restrictOnDelete()
                ->comment('Payment provider reference (e.g., Asaas, Stripe)');

            $table->foreignId('status_id')
                ->constrained('statuses')
                ->restrictOnDelete()
                ->comment('Gateway connection status reference (statuses.scope = gateway_connection)');

            $table->string('name')
                ->comment('Connection name (e.g., "Asaas - Main", "Stripe - EU")');

            $table->boolean('is_default')
                ->default(false)
                ->comment('Whether this gateway is the default gateway for the user');

            $table->text('credentials_encrypted')
                ->nullable()
                ->comment('Encrypted credentials payload (API keys/tokens)');

            $table->text('webhook_secret_encrypted')
                ->nullable()
                ->comment('Encrypted webhook secret or signing secret (if applicable)');

            $table->timestamps();

            $table->index(['user_id', 'payment_provider_id'], 'user_gateways_user_provider_idx');
            $table->index(['user_id', 'is_default'], 'user_gateways_user_default_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_payment_gateways');
    }
};
