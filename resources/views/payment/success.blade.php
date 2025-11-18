<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Payment Successful') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-center">
                    <!-- Success Icon -->
                    <div class="flex justify-center mb-6">
                        <div class="rounded-full bg-green-100 p-6">
                            <svg class="h-16 w-16 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                    </div>

                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Payment Successful!</h3>

                    <p class="text-gray-600 mb-6">
                        Your subscription has been activated successfully. You now have access to all premium features.
                    </p>

                    @if(session('success'))
                        <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-6">
                        <h4 class="font-semibold text-gray-900 mb-2">What's Next?</h4>
                        <ul class="text-sm text-gray-700 space-y-2">
                            <li>✓ Access your analytics dashboard</li>
                            <li>✓ Upload more photos to your business listing</li>
                            <li>✓ Set up your custom domain</li>
                            <li>✓ Get priority support from our team</li>
                        </ul>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-3 justify-center">
                        <a href="{{ route('subscription.manage', $business) }}"
                           class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded transition duration-150">
                            Manage Subscription
                        </a>
                        <a href="{{ route('business.edit', $business) }}"
                           class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-3 px-6 rounded transition duration-150">
                            Edit Business
                        </a>
                        <a href="{{ route('dashboard') }}"
                           class="bg-gray-300 hover:bg-gray-400 text-gray-700 font-bold py-3 px-6 rounded transition duration-150">
                            Go to Dashboard
                        </a>
                    </div>
                </div>
            </div>

            <!-- Receipt/Invoice (Optional) -->
            <div class="mt-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h4 class="font-semibold text-gray-900 mb-4">{{ __('Payment Details') }}</h4>

                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <p class="text-gray-600">Business</p>
                            <p class="font-semibold">{{ $business->name }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600">Date</p>
                            <p class="font-semibold">{{ now()->format('M d, Y') }}</p>
                        </div>
                        @if($business->currentSubscription)
                            <div>
                                <p class="text-gray-600">Plan</p>
                                <p class="font-semibold">{{ $business->currentSubscription->plan->name }}</p>
                            </div>
                            <div>
                                <p class="text-gray-600">Amount</p>
                                <p class="font-semibold">LKR {{ number_format($business->currentSubscription->plan->price, 2) }}</p>
                            </div>
                        @endif
                    </div>

                    <p class="text-xs text-gray-500 mt-4">
                        A confirmation email has been sent to {{ auth()->user()->email }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
