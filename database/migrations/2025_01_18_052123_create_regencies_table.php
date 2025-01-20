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
        Schema::create('regencies', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('alt_name');
            $table->double('latitude')->default(0);
            $table->double('longitude')->default(0);
            $table->bigInteger('population')->default(0)->nullable();
            $table->bigInteger('sekolah')->default(0)->nullable();
            $table->bigInteger('puskesmas')->default(0)->nullable();
            $table->enum('type_polygon', ['Polygon','MultiPolygon'])->default('Polygon')->nullable();
            $table->longText('polygon')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('regencies');
    }
};
