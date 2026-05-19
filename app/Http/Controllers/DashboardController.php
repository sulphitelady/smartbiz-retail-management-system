<?php

namespace App\Http\Controllers;

use App\Models\{Customer, Product, Sale, User};
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        /*
        |-----------------------------
        | USER STATS (ADMIN ONLY)
        |-----------------------------
        */
        $users = null;

        if ($user->hasRole('admin')) {
            $users = [
                'total'   => User::count(),
                'staff'   => User::role('staff')->count(),
                'manager' => User::role('manager')->count(),
                'pending' => User::where('status', 'pending')->count(),
            ];
        }

        /*
        |-----------------------------
        | COMMON STATS (ALL ROLES)
        |-----------------------------
        */
        $stats = [
            'total_products'  => Product::count(),
            'total_customers' => Customer::count(),

            // FIXED: only completed sales
            'total_sales' => Sale::where('status', 'completed')->count(),

            // FIXED: safe monthly revenue
            'monthly_revenue' => Sale::where('status', 'completed')
                ->whereYear('created_at', now()->year)
                ->whereMonth('created_at', now()->month)
                ->sum('total'),
        ];

        return view('dashboard', [
            'users' => $users,
            'stats' => $stats,
            'monthlyRevenue' => $this->getMonthlyRevenue(),
            'categoryStats'  => $this->getCategoryStats(),
        ]);
    }

    /*
    |-----------------------------
    | MONTHLY REVENUE (CHART SAFE)
    | ALWAYS RETURNS 12 MONTHS
    |-----------------------------
    */
    private function getMonthlyRevenue()
    {
        $raw = Sale::selectRaw('MONTH(created_at) as month, SUM(total) as revenue')
            ->where('status', 'completed')
            ->whereYear('created_at', now()->year)
            ->groupBy('month')
            ->pluck('revenue', 'month');

        $labels = [];
        $values = [];

        for ($m = 1; $m <= 12; $m++) {
            $labels[] = Carbon::create()->month($m)->format('F');
            $values[] = (float) ($raw[$m] ?? 0);
        }

        return [
            'labels' => $labels,
            'values' => $values,
        ];
    }

    /*
    |-----------------------------
    | CATEGORY STATS
    |-----------------------------
    */
    private function getCategoryStats()
    {
        return Product::join('categories', 'products.category_id', '=', 'categories.id')
            ->selectRaw('categories.name as category, COUNT(*) as total')
            ->groupBy('categories.name')
            ->pluck('total', 'category')
            ->toArray();
    }
}