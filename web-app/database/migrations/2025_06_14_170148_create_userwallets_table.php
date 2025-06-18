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
        Schema::create('userwallets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('wallet_address')->unique();
            $table->string('wallet_type')->nullable(); // e.g., metamask, walletconnect, etc.
            $table->boolean('is_primary')->default(false);
            $table->timestamp('verified_at')->nullable(); // When the wallet was verified
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('userwallets');
    }
};
