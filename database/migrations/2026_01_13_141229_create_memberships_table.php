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
        Schema::create('billing.memberships', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('auth.users')->onDelete('cascade');
            $table->foreignId('plan_id')->constrained('billing.plans')->onDelete('cascade');
            $table->boolean('active')->default(false);
            $table->date('start_date');
            $table->date('end_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('billing.memberships');
    }
};
