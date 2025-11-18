<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckSubscription
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $feature = null): Response
    {
        $business = $request->route('business');

        if (!$business) {
            return redirect()->route('dashboard')
                ->with('error', 'Business not found.');
        }

        // Check if business has an active subscription
        $subscription = $business->currentSubscription;

        if (!$subscription || !$subscription->isActive()) {
            return redirect()->route('subscription.plans', $business)
                ->with('error', 'Your subscription has expired. Please upgrade to continue.');
        }

        // If a specific feature is required, check if the plan supports it
        if ($feature) {
            $plan = $subscription->plan;

            switch ($feature) {
                case 'custom_domain':
                    if (!$plan->custom_domain) {
                        return redirect()->back()
                            ->with('error', 'This feature requires a Professional plan. Please upgrade.');
                    }
                    break;

                case 'analytics':
                    if (!$plan->analytics) {
                        return redirect()->back()
                            ->with('error', 'Analytics are only available on Professional plans. Please upgrade.');
                    }
                    break;

                case 'priority_support':
                    if (!$plan->priority_support) {
                        return redirect()->back()
                            ->with('error', 'Priority support is only available on Professional plans. Please upgrade.');
                    }
                    break;
            }
        }

        return $next($request);
    }
}
