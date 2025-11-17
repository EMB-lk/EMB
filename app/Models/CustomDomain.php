<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class CustomDomain extends Model
{
    protected $fillable = [
        'business_id',
        'domain',
        'is_verified',
        'verification_token',
        'verified_at',
    ];

    protected $casts = [
        'is_verified' => 'boolean',
        'verified_at' => 'datetime',
    ];

    public function business(): BelongsTo
    {
        return $this->belongsTo(Business::class);
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($domain) {
            if (!$domain->verification_token) {
                $domain->verification_token = Str::random(32);
            }
        });
    }

    public function verify(): void
    {
        $this->update([
            'is_verified' => true,
            'verified_at' => now(),
        ]);
    }
}
