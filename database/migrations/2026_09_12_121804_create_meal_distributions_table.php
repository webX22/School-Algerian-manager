<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('meal_distributions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('menu_id')
                ->constrained('menus')
                ->restrictOnDelete();

            $table->foreignId('student_id')
                ->constrained('students')
                ->restrictOnDelete();

            $table->enum('status', [
                'served',
                'not_served',
            ])->default('served');

            $table->timestamp('served_at')->nullable();

            $table->foreignId('served_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->text('notes')->nullable();

            $table->timestamps();

            // A student can only have one distribution record
            // for the same scheduled menu.
            $table->unique(['menu_id', 'student_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('meal_distributions');
    }
};