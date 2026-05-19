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
            'total_sales'     => Sale::count(),
            'monthly_revenue' => Sale::whereMonth('created_at', now()->month)->sum('total'),
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
    | MONTHLY REVENUE (FIXED FOR CHART)
    |-----------------------------
    */
    private function getMonthlyRevenue()
    {
        $data = Sale::selectRaw('MONTH(created_at) as month, SUM(total) as revenue')
            ->whereYear('created_at', now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $labels = [];
        $values = [];

        foreach ($data as $row) {
            $labels[] = Carbon::create()->month($row->month)->format('F');
            $values[] = $row->revenue;
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