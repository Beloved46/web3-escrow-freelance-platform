<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Support\Str;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, HasUlids, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'workos_id',
        'avatar',
        'wallet_address',
        'wallet_connected_at',
        'is_wallet_verified',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'workos_id',
        'remember_token',
    ];

    /**
     * Get the user's initials.
     */
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->map(fn (string $name) => Str::of($name)->substr(0, 1))
            ->implode('');
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'wallet_connected_at' => 'datetime',
            'is_wallet_verified' => 'boolean',
        ];
    }

    /**
     * Get the primary wallet address.
     *
     * @return string
     */
    public function getPrimaryWallet()
    {
        return $this->wallet_address;
    }


    /**
     * Check if the user has a connected and verified wallet.
     *
     * @return bool
     */
    public function hasConnectedWallet()
    {
        return !empty($this->wallet_address) && $this->is_wallet_verified;
    }

    /** 
    * Find a user by their wallet address.
    *
    * @param string $walletAddress
    * @return \App\Models\User|null
    */
    public static function findByWallet($walletAddress)
    {  
          return static::where('wallet_address', strtolower($walletAddress))->first();
    }

    /**
     * Get all of the wallets for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function wallets(): HasMany
    {
        return $this->hasMany(Userwallet::class, 'user_id', 'id');
    }
      
}
