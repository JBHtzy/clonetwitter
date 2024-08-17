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
        Schema::table('rooms', function (Blueprint $table) {
            // first => php artisan make:migration add_roomtype_id_to_rooms_table --table=rooms
            // second => put here in this function
            $table->integer('roomtype_id')->after('id'); // => <after> add this field after specific column
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rooms', function (Blueprint $table) {
            // third => and don't forget to add the rollback option:
            $table->dropColumn('roomtype_id');
        });
    }

    // lastly => run php artisan migrate
};
