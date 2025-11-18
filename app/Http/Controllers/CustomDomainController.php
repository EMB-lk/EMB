<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\CustomDomain;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CustomDomainController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'subscription:custom_domain'])->except(['verify']);
    }

    /**
     * Show custom domain management page
     */
    public function index(Business $business)
    {
        $this->authorize('update', $business);

        // Check if business has access to custom domains
        if (!$business->canAccessFeature('custom_domain')) {
            return redirect()->route('subscription.plans', $business)
                ->with('error', 'Custom domains are only available on Professional plans. Please upgrade.');
        }

        $customDomains = $business->customDomains()->get();

        return view('custom-domain.index', compact('business', 'customDomains'));
    }

    /**
     * Store a new custom domain
     */
    public function store(Request $request, Business $business)
    {
        $this->authorize('update', $business);

        // Check if business has access to custom domains
        if (!$business->canAccessFeature('custom_domain')) {
            return redirect()->route('subscription.plans', $business)
                ->with('error', 'Custom domains are only available on Professional plans. Please upgrade.');
        }

        $request->validate([
            'domain' => 'required|string|max:255|regex:/^([a-z0-9]+(-[a-z0-9]+)*\.)+[a-z]{2,}$/i|unique:custom_domains,domain',
        ]);

        $domain = strtolower($request->input('domain'));

        // Generate verification token
        $verificationToken = Str::random(32);

        CustomDomain::create([
            'business_id' => $business->id,
            'domain' => $domain,
            'is_verified' => false,
            'verification_token' => $verificationToken,
        ]);

        return redirect()->route('custom-domain.index', $business)
            ->with('success', "Custom domain '{$domain}' added successfully! Please verify it by adding the DNS records.");
    }

    /**
     * Show domain verification instructions
     */
    public function show(Business $business, CustomDomain $customDomain)
    {
        $this->authorize('update', $business);

        if ($customDomain->business_id !== $business->id) {
            abort(403);
        }

        return view('custom-domain.show', compact('business', 'customDomain'));
    }

    /**
     * Verify a custom domain
     */
    public function verifyDomain(Request $request, Business $business, CustomDomain $customDomain)
    {
        $this->authorize('update', $business);

        if ($customDomain->business_id !== $business->id) {
            abort(403);
        }

        if ($customDomain->is_verified) {
            return redirect()->route('custom-domain.index', $business)
                ->with('info', 'Domain is already verified.');
        }

        // In a real implementation, you would:
        // 1. Check DNS records for the domain
        // 2. Verify that a TXT record exists with the verification token
        // 3. Verify that a CNAME record points to your main domain

        // For demonstration, we'll simulate verification
        $verified = $this->checkDnsRecords($customDomain);

        if ($verified) {
            $customDomain->verify();

            return redirect()->route('custom-domain.index', $business)
                ->with('success', "Domain '{$customDomain->domain}' has been verified successfully!");
        }

        return redirect()->back()
            ->with('error', 'Domain verification failed. Please ensure DNS records are correctly configured and allow up to 48 hours for propagation.');
    }

    /**
     * Delete a custom domain
     */
    public function destroy(Business $business, CustomDomain $customDomain)
    {
        $this->authorize('update', $business);

        if ($customDomain->business_id !== $business->id) {
            abort(403);
        }

        $domain = $customDomain->domain;
        $customDomain->delete();

        return redirect()->route('custom-domain.index', $business)
            ->with('success', "Custom domain '{$domain}' has been removed.");
    }

    /**
     * Check DNS records (simulated)
     * In production, this would use DNS lookup functions
     */
    private function checkDnsRecords(CustomDomain $customDomain): bool
    {
        // Simulate DNS check
        // In production, you would use dns_get_record() or similar

        // For demonstration purposes, we'll randomly succeed or fail
        // In real implementation:
        // 1. Check for TXT record: emb-verification={verification_token}
        // 2. Check for CNAME record pointing to emb.lk

        return rand(0, 1) === 1;
    }

    /**
     * Public route to verify domain via token (for webhooks/callbacks)
     */
    public function verify(Request $request, string $token)
    {
        $customDomain = CustomDomain::where('verification_token', $token)->first();

        if (!$customDomain) {
            return response()->json(['error' => 'Invalid verification token'], 404);
        }

        if ($customDomain->is_verified) {
            return response()->json(['message' => 'Domain already verified']);
        }

        $customDomain->verify();

        return response()->json(['message' => 'Domain verified successfully']);
    }
}
