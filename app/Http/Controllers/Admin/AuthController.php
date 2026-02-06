<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Show admin login form
     */
    public function showLogin()
    {
        if (Auth::check() && Auth::user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.auth.login');
    }

    /**
     * Handle admin login
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            
            // Check if user is admin
            if (!$user->isAdmin()) {
                Auth::logout();
                throw ValidationException::withMessages([
                    'email' => 'Access denied. Admin privileges required.',
                ]);
            }

            $request->session()->regenerate();
            return redirect()->intended(route('admin.dashboard'));
        }

        throw ValidationException::withMessages([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    /**
     * Handle admin logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }

    /**
     * Admin dashboard
     */
    public function dashboard()
    {
        $orders = \App\Models\Order::with(['payment']);
        
        // Statistics
        $stats = [
            'total' => \App\Models\Order::count(),
            'pending_payment' => \App\Models\Order::where('status', 'pending_payment')->count(),
            'payment_verification' => \App\Models\Order::where('status', 'payment_verification')->count(),
            'payment_confirmed' => \App\Models\Order::where('status', 'payment_confirmed')->count(),
            'shipped' => \App\Models\Order::where('status', 'shipped')->count(),
            'delivered' => \App\Models\Order::where('status', 'delivered')->count(),
            'has_waybill' => \App\Models\Order::whereNotNull('paxel_waybill')->count(),
            'no_waybill' => \App\Models\Order::whereNull('paxel_waybill')->whereIn('status', ['payment_confirmed', 'processing'])->count(),
        ];

        // Trend statistics (last 7 days)
        $trendData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $trendData[$date] = [
                'date' => now()->subDays($i)->format('d M'),
                'orders' => \App\Models\Order::whereDate('created_at', $date)->count(),
                'shipped' => \App\Models\Order::whereDate('created_at', $date)->whereNotNull('paxel_waybill')->count(),
                'delivered' => \App\Models\Order::whereDate('created_at', $date)->where('status', 'delivered')->count(),
            ];
        }

        // Revenue statistics
        $revenueStats = [
            'today' => \App\Models\Order::whereDate('created_at', today())->where('status', '!=', 'cancelled')->sum('total'),
            'this_week' => \App\Models\Order::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->where('status', '!=', 'cancelled')->sum('total'),
            'this_month' => \App\Models\Order::whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->where('status', '!=', 'cancelled')->sum('total'),
            'all_time' => \App\Models\Order::where('status', '!=', 'cancelled')->sum('total'),
        ];

        // Paxel statistics
        $paxelStats = [
            'total_shipments' => \App\Models\Order::whereNotNull('paxel_waybill')->count(),
            'pending_shipment' => \App\Models\Order::whereIn('status', ['payment_confirmed', 'processing'])->whereNull('paxel_waybill')->count(),
            'in_transit' => \App\Models\Order::where('status', 'shipped')->whereNotNull('paxel_waybill')->count(),
            'delivered_via_paxel' => \App\Models\Order::where('status', 'delivered')->whereNotNull('paxel_waybill')->count(),
        ];

        // Recent orders
        $recentOrders = \App\Models\Order::with(['items', 'payment'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('admin.dashboard', [
            'stats' => $stats,
            'trendData' => $trendData,
            'revenueStats' => $revenueStats,
            'paxelStats' => $paxelStats,
            'recentOrders' => $recentOrders,
        ]);
    }
}
