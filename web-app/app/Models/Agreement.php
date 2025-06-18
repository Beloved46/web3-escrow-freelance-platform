<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Agreement extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'client_id',
        'creator_id',
        'client_wallet_address',
        'creator_wallet_address',
        'blockchain_agreement_id', // Links to smart contract
        'title',
        'description',
        'total_value',
        'status',
        'due_date',
        'created_at_blockchain', // When created on blockchain
        'transaction_hash', // Creation transaction
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'total_value' => 'decimal:2',
            'due_date' => 'date',
            'created_at_blockchain' => 'datetime',
        ];
    }

    /**
     * Get the client associated with the agreement.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function client() : BelongsTo
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    /**
     * Get the creator of the agreement.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator() :BelongsTo
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    /**
     * Get the milestones associated with the agreement.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function milestones() : HasMany
    {
        return $this->hasMany(Milestone::class);
    }

    /**
     * Check if both client and creator have connected wallets.
     *
     * @return bool
     */
    public function bothPartiesHaveWallets()
    {
        return $this->client->hasConnectedWallet() && 
               $this->creator->hasConnectedWallet();
    }

    /**
     * Get the data needed for blockchain interaction.
     *
     * @return array<string, mixed>
     */
    public function getBlockchainData()
    {
        return [
            'client_address' => $this->client_wallet_address,
            'creator_address' => $this->creator_wallet_address,
            'description' => $this->description,
            'deadline' => $this->due_date ? $this->due_date->timestamp : 0,
        ];
    }
}
