<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * 5) clients
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id()->comment('Primary key');

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete()
                ->comment('Owner user (account) that manages this client');

            $table->foreignId('status_id')
                ->constrained('statuses')
                ->restrictOnDelete()
                ->comment('Client status reference (statuses.scope = client)');

            $table->string('name')->comment('Client full name or business name');
            $table->string('email')->nullable()->comment('Client email address (used for billing notifications)');
            $table->string('document')->nullable()->comment('Client document/tax identifier (e.g., CPF/CNPJ)');
            $table->string('phone')->nullable()->comment('Client phone number');

            $table->timestamps();

            $table->index(['user_id', 'status_id'], 'clients_user_status_idx');
            $table->index(['user_id', 'email'], 'clients_user_email_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
