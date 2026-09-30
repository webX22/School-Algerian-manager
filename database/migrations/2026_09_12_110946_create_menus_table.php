<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->id();

            $table->foreignId('meal_id')
                ->constrained('meals')
                ->restrictOnDelete();

            $table->date('service_date');

            $table->time('service_time')->nullable();

            $table->integer('planned_quantity')->default(0);

            $table->text('notes')->nullable();

            $table->boolean('is_active')->default(true);

            $table->timestamps();

            $table->unique(['meal_id', 'service_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};