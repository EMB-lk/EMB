<?php

namespace App\Http\Controllers;

use App\Models\Business;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'subscription:analytics']);
    }

    /**
     * Show analytics dashboard for a business
     */
    public function index(Business $business)
    {
        $this->authorize('update', $business);

        // Check if business has access to analytics
        if (!$business->canAccessFeature('analytics')) {
            return redirect()->route('subscription.plans', $business)
                ->with('error', 'Analytics are only available on Professional plans. Please upgrade.');
        }

        // Get analytics data
        $viewCount = $business->view_count;
        $photoCount = count($business->photos ?? []);
        $maxPhotos = $business->getMaxPhotos();

        // Simulate daily views for the last 30 days (in a real app, you'd track this)
        $dailyViews = $this->generateDailyViewsData($business);

        // Get popular times (simulated)
        $popularHours = $this->generatePopularHoursData($business);

        // Get recent activity
        $recentActivity = $this->getRecentActivity($business);

        return view('analytics.index', compact(
            'business',
            'viewCount',
            'photoCount',
            'maxPhotos',
            'dailyViews',
            'popularHours',
            'recentActivity'
        ));
    }

    /**
     * Generate daily views data for the last 30 days
     * In a production app, this would come from an analytics_events table
     */
    private function generateDailyViewsData(Business $business): array
    {
        $data = [];
        $totalViews = $business->view_count;

        // Distribute views across last 30 days (simulated)
        for ($i = 29; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $views = $i === 0 ? rand(5, 20) : rand(0, ceil($totalViews / 30));

            $data[] = [
                'date' => $date->format('M d'),
                'views' => $views,
            ];
        }

        return $data;
    }

    /**
     * Generate popular hours data
     * In a production app, this would come from actual tracking
     */
    private function generatePopularHoursData(Business $business): array
    {
        $data = [];

        for ($hour = 0; $hour < 24; $hour++) {
            $views = 0;

            // Simulate business hours being more popular
            if ($hour >= 9 && $hour <= 18) {
                $views = rand(10, 50);
            } elseif ($hour >= 19 && $hour <= 21) {
                $views = rand(5, 25);
            } else {
                $views = rand(0, 10);
            }

            $data[] = [
                'hour' => str_pad($hour, 2, '0', STR_PAD_LEFT) . ':00',
                'views' => $views,
            ];
        }

        return $data;
    }

    /**
     * Get recent activity for the business
     */
    private function getRecentActivity(Business $business): array
    {
        $activities = [];

        // Add subscription updates
        if ($business->currentSubscription) {
            $activities[] = [
                'type' => 'subscription',
                'message' => 'Subscribed to ' . $business->currentSubscription->plan->name,
                'date' => $business->currentSubscription->starts_at,
            ];
        }

        // Add photo uploads
        $photoCount = count($business->photos ?? []);
        if ($photoCount > 0) {
            $activities[] = [
                'type' => 'photos',
                'message' => "Uploaded {$photoCount} photo(s)",
                'date' => $business->updated_at,
            ];
        }

        // Add business creation
        $activities[] = [
            'type' => 'created',
            'message' => 'Business profile created',
            'date' => $business->created_at,
        ];

        // Sort by date descending
        usort($activities, function ($a, $b) {
            return $b['date'] <=> $a['date'];
        });

        return array_slice($activities, 0, 10);
    }
}
