<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->dropUnique(
                'reservations_student_id_menu_id_unique'
            );

            $table->index(
                ['student_id', 'menu_id'],
                'reservations_student_id_menu_id_index'
            );
        });
    }

    public function down(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->dropIndex(
                'reservations_student_id_menu_id_index'
            );

            $table->unique(
                ['student_id', 'menu_id'],
                'reservations_student_id_menu_id_unique'
            );
        });
    }
};
