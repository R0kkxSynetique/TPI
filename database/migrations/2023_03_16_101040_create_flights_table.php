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
        Schema::create('flights', function (Blueprint $table) {
            $table->string('location')->nullable();
            $table->date('date')->nullable();
            $table->time('time')->nullable();
            $table->string('url')->nullable();
            $table->enum('weather', ['sunny', 'partly cloudy', 'cloudy', 'overcast', 'fog', 'showers', 'heavy rain', 'snowy', 'sleet', 'clear'])->nullable();
            $table->time('duration')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
            $table->foreignId('rc_model_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->unique(['date', 'time', 'rc_model_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flights');
    }
};
