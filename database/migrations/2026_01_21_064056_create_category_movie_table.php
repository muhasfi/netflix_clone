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
        Schema::create('content.category_movie', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('content.categories')->onDelete('cascade');
            $table->foreignId('movie_id')->constrained('content.movies')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('content.category_movie');
    }
};
