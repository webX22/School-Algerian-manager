<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('meal_distributions', function (Blueprint $table) {
            // Remove foreign keys that currently depend on the old composite index.
            $table->dropForeign([
                'menu_id',
            ]);

            $table->dropForeign([
                'student_id',
            ]);

            // Remove the old unique constraint.
            $table->dropUnique(
                'meal_distributions_menu_id_student_id_unique'
            );

            // Recreate the foreign keys.
            $table->foreign('menu_id')
                ->references('id')
                ->on('menus')
                ->restrictOnDelete();

            $table->foreign('student_id')
                ->references('id')
                ->on('students')
                ->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('meal_distributions', function (Blueprint $table) {
            $table->dropForeign([
                'menu_id',
            ]);

            $table->dropForeign([
                'student_id',
            ]);

            $table->unique([
                'menu_id',
                'student_id',
            ]);

            $table->foreign('menu_id')
                ->references('id')
                ->on('menus')
                ->restrictOnDelete();

            $table->foreign('student_id')
                ->references('id')
                ->on('students')
                ->restrictOnDelete();
        });
    }
};