<?php

namespace App\Services;

use App\Models\Business;
use App\Models\Plan;
use App\Models\Subscription;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class SubscriptionService
{
    /**
     * Create a new subscription for a business
     */
    public function createSubscription(Business $business, Plan $plan, bool $autoRenew = true): Subscription
    {
        // Calculate end date based on billing period
        $endsAt = $this->calculateEndDate($plan->billing_period);

        return DB::transaction(function () use ($business, $plan, $autoRenew, $endsAt) {
            // Cancel any existing active subscriptions
            $this->cancelActiveSubscriptions($business);

            // Create new subscription
            $subscription = Subscription::create([
                'business_id' => $business->id,
                'plan_id' => $plan->id,
                'starts_at' => now(),
                'ends_at' => $endsAt,
                'status' => 'active',
                'auto_renew' => $autoRenew,
            ]);

            return $subscription;
        });
    }

    /**
     * Upgrade a business to a new plan
     */
    public function upgrade(Business $business, Plan $newPlan): Subscription
    {
        $currentSubscription = $business->currentSubscription;

        if ($currentSubscription && $currentSubscription->plan_id === $newPlan->id) {
            throw new \Exception('Business is already on this plan.');
        }

        return $this->createSubscription($business, $newPlan);
    }

    /**
     * Downgrade a business to a new plan
     */
    public function downgrade(Business $business, Plan $newPlan): Subscription
    {
        return $this->createSubscription($business, $newPlan);
    }

    /**
     * Cancel active subscriptions for a business
     */
    public function cancelActiveSubscriptions(Business $business): void
    {
        Subscription::where('business_id', $business->id)
            ->where('status', 'active')
            ->update([
                'status' => 'cancelled',
                'auto_renew' => false,
            ]);
    }

    /**
     * Renew a subscription
     */
    public function renew(Subscription $subscription): Subscription
    {
        if (!$subscription->auto_renew) {
            throw new \Exception('Auto-renew is not enabled for this subscription.');
        }

        $endsAt = $this->calculateEndDate($subscription->plan->billing_period, $subscription->ends_at);

        $subscription->update([
            'ends_at' => $endsAt,
            'status' => 'active',
        ]);

        return $subscription->fresh();
    }

    /**
     * Check and expire subscriptions
     */
    public function expireSubscriptions(): void
    {
        Subscription::where('status', 'active')
            ->where('ends_at', '<=', now())
            ->update(['status' => 'expired']);
    }

    /**
     * Process expired subscriptions and downgrade to free plan
     */
    public function processExpiredSubscriptions(): void
    {
        $expiredSubscriptions = Subscription::where('status', 'expired')
            ->with('business')
            ->get();

        $freePlan = Plan::where('is_free', true)->first();

        if (!$freePlan) {
            throw new \Exception('Free plan not found.');
        }

        foreach ($expiredSubscriptions as $subscription) {
            // If auto-renew is enabled, attempt to renew (payment processing would happen here)
            if ($subscription->auto_renew) {
                // In a real implementation, this would trigger payment processing
                // For now, we'll just renew the subscription
                try {
                    $this->renew($subscription);
                } catch (\Exception $e) {
                    // If renewal fails, downgrade to free plan
                    $this->createSubscription($subscription->business, $freePlan, false);
                }
            } else {
                // Downgrade to free plan
                $this->createSubscription($subscription->business, $freePlan, false);
            }
        }
    }

    /**
     * Calculate end date based on billing period
     */
    private function calculateEndDate(string $billingPeriod, ?Carbon $startDate = null): ?Carbon
    {
        $startDate = $startDate ?? now();

        return match($billingPeriod) {
            'monthly' => $startDate->copy()->addMonth(),
            'yearly' => $startDate->copy()->addYear(),
            'lifetime' => null,
            default => null,
        };
    }

    /**
     * Check if a business can access a feature
     */
    public function canAccessFeature(Business $business, string $feature): bool
    {
        $subscription = $business->currentSubscription;

        if (!$subscription || !$subscription->isActive()) {
            return false;
        }

        $plan = $subscription->plan;

        return match($feature) {
            'custom_domain' => $plan->custom_domain,
            'analytics' => $plan->analytics,
            'priority_support' => $plan->priority_support,
            default => false,
        };
    }

    /**
     * Get remaining photo slots for a business
     */
    public function getRemainingPhotoSlots(Business $business): int
    {
        $subscription = $business->currentSubscription;

        if (!$subscription || !$subscription->isActive()) {
            // Default to free plan limits
            $freePlan = Plan::where('is_free', true)->first();
            $maxPhotos = $freePlan ? $freePlan->max_photos : 5;
        } else {
            $maxPhotos = $subscription->plan->max_photos;
        }

        $currentPhotos = is_array($business->photos) ? count($business->photos) : 0;

        return max(0, $maxPhotos - $currentPhotos);
    }

    /**
     * Check if a business can upload more photos
     */
    public function canUploadPhotos(Business $business, int $count = 1): bool
    {
        return $this->getRemainingPhotoSlots($business) >= $count;
    }
}
