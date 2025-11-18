<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Subscription Plans') }} - {{ $business->name }}
            </h2>
            <a href="{{ route('subscription.manage', $business) }}" class="text-sm text-gray-600 hover:text-gray-900">
                Manage Subscription
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
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

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($plans as $plan)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg {{ $currentPlan && $currentPlan->id === $plan->id ? 'border-4 border-blue-500' : '' }}">
                        <div class="p-6">
                            @if($currentPlan && $currentPlan->id === $plan->id)
                                <div class="mb-4">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                        Current Plan
                                    </span>
                                </div>
                            @endif

                            <h3 class="text-2xl font-bold text-gray-900 mb-2">{{ $plan->name }}</h3>

                            <div class="mb-4">
                                <span class="text-4xl font-extrabold text-gray-900">
                                    @if($plan->is_free)
                                        Free
                                    @else
                                        LKR {{ number_format($plan->price, 2) }}
                                    @endif
                                </span>
                                @if(!$plan->is_free)
                                    <span class="text-gray-600">/{{ $plan->billing_period }}</span>
                                @endif
                            </div>

                            <p class="text-gray-600 mb-6">{{ $plan->description }}</p>

                            <ul class="space-y-3 mb-6">
                                <li class="flex items-start">
                                    <svg class="h-6 w-6 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span class="text-gray-700">Up to {{ $plan->max_photos }} photos</span>
                                </li>

                                @if($plan->custom_domain)
                                    <li class="flex items-start">
                                        <svg class="h-6 w-6 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span class="text-gray-700">Custom domain</span>
                                    </li>
                                @else
                                    <li class="flex items-start">
                                        <svg class="h-6 w-6 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                        <span class="text-gray-400">No custom domain</span>
                                    </li>
                                @endif

                                @if($plan->analytics)
                                    <li class="flex items-start">
                                        <svg class="h-6 w-6 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span class="text-gray-700">Analytics dashboard</span>
                                    </li>
                                @else
                                    <li class="flex items-start">
                                        <svg class="h-6 w-6 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                        <span class="text-gray-400">No analytics</span>
                                    </li>
                                @endif

                                @if($plan->priority_support)
                                    <li class="flex items-start">
                                        <svg class="h-6 w-6 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span class="text-gray-700">Priority support</span>
                                    </li>
                                @else
                                    <li class="flex items-start">
                                        <svg class="h-6 w-6 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                        <span class="text-gray-400">Standard support</span>
                                    </li>
                                @endif
                            </ul>

                            @if($currentPlan && $currentPlan->id === $plan->id)
                                <button disabled class="w-full bg-gray-300 text-gray-600 font-bold py-2 px-4 rounded cursor-not-allowed">
                                    Current Plan
                                </button>
                            @else
                                <a href="{{ route('subscription.showUpgrade', ['business' => $business, 'plan' => $plan]) }}"
                                   class="block w-full bg-blue-600 hover:bg-blue-700 text-white text-center font-bold py-2 px-4 rounded transition duration-150">
                                    @if($plan->is_free)
                                        Downgrade to Free
                                    @elseif($currentPlan && $plan->price < $currentPlan->price)
                                        Downgrade
                                    @else
                                        Upgrade Now
                                    @endif
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-8 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">{{ __('Need help choosing?') }}</h3>
                    <p class="text-gray-600 mb-4">
                        All plans include a basic business listing. Upgrade to Professional for advanced features like custom domains, analytics, and priority support.
                    </p>
                    <p class="text-gray-600">
                        Questions? Contact our support team at support@emb.lk
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
