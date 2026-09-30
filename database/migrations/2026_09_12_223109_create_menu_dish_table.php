<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('menu_dish', function (Blueprint $table) {
            $table->id();

            $table->foreignId('menu_id')
                ->constrained('menus')
                ->cascadeOnDelete();

            $table->foreignId('dish_id')
                ->constrained('dishes')
                ->cascadeOnDelete();

            $table->timestamps();

            $table->unique(['menu_id', 'dish_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('menu_dish');
    }
};

