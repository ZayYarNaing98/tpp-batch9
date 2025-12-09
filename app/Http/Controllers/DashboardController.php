<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_products' => Product::count(),
            'total_categories' => Category::count(),
            'total_users' => User::count(),
            'active_products' => Product::where('status', 1)->count(),
            'inactive_products' => Product::where('status', 0)->count(),
            'active_users' => User::where('status', 1)->count(),
            'inactive_users' => User::where('status', 0)->count(),
            'recent_products' => Product::with('category')->latest()->take(5)->get(),
            'recent_users' => User::latest()->take(5)->get(),
        ];

        return view('dashboard.index', compact('stats'));
    }
}

