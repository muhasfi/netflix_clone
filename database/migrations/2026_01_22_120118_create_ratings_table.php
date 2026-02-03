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
         Schema::create('content.ratings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('auth.users')->onDelete('cascade');
            $table->foreignId('movie_id')->constrained('content.movies')->onDelete('cascade');
            $table->decimal('rating', 3, 1)->unsigned();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('content.ratings');
    }
};
