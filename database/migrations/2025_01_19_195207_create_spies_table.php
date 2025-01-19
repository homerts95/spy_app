// database/migrations/2024_01_19_000001_create_spies_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('spies', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('agency'); //  casts to enum in the model
            $table->string('country_of_operation');
            $table->date('date_of_birth');

            $table->date('date_of_death')->nullable();

            $table->timestamps();

            // Indexes for performance
            $table->index(['first_name', 'last_name']);
            $table->index('date_of_birth');
            $table->index('date_of_death');
            $table->index('agency');

            // Unique constraint for name combination
            $table->unique(['first_name', 'last_name'], 'unique_spy_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spies');
    }
};
