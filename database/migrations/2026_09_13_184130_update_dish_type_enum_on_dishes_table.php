<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        /*
         * Step 1:
         * Temporarily allow both the old meal types
         * and the new dish types.
         */
        Schema::table('dishes', function (Blueprint $table) {
            $table->enum('dish_type', [
                'breakfast',
                'lunch',
                'snack',
                'dinner',
                'appetizer',
                'main_course',
                'dessert',
            ])->change();
        });

        /*
         * Step 2:
         * Convert existing old values to the new system.
         */
        DB::table('dishes')
            ->where('dish_type', 'breakfast')
            ->update(['dish_type' => 'main_course']);

        DB::table('dishes')
            ->where('dish_type', 'lunch')
            ->update(['dish_type' => 'main_course']);

        DB::table('dishes')
            ->where('dish_type', 'snack')
            ->update(['dish_type' => 'appetizer']);

        DB::table('dishes')
            ->where('dish_type', 'dinner')
            ->update(['dish_type' => 'main_course']);

        /*
         * Step 3:
         * Keep only the new dish types.
         */
        Schema::table('dishes', function (Blueprint $table) {
            $table->enum('dish_type', [
                'appetizer',
                'main_course',
                'dessert',
            ])->change();
        });
    }

    public function down(): void
    {
        Schema::table('dishes', function (Blueprint $table) {
            $table->enum('dish_type', [
                'breakfast',
                'lunch',
                'snack',
                'dinner',
            ])->change();
        });
    }
};