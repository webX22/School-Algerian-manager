<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('meal_distributions', function (Blueprint $table) {
            $table->foreignId('reservation_id')
                ->nullable()
                ->after('id')
                ->constrained('reservations')
                ->restrictOnDelete();

            $table->unique('reservation_id');
        });
    }

    public function down(): void
    {
        Schema::table('meal_distributions', function (Blueprint $table) {
            $table->dropUnique([
                'reservation_id',
            ]);

            $table->dropConstrainedForeignId('reservation_id');
        });
    }
};