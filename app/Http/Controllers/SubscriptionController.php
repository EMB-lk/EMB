<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\Plan;
use App\Services\SubscriptionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    protected SubscriptionService $subscriptionService;

    public function __construct(SubscriptionService $subscriptionService)
    {
        $this->middleware('auth');
        $this->subscriptionService = $subscriptionService;
    }

    /**
     * Display all available plans
     */
    public function plans(Business $business)
    {
        $this->authorize('update', $business);

        $plans = Plan::where('active', true)->orderBy('price')->get();
        $currentPlan = $business->getCurrentPlan();

        return view('subscription.plans', compact('business', 'plans', 'currentPlan'));
    }

    /**
     * Show the subscription management page
     */
    public function manage(Business $business)
    {
        $this->authorize('update', $business);

        $subscription = $business->currentSubscription;
        $plan = $subscription?->plan;

        return view('subscription.manage', compact('business', 'subscription', 'plan'));
    }

    /**
     * Show the upgrade form
     */
    public function showUpgrade(Business $business, Plan $plan)
    {
        $this->authorize('update', $business);

        $currentPlan = $business->getCurrentPlan();

        // Prevent downgrade through upgrade route
        if ($currentPlan && $plan->price < $currentPlan->price) {
            return redirect()->route('subscription.plans', $business)
                ->with('error', 'Please use the downgrade option for lower-tier plans.');
        }

        return view('subscription.upgrade', compact('business', 'plan', 'currentPlan'));
    }

    /**
     * Process the upgrade
     */
    public function upgrade(Request $request, Business $business, Plan $plan)
    {
        $this->authorize('update', $business);

        $request->validate([
            'auto_renew' => 'boolean',
        ]);

        try {
            // If it's a paid plan, redirect to payment
            if (!$plan->is_free && $plan->price > 0) {
                // Store the selected plan in session for payment processing
                session([
                    'upgrade_business_id' => $business->id,
                    'upgrade_plan_id' => $plan->id,
                    'auto_renew' => $request->input('auto_renew', true),
                ]);

                return redirect()->route('payment.checkout', ['business' => $business, 'plan' => $plan]);
            }

            // For free plans, create subscription immediately
            $subscription = $this->subscriptionService->createSubscription(
                $business,
                $plan,
                $request->input('auto_renew', false)
            );

            return redirect()->route('subscription.manage', $business)
                ->with('success', 'Successfully subscribed to ' . $plan->name . '!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to upgrade: ' . $e->getMessage());
        }
    }

    /**
     * Process the downgrade
     */
    public function downgrade(Request $request, Business $business, Plan $plan)
    {
        $this->authorize('update', $business);

        try {
            $subscription = $this->subscriptionService->downgrade($business, $plan);

            return redirect()->route('subscription.manage', $business)
                ->with('success', 'Successfully downgraded to ' . $plan->name . '. Changes will take effect at the end of your current billing period.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to downgrade: ' . $e->getMessage());
        }
    }

    /**
     * Cancel subscription
     */
    public function cancel(Request $request, Business $business)
    {
        $this->authorize('update', $business);

        try {
            $this->subscriptionService->cancelActiveSubscriptions($business);

            // Assign free plan
            $freePlan = Plan::where('is_free', true)->first();
            if ($freePlan) {
                $this->subscriptionService->createSubscription($business, $freePlan, false);
            }

            return redirect()->route('subscription.manage', $business)
                ->with('success', 'Subscription cancelled. You have been moved to the free plan.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to cancel subscription: ' . $e->getMessage());
        }
    }

    /**
     * Enable auto-renewal
     */
    public function enableAutoRenew(Request $request, Business $business)
    {
        $this->authorize('update', $business);

        $subscription = $business->currentSubscription;

        if (!$subscription) {
            return redirect()->back()
                ->with('error', 'No active subscription found.');
        }

        $subscription->update(['auto_renew' => true]);

        return redirect()->back()
            ->with('success', 'Auto-renewal enabled.');
    }

    /**
     * Disable auto-renewal
     */
    public function disableAutoRenew(Request $request, Business $business)
    {
        $this->authorize('update', $business);

        $subscription = $business->currentSubscription;

        if (!$subscription) {
            return redirect()->back()
                ->with('error', 'No active subscription found.');
        }

        $subscription->update(['auto_renew' => false]);

        return redirect()->back()
            ->with('success', 'Auto-renewal disabled. Your subscription will not renew at the end of the current period.');
    }
}
