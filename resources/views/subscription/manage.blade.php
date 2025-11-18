<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Manage Subscription') }} - {{ $business->name }}
            </h2>
            <a href="{{ route('subscription.plans', $business) }}" class="text-sm text-blue-600 hover:text-blue-900">
                View All Plans
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                    {{ session('error') }}
                </div>
            @endif

            @if (session('info'))
                <div class="mb-4 p-4 bg-blue-100 border border-blue-400 text-blue-700 rounded">
                    {{ session('info') }}
                </div>
            @endif

            <!-- Current Plan -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('Current Plan') }}</h3>

                    @if($plan)
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h4 class="text-2xl font-bold text-gray-900">{{ $plan->name }}</h4>
                                <p class="text-gray-600 mt-1">
                                    @if($plan->is_free)
                                        Free
                                    @else
                                        LKR {{ number_format($plan->price, 2) }}/{{ $plan->billing_period }}
                                    @endif
                                </p>
                            </div>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $subscription && $subscription->isActive() ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $subscription ? ucfirst($subscription->status) : 'No Subscription' }}
                            </span>
                        </div>

                        @if($subscription)
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-6">
                                <div>
                                    <p class="text-sm text-gray-600">Started</p>
                                    <p class="font-semibold">{{ $subscription->starts_at->format('M d, Y') }}</p>
                                </div>
                                @if($subscription->ends_at)
                                    <div>
                                        <p class="text-sm text-gray-600">
                                            @if($subscription->isActive())
                                                Renews/Expires
                                            @else
                                                Expired
                                            @endif
                                        </p>
                                        <p class="font-semibold">{{ $subscription->ends_at->format('M d, Y') }}</p>
                                    </div>
                                @else
                                    <div>
                                        <p class="text-sm text-gray-600">Duration</p>
                                        <p class="font-semibold">Lifetime</p>
                                    </div>
                                @endif
                            </div>

                            @if(!$plan->is_free && $subscription->ends_at)
                                <div class="mt-6 pt-6 border-t border-gray-200">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="font-semibold">Auto-Renewal</p>
                                            <p class="text-sm text-gray-600">
                                                @if($subscription->auto_renew)
                                                    Your subscription will automatically renew on {{ $subscription->ends_at->format('M d, Y') }}
                                                @else
                                                    Your subscription will not renew automatically
                                                @endif
                                            </p>
                                        </div>
                                        <div>
                                            @if($subscription->auto_renew)
                                                <form action="{{ route('subscription.autoRenew.disable', $business) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                                        Disable
                                                    </button>
                                                </form>
                                            @else
                                                <form action="{{ route('subscription.autoRenew.enable', $business) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                                        Enable
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endif
                    @else
                        <p class="text-gray-600">No active subscription found.</p>
                    @endif
                </div>
            </div>

            <!-- Features -->
            @if($plan)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('Plan Features') }}</h3>

                        <ul class="space-y-3">
                            <li class="flex items-start">
                                <svg class="h-6 w-6 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="text-gray-700">Up to {{ $plan->max_photos }} photos ({{ $business->getRemainingPhotoSlots() }} remaining)</span>
                            </li>

                            <li class="flex items-start">
                                @if($plan->custom_domain)
                                    <svg class="h-6 w-6 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span class="text-gray-700">Custom domain support</span>
                                @else
                                    <svg class="h-6 w-6 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                    <span class="text-gray-400">No custom domain</span>
                                @endif
                            </li>

                            <li class="flex items-start">
                                @if($plan->analytics)
                                    <svg class="h-6 w-6 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span class="text-gray-700">Analytics dashboard</span>
                                @else
                                    <svg class="h-6 w-6 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                    <span class="text-gray-400">No analytics</span>
                                @endif
                            </li>

                            <li class="flex items-start">
                                @if($plan->priority_support)
                                    <svg class="h-6 w-6 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span class="text-gray-700">Priority support</span>
                                @else
                                    <svg class="h-6 w-6 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                    <span class="text-gray-400">Standard support</span>
                                @endif
                            </li>
                        </ul>
                    </div>
                </div>
            @endif

            <!-- Actions -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('Actions') }}</h3>

                    <div class="space-y-3">
                        <a href="{{ route('subscription.plans', $business) }}"
                           class="block w-full bg-blue-600 hover:bg-blue-700 text-white text-center font-bold py-2 px-4 rounded transition duration-150">
                            View All Plans
                        </a>

                        @if($plan && !$plan->is_free)
                            <form action="{{ route('subscription.cancel', $business) }}" method="POST"
                                  onsubmit="return confirm('Are you sure you want to cancel your subscription? You will be moved to the free plan.');">
                                @csrf
                                <button type="submit"
                                        class="block w-full bg-red-600 hover:bg-red-700 text-white text-center font-bold py-2 px-4 rounded transition duration-150">
                                    Cancel Subscription
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
