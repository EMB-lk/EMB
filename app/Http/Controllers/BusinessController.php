<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\Category;
use App\Models\Plan;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BusinessController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['show']);
    }

    public function index()
    {
        $businesses = auth()->user()->businesses()->with('category', 'currentSubscription.plan')->get();
        return view('business.index', compact('businesses'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('business.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'website' => 'nullable|url|max:255',
            'opening_hours' => 'nullable|string',
        ]);

        $validated['user_id'] = auth()->id();
        $validated['slug'] = Str::slug($validated['name']);

        // Ensure slug is unique
        $originalSlug = $validated['slug'];
        $counter = 1;
        while (Business::where('slug', $validated['slug'])->exists()) {
            $validated['slug'] = $originalSlug . '-' . $counter;
            $counter++;
        }

        $business = Business::create($validated);

        // Create free subscription automatically
        $freePlan = Plan::where('is_free', true)->first();
        if ($freePlan) {
            Subscription::create([
                'business_id' => $business->id,
                'plan_id' => $freePlan->id,
                'starts_at' => now(),
                'status' => 'active',
            ]);
        }

        return redirect()->route('business.show', $business->slug)
            ->with('success', 'Business profile created successfully! Your subdomain is: ' . $business->subdomain);
    }

    public function show($slug)
    {
        $business = Business::where('slug', $slug)
            ->with(['category', 'currentSubscription.plan'])
            ->firstOrFail();

        // Increment view count
        $business->incrementViewCount();

        return view('business.show', compact('business'));
    }

    public function edit(Business $business)
    {
        $this->authorize('update', $business);
        $categories = Category::all();
        return view('business.edit', compact('business', 'categories'));
    }

    public function update(Request $request, Business $business)
    {
        $this->authorize('update', $business);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'website' => 'nullable|url|max:255',
            'opening_hours' => 'nullable|string',
        ]);

        $business->update($validated);

        return redirect()->route('business.show', $business->slug)
            ->with('success', 'Business profile updated successfully!');
    }

    public function destroy(Business $business)
    {
        $this->authorize('delete', $business);
        $business->delete();

        return redirect()->route('business.index')
            ->with('success', 'Business profile deleted successfully!');
    }
}
