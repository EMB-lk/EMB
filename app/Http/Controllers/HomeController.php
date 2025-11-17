<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $featuredBusinesses = Business::where('is_active', true)
            ->where('is_verified', true)
            ->with('category')
            ->latest()
            ->take(6)
            ->get();

        $categories = Category::withCount('businesses')->get();

        return view('home', compact('featuredBusinesses', 'categories'));
    }
}
