<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use App\Models\Agreement; // Added this import for the new method

class DashboardController extends Controller
{
    // GET /api/dashboard-data
    public function getDashboardData(Request $request)
    {
        $user = Auth::user();
        $cacheKey = 'dashboard_data_' . $user->id;
        $data = Cache::get($cacheKey, [
            'agreements' => [],
            'stats' => [
                'active' => 0,
                'value_protected' => 0,
                'success_rate' => 0,
            ],
            'recent_activity' => [],
        ]);
        return response()->json($data);
    }

    // POST /api/sync-dashboard
    public function syncDashboardData(Request $request)
    {
        $user = Auth::user();
        $cacheKey = 'dashboard_data_' . $user->id;
        $data = $request->all();
        Cache::put($cacheKey, $data, now()->addMinutes(30));
        return response()->json(['success' => true]);
    }

    /**
     * Get cached dashboard data for immediate display
     */
    public function getCachedData(Request $request)
    {
        try {
            $user = $request->user();
            
            // Get user's agreements from database (cached)
            $agreements = Agreement::where('user_id', $user->id)
                ->orWhere('client_email', $user->email)
                ->orWhere('creator_email', $user->email)
                ->with(['milestones'])
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(function ($agreement) {
                    return [
                        'id' => $agreement->id,
                        'title' => $agreement->title,
                        'description' => $agreement->description,
                        'client_name' => $agreement->client_name,
                        'creator_name' => $agreement->creator_name,
                        'value' => $agreement->value ? '$' . number_format($agreement->value, 2) : 'Not set',
                        'status' => $agreement->status,
                        'progress' => $this->calculateProgress($agreement),
                        'due_date' => $agreement->due_date ? date('M j, Y', strtotime($agreement->due_date)) : 'No deadline',
                        'milestones_left' => $agreement->milestones->where('status', 'pending')->count(),
                        'created_at' => $agreement->created_at->format('M j, Y'),
                        'source' => 'database'
                    ];
                });

            // Calculate stats
            $stats = [
                'total' => $agreements->count(),
                'active' => $agreements->whereIn('status', ['active', 'inprogress'])->count(),
                'completed' => $agreements->where('status', 'completed')->count(),
                'disputed' => $agreements->where('status', 'disputed')->count(),
            ];

            return response()->json([
                'success' => true,
                'agreements' => $agreements,
                'stats' => $stats,
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'wallet_address' => $user->wallet_address,
                    'has_wallet' => !empty($user->wallet_address)
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to load dashboard data',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Calculate agreement progress based on milestones
     */
    private function calculateProgress($agreement)
    {
        $milestones = $agreement->milestones;
        if ($milestones->isEmpty()) {
            return 0;
        }

        $totalMilestones = $milestones->count();
        $completedMilestones = $milestones->where('status', 'completed')->count();
        
        return round(($completedMilestones / $totalMilestones) * 100);
    }
} 