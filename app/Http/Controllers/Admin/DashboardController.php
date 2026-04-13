<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Item;
use App\Models\Lending;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'totalUsers' => User::count(),
            'totalItems' => Item::count(),
            'totalCategories' => Category::count(),
            'activeLendings' => Lending::whereNull('return_date')->count(),
        ]);
    }
}
