<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\Plan;
use App\Services\SubscriptionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    protected SubscriptionService $subscriptionService;

    public function __construct(SubscriptionService $subscriptionService)
    {
        $this->middleware('auth')->except(['webhook']);
        $this->subscriptionService = $subscriptionService;
    }

    /**
     * Show checkout page
     */
    public function checkout(Business $business, Plan $plan)
    {
        $this->authorize('update', $business);

        if ($plan->is_free) {
            return redirect()->route('subscription.upgrade', ['business' => $business, 'plan' => $plan]);
        }

        return view('payment.checkout', compact('business', 'plan'));
    }

    /**
     * Process payment
     */
    public function process(Request $request, Business $business, Plan $plan)
    {
        $this->authorize('update', $business);

        $request->validate([
            'payment_method' => 'required|in:stripe,paypal,bank_transfer',
            'auto_renew' => 'boolean',
        ]);

        try {
            // In a real implementation, you would integrate with a payment gateway here
            // For now, we'll simulate a successful payment

            $paymentMethod = $request->input('payment_method');

            // Simulate payment processing
            if ($paymentMethod === 'stripe') {
                // Stripe integration would go here
                $paymentSuccessful = true;
            } elseif ($paymentMethod === 'paypal') {
                // PayPal integration would go here
                $paymentSuccessful = true;
            } elseif ($paymentMethod === 'bank_transfer') {
                // Mark as pending and require manual verification
                $paymentSuccessful = false;

                return redirect()->route('payment.pending', ['business' => $business])
                    ->with('info', 'Bank transfer details have been sent to your email. Your subscription will be activated once payment is verified.');
            }

            if ($paymentSuccessful) {
                // Create subscription
                $subscription = $this->subscriptionService->createSubscription(
                    $business,
                    $plan,
                    $request->input('auto_renew', true)
                );

                // Log payment (in real implementation, save to payments table)
                Log::info('Payment processed', [
                    'business_id' => $business->id,
                    'plan_id' => $plan->id,
                    'amount' => $plan->price,
                    'payment_method' => $paymentMethod,
                ]);

                return redirect()->route('payment.success', ['business' => $business])
                    ->with('success', 'Payment successful! Your subscription has been activated.');
            }

            return redirect()->back()
                ->with('error', 'Payment failed. Please try again.');

        } catch (\Exception $e) {
            Log::error('Payment processing error', [
                'business_id' => $business->id,
                'plan_id' => $plan->id,
                'error' => $e->getMessage(),
            ]);

            return redirect()->back()
                ->with('error', 'Payment processing failed: ' . $e->getMessage());
        }
    }

    /**
     * Show payment success page
     */
    public function success(Business $business)
    {
        $this->authorize('update', $business);

        return view('payment.success', compact('business'));
    }

    /**
     * Show payment pending page
     */
    public function pending(Business $business)
    {
        $this->authorize('update', $business);

        return view('payment.pending', compact('business'));
    }

    /**
     * Handle payment gateway webhooks
     */
    public function webhook(Request $request)
    {
        // Verify webhook signature
        // Process webhook payload

        try {
            $payload = $request->all();

            // Example: Stripe webhook handling
            if ($request->header('Stripe-Signature')) {
                // Verify Stripe signature
                // Process Stripe events (payment_intent.succeeded, subscription.updated, etc.)

                Log::info('Stripe webhook received', $payload);
            }

            // Example: PayPal webhook handling
            if ($request->has('event_type')) {
                // Verify PayPal webhook
                // Process PayPal events

                Log::info('PayPal webhook received', $payload);
            }

            return response()->json(['status' => 'success']);

        } catch (\Exception $e) {
            Log::error('Webhook processing error', [
                'error' => $e->getMessage(),
                'payload' => $request->all(),
            ]);

            return response()->json(['status' => 'error'], 400);
        }
    }
}
