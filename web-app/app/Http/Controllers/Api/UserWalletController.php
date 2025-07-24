<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserWalletController extends Controller
{
    public function getWalletByEmail(Request $request)
    {
        $email = $request->query('email');
        if (!$email) {
            return response()->json(['exists' => false]);
        }
        $user = User::where('email', $email)->first();
        if (!$user) {
            return response()->json(['exists' => false]);
        }
        // Check for wallet address (direct or via userwallet relationship)
        $wallet = $user->wallet_address ?? null;
        if (!$wallet && method_exists($user, 'userwallet')) {
            $wallet = optional($user->userwallet)->wallet_address;
        }
        return response()->json([
            'exists' => true,
            'wallet_address' => $wallet,
        ]);
    }
} 