<?php

namespace App\Http\Controllers;

use App\Models\Business;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('q');
        $category = $request->input('category');

        $businesses = Business::where('is_active', true)
            ->where('is_verified', true)
            ->when($query, function ($queryBuilder) use ($query) {
                $queryBuilder->where(function ($q) use ($query) {
                    $q->where('name', 'like', "%{$query}%")
                        ->orWhere('description', 'like', "%{$query}%")
                        ->orWhere('address', 'like', "%{$query}%")
                        ->orWhere('city', 'like', "%{$query}%");
                });
            })
            ->when($category, function ($queryBuilder) use ($category) {
                $queryBuilder->where('category_id', $category);
            })
            ->with('category')
            ->paginate(12);

        return view('search', compact('businesses', 'query', 'category'));
    }
}
