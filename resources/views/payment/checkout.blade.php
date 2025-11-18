<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Checkout') }} - {{ $business->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            @if (session('error'))
                <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                    {{ session('error') }}
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Order Summary -->
                <div class="md:col-span-1">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('Order Summary') }}</h3>

                            <div class="mb-4">
                                <p class="text-sm text-gray-600">Plan</p>
                                <p class="font-semibold">{{ $plan->name }}</p>
                            </div>

                            <div class="mb-4">
                                <p class="text-sm text-gray-600">Billing</p>
                                <p class="font-semibold">{{ ucfirst($plan->billing_period) }}</p>
                            </div>

                            <div class="border-t border-gray-200 pt-4">
                                <div class="flex justify-between items-center">
                                    <span class="text-lg font-semibold">Total</span>
                                    <span class="text-2xl font-bold text-gray-900">
                                        LKR {{ number_format($plan->price, 2) }}
                                    </span>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">
                                    Billed {{ $plan->billing_period === 'monthly' ? 'monthly' : 'annually' }}
                                </p>
                            </div>

                            <div class="mt-6 bg-blue-50 border border-blue-200 rounded p-3">
                                <p class="text-xs text-blue-900">
                                    Your subscription will activate immediately after payment confirmation.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment Form -->
                <div class="md:col-span-2">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('Payment Method') }}</h3>

                            <form action="{{ route('payment.process', ['business' => $business, 'plan' => $plan]) }}" method="POST" id="payment-form">
                                @csrf

                                <div class="mb-6">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Select Payment Method
                                    </label>

                                    <div class="space-y-3">
                                        <label class="flex items-center p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-blue-500 transition">
                                            <input type="radio" name="payment_method" value="stripe" class="mr-3" required>
                                            <div class="flex-1">
                                                <div class="font-semibold">Credit/Debit Card</div>
                                                <div class="text-sm text-gray-600">Pay securely with Stripe</div>
                                            </div>
                                            <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                            </svg>
                                        </label>

                                        <label class="flex items-center p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-blue-500 transition">
                                            <input type="radio" name="payment_method" value="paypal" class="mr-3">
                                            <div class="flex-1">
                                                <div class="font-semibold">PayPal</div>
                                                <div class="text-sm text-gray-600">Pay with your PayPal account</div>
                                            </div>
                                            <svg class="h-6 w-6 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M20.067 8.478c.492.88.556 2.014.3 3.327-.74 3.806-3.276 5.12-6.514 5.12h-.5a.805.805 0 00-.794.68l-.04.22-.63 3.993-.032.17a.804.804 0 01-.794.679H7.72a.483.483 0 01-.477-.558L7.418 21h1.518l.95-6.02h1.385c4.678 0 7.75-2.203 8.796-6.502z"></path>
                                            </svg>
                                        </label>

                                        <label class="flex items-center p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-blue-500 transition">
                                            <input type="radio" name="payment_method" value="bank_transfer" class="mr-3">
                                            <div class="flex-1">
                                                <div class="font-semibold">Bank Transfer</div>
                                                <div class="text-sm text-gray-600">Direct bank transfer (manual verification required)</div>
                                            </div>
                                            <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path>
                                            </svg>
                                        </label>
                                    </div>
                                </div>

                                <div class="mb-6">
                                    <label class="flex items-start">
                                        <input type="checkbox" name="auto_renew" value="1" checked class="mt-1 mr-2">
                                        <span class="text-sm text-gray-700">
                                            I agree to automatically renew my subscription at the end of each billing period
                                        </span>
                                    </label>
                                </div>

                                <div class="mb-6">
                                    <label class="flex items-start">
                                        <input type="checkbox" required class="mt-1 mr-2">
                                        <span class="text-sm text-gray-700">
                                            I agree to the <a href="#" class="text-blue-600 hover:underline">Terms of Service</a>
                                            and <a href="#" class="text-blue-600 hover:underline">Privacy Policy</a>
                                        </span>
                                    </label>
                                </div>

                                <div class="flex space-x-3">
                                    <button type="submit"
                                            class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded transition duration-150">
                                        Complete Payment
                                    </button>
                                    <a href="{{ route('subscription.plans', $business) }}"
                                       class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-700 text-center font-bold py-3 px-4 rounded transition duration-150">
                                        Cancel
                                    </a>
                                </div>
                            </form>

                            <div class="mt-6 flex items-center justify-center text-sm text-gray-500">
                                <svg class="h-5 w-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                                Secure payment processing
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
