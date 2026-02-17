<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * 3) first_charge_modes
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('first_charge_modes', function (Blueprint $table) {
            $table->id()->comment('Primary key');

            $table->string('key')
                ->unique()
                ->comment('Unique machine key (immediate, next_period, fixed_date)');

            $table->string('label')
                ->comment('Human-friendly label (e.g., Immediate, Next Period, Fixed Date)');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('first_charge_modes');
    }
};
