<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * 2) recurrence_units
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('recurrence_units', function (Blueprint $table) {
            $table->id()->comment('Primary key');

            $table->string('key')
                ->unique()
                ->comment('Unique machine key (e.g., week, month, year)');

            $table->string('label')
                ->comment('Human-friendly label (e.g., Weekly, Monthly, Yearly)');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recurrence_units');
    }
};
