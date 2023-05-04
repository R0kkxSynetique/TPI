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
        Schema::create('propellers', function (Blueprint $table) {
            $table->id();
            $table->string('size');
            $table->enum('type', ["bois", "apc", "carbone", "nylon renforcé", "nylon pure"]);
            $table->integer('blade_number');
            $table->unique(['size', 'type', 'blade_number']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('propeller');
    }
};
