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
        Schema::table('rc_models', function (Blueprint $table) {
            $table->date('acquired_on')->nullable();
            $table->date('finished_on')->nullable();
            $table->date('first_flown_on')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rc_models', function (Blueprint $table) {
            $table->dropColumn(['acquired_on', 'finished_on', 'first_flown_on']);
        });
    }
};
