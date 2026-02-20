<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function stats()
    {
        $today = now()->format('Y-m-d');
        
        // Total Revenue
        $totalRevenue = \App\Models\Order::where('status', 'paid')->sum('total_price');
        
        // Active Users (Customers)
        $activeUsers = \App\Models\Customer::count();
        
        // New Orders (Today)
        $newOrders = \App\Models\Order::whereDate('created_at', $today)->count();
        
        // Recent Activities (Latest 5 orders)
        $recentOrders = \App\Models\Order::with('customer')->latest()->take(5)->get();
        
        return response()->json([
            'totalRevenue' => $totalRevenue,
            'activeUsers' => $activeUsers,
            'newOrders' => $newOrders,
            'recentOrders' => $recentOrders
        ]);
    }
}
