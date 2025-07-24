<?php

namespace App\Http\Controllers\Api\ManageWallet;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class SaveWalletAddress extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
      try {
      
        $user = $request->user();

        $wallet = $user->wallets()->updateOrCreate(
            ['wallet_address' => strtolower($request->wallet_address)],
            [
                'wallet_type' => $request->wallet_type ?? 'metamask',
                'is_primary' => true,
                'verified_at' => now(),
            ]
        );
       
        $user->update([
            'wallet_address' => $wallet->wallet_address,
            'wallet_connected_at' => now(),
            'is_wallet_verified' => true,
        ]);

        return $this->successResponse(
            'Wallet address saved successfully.',
            ['wallet' => $wallet]
        );
      } catch (\Throwable $th) {
        Log::info($th);
        return $this->errorResponse(
            'Failed to save wallet address.',
            ['error' => $th->getMessage()],
            500
        );
      }
    }

    /**
     * Handle wallet disconnection.
     */
    public function disconnect(Request $request)
    {
        try {
            $user = $request->user();
            
            // Clear wallet from user
            $user->update([
                'wallet_address' => null,
                'wallet_connected_at' => null,
                'is_wallet_verified' => false,
            ]);
            
            // Clear all user wallets
            $user->wallets()->delete();

            return $this->successResponse(
                'Wallet disconnected successfully.',
                []
            );
        } catch (\Throwable $th) {
            Log::info($th);
            return $this->errorResponse(
                'Failed to disconnect wallet.',
                ['error' => $th->getMessage()],
                500
            );
        }
    }
}
