<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Upgrade Subscription') }} - {{ $business->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('Plan Comparison') }}</h3>

                    <div class="grid grid-cols-2 gap-6">
                        <!-- Current Plan -->
                        @if($currentPlan)
                            <div class="border border-gray-300 rounded-lg p-4">
                                <div class="text-sm text-gray-600 mb-2">Current Plan</div>
                                <h4 class="text-xl font-bold text-gray-900 mb-2">{{ $currentPlan->name }}</h4>
                                <p class="text-2xl font-bold text-gray-900 mb-4">
                                    @if($currentPlan->is_free)
                                        Free
                                    @else
                                        LKR {{ number_format($currentPlan->price, 2) }}
                                        <span class="text-sm text-gray-600">/{{ $currentPlan->billing_period }}</span>
                                    @endif
                                </p>

                                <ul class="space-y-2 text-sm">
                                    <li class="flex items-center">
                                        <svg class="h-5 w-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        {{ $currentPlan->max_photos }} photos
                                    </li>
                                    <li class="flex items-center">
                                        @if($currentPlan->custom_domain)
                                            <svg class="h-5 w-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        @else
                                            <svg class="h-5 w-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        @endif
                                        Custom domain
                                    </li>
                                    <li class="flex items-center">
                                        @if($currentPlan->analytics)
                                            <svg class="h-5 w-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        @else
                                            <svg class="h-5 w-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        @endif
                                        Analytics
                                    </li>
                                    <li class="flex items-center">
                                        @if($currentPlan->priority_support)
                                            <svg class="h-5 w-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        @else
                                            <svg class="h-5 w-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        @endif
                                        Priority support
                                    </li>
                                </ul>
                            </div>
                        @endif

                        <!-- New Plan -->
                        <div class="border-4 border-blue-500 rounded-lg p-4 bg-blue-50">
                            <div class="text-sm text-blue-600 font-semibold mb-2">New Plan</div>
                            <h4 class="text-xl font-bold text-gray-900 mb-2">{{ $plan->name }}</h4>
                            <p class="text-2xl font-bold text-gray-900 mb-4">
                                @if($plan->is_free)
                                    Free
                                @else
                                    LKR {{ number_format($plan->price, 2) }}
                                    <span class="text-sm text-gray-600">/{{ $plan->billing_period }}</span>
                                @endif
                            </p>

                            <ul class="space-y-2 text-sm">
                                <li class="flex items-center">
                                    <svg class="h-5 w-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    {{ $plan->max_photos }} photos
                                </li>
                                <li class="flex items-center">
                                    @if($plan->custom_domain)
                                        <svg class="h-5 w-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    @else
                                        <svg class="h-5 w-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    @endif
                                    Custom domain
                                </li>
                                <li class="flex items-center">
                                    @if($plan->analytics)
                                        <svg class="h-5 w-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    @else
                                        <svg class="h-5 w-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    @endif
                                    Analytics
                                </li>
                                <li class="flex items-center">
                                    @if($plan->priority_support)
                                        <svg class="h-5 w-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    @else
                                        <svg class="h-5 w-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    @endif
                                    Priority support
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('Confirm Upgrade') }}</h3>

                    <form action="{{ route('subscription.upgrade', ['business' => $business, 'plan' => $plan]) }}" method="POST">
                        @csrf

                        @if(!$plan->is_free)
                            <div class="mb-6">
                                <label class="flex items-start">
                                    <input type="checkbox" name="auto_renew" value="1" checked class="mt-1 mr-2">
                                    <span class="text-sm text-gray-700">
                                        Automatically renew my subscription at the end of each billing period
                                    </span>
                                </label>
                            </div>

                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                                <p class="text-sm text-blue-900">
                                    <strong>Important:</strong> You will be charged LKR {{ number_format($plan->price, 2) }} {{ $plan->billing_period === 'monthly' ? 'per month' : 'per year' }}.
                                    Your subscription will start immediately after payment is confirmed.
                                </p>
                            </div>
                        @endif

                        <div class="flex space-x-3">
                            <button type="submit"
                                    class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded transition duration-150">
                                @if($plan->is_free)
                                    Confirm Downgrade
                                @else
                                    Proceed to Payment
                                @endif
                            </button>
                            <a href="{{ route('subscription.plans', $business) }}"
                               class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-700 text-center font-bold py-3 px-4 rounded transition duration-150">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
