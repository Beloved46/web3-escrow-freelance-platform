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
        Schema::create('agreements', function (Blueprint $table) {
            $table->id();
            $table->foreignUlid('client_id')->constrained('users')->onDelete('cascade');
            $table->foreignUlid('creator_id')->constrained('users')->onDelete('cascade');
            $table->string('client_wallet_address')->nullable(); // Optional, if client has a wallet
            $table->string('creator_wallet_address')->nullable(); // Optional, if creator has a wallet
            $table->string('blockchain_agreement_id')->unique(); // Unique ID for the agreement on the blockchain
            $table->string('title');
            $table->text('description')->nullable();
            $table->decimal('total_value', 20, 2); // Total value of the agreement in the smallest unit (e.g., wei for Ethereum)
            $table->enum('status', ['draft', 'active', 'completed', 'cancelled'])->default('draft');
            $table->date('due_date')->nullable(); // Optional due date for the agreement
            $table->timestamp('created_at_blockchain')->nullable(); // When the agreement was created on the blockchain
            $table->string('transaction_hash')->nullable(); // Transaction hash of the creation transaction
           
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agreements');
    }
};
