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
        Schema::create('transactions', function (Blueprint $user) {
            $user->uuid('id')->primary();
            $user->foreignId('user_id')->constrained()->onDelete('cascade');
            $user->foreignId('listing_id')->nullable()->constrained()->onDelete('set null');
            $user->decimal('amount', 15, 2);
            $user->string('status')->default('Success');
            $user->string('payment_method')->nullable();
            $user->timestamps();
            $user->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
