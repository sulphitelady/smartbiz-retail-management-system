<?php

namespace App\Http\Controllers;

use App\Models\Product;

class InventoryController extends Controller
{
    public function index()
    {
        $products = Product::all();

        $totalProducts = Product::count();
        $lowStock = Product::where('quantity', '>', 0)
                           ->where('quantity', '<=', 10)
                           ->count();

        $outStock = Product::where('quantity', 0)->count();

        $status = 'Good';

        return view('inventory.index', compact(
            'products',
            'totalProducts',
            'lowStock',
            'outStock',
            'status'
        ));
    }
}