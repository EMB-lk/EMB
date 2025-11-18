<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Business extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'category_id',
        'name',
        'slug',
        'description',
        'address',
        'city',
        'phone',
        'email',
        'website',
        'opening_hours',
        'photos',
        'logo',
        'latitude',
        'longitude',
        'is_active',
        'is_verified',
        'view_count',
    ];

    protected $casts = [
        'photos' => 'array',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'is_active' => 'boolean',
        'is_verified' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }

    public function currentSubscription(): HasOne
    {
        return $this->hasOne(Subscription::class)
            ->where('status', 'active')
            ->latest();
    }

    public function customDomains(): HasMany
    {
        return $this->hasMany(CustomDomain::class);
    }

    public function getSubdomainAttribute(): string
    {
        return $this->slug . '.emb.lk';
    }

    public function incrementViewCount(): void
    {
        $this->increment('view_count');
    }

    /**
     * Check if the business has an active subscription
     */
    public function hasActiveSubscription(): bool
    {
        $subscription = $this->currentSubscription;
        return $subscription && $subscription->isActive();
    }

    /**
     * Get the current plan
     */
    public function getCurrentPlan(): ?Plan
    {
        return $this->currentSubscription?->plan;
    }

    /**
     * Check if the business can access a specific feature
     */
    public function canAccessFeature(string $feature): bool
    {
        $plan = $this->getCurrentPlan();

        if (!$plan) {
            return false;
        }

        return match($feature) {
            'custom_domain' => $plan->custom_domain,
            'analytics' => $plan->analytics,
            'priority_support' => $plan->priority_support,
            default => false,
        };
    }

    /**
     * Check if the business can upload photos
     */
    public function canUploadPhotos(int $count = 1): bool
    {
        $plan = $this->getCurrentPlan();
        $maxPhotos = $plan ? $plan->max_photos : 5;
        $currentPhotos = is_array($this->photos) ? count($this->photos) : 0;

        return ($currentPhotos + $count) <= $maxPhotos;
    }

    /**
     * Get remaining photo slots
     */
    public function getRemainingPhotoSlots(): int
    {
        $plan = $this->getCurrentPlan();
        $maxPhotos = $plan ? $plan->max_photos : 5;
        $currentPhotos = is_array($this->photos) ? count($this->photos) : 0;

        return max(0, $maxPhotos - $currentPhotos);
    }

    /**
     * Get max photos allowed
     */
    public function getMaxPhotos(): int
    {
        $plan = $this->getCurrentPlan();
        return $plan ? $plan->max_photos : 5;
    }

    /**
     * Check if the business is on a free plan
     */
    public function isOnFreePlan(): bool
    {
        $plan = $this->getCurrentPlan();
        return $plan && $plan->is_free;
    }

    /**
     * Check if the business is on a professional plan
     */
    public function isOnProfessionalPlan(): bool
    {
        $plan = $this->getCurrentPlan();
        return $plan && !$plan->is_free;
    }
}
