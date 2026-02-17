<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('statuses', function (Blueprint $table) {
            $table->id()->comment('Primary key');

            $table->string('key')
                ->comment('Unique machine key (e.g., active, inactive, draft, pending, paid)');

            $table->string('label')
                ->comment('Human-friendly label (e.g., Active, Pending Payment)');

            $table->string('scope')
                ->nullable()
                ->comment('Optional scope/category (e.g., client, contract, subscription, charge, payment, gateway_connection)');

            $table->timestamps();

            // Indexes
            $table->index(['scope'], 'statuses_scope_idx');

            // Allow same key across different scopes, but unique per scope
            $table->unique(['scope', 'key'], 'statuses_scope_key_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('statuses');
    }
};
