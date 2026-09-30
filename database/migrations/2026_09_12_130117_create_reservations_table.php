<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();

            $table->foreignId('student_id')
                ->constrained('students')
                ->restrictOnDelete();

            $table->foreignId('menu_id')
                ->constrained('menus')
                ->restrictOnDelete();

            $table->enum('status', [
                'reserved',
                'cancelled',
            ])->default('reserved');

            $table->timestamp('reserved_at')->useCurrent();

            $table->timestamp('cancelled_at')->nullable();

            $table->timestamps();

            $table->unique([
                'student_id',
                'menu_id',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};