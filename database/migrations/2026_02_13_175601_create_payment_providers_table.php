<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * 4) payment_providers
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment_providers', function (Blueprint $table) {
            $table->id()->comment('Primary key');

            $table->string('key')
                ->unique()
                ->comment('Unique provider key (e.g., asaas, stripe, mercadopago)');

            $table->string('name')
                ->comment('Provider display name');

            $table->string('website')
                ->nullable()
                ->comment('Provider website URL (optional)');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_providers');
    }
};
