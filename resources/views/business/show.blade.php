<x-guest-layout>
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-lg p-8">
                <!-- Business Header -->
                <div class="mb-6">
                    <div class="flex justify-between items-start">
                        <div>
                            <span class="text-sm text-blue-600">{{ $business->category->name }}</span>
                            <h1 class="text-4xl font-bold text-gray-900 mt-2">{{ $business->name }}</h1>
                            <p class="text-gray-600 mt-2">{{ $business->subdomain }}</p>
                        </div>

                        @auth
                            @if(auth()->user()->id === $business->user_id)
                                <a href="{{ route('business.edit', $business) }}"
                                   class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                                    Edit Business
                                </a>
                            @endif
                        @endauth
                    </div>
                </div>

                <!-- Business Details -->
                <div class="space-y-6">
                    @if($business->description)
                        <div>
                            <h2 class="text-xl font-semibold mb-2">About</h2>
                            <p class="text-gray-700">{{ $business->description }}</p>
                        </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @if($business->address)
                            <div>
                                <h3 class="font-semibold text-gray-900">Address</h3>
                                <p class="text-gray-700">{{ $business->address }}, {{ $business->city }}</p>
                            </div>
                        @endif

                        @if($business->phone)
                            <div>
                                <h3 class="font-semibold text-gray-900">Phone</h3>
                                <p class="text-gray-700">{{ $business->phone }}</p>
                            </div>
                        @endif

                        @if($business->email)
                            <div>
                                <h3 class="font-semibold text-gray-900">Email</h3>
                                <p class="text-gray-700">{{ $business->email }}</p>
                            </div>
                        @endif

                        @if($business->website)
                            <div>
                                <h3 class="font-semibold text-gray-900">Website</h3>
                                <a href="{{ $business->website }}" target="_blank"
                                   class="text-blue-600 hover:underline">
                                    {{ $business->website }}
                                </a>
                            </div>
                        @endif
                    </div>

                    @if($business->opening_hours)
                        <div>
                            <h3 class="font-semibold text-gray-900">Opening Hours</h3>
                            <p class="text-gray-700 whitespace-pre-line">{{ $business->opening_hours }}</p>
                        </div>
                    @endif
                </div>

                <!-- Current Plan -->
                @if($business->currentSubscription)
                    <div class="mt-8 pt-8 border-t">
                        <span class="inline-block px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm">
                            {{ $business->currentSubscription->plan->name }}
                        </span>
                    </div>
                @endif

                <!-- View Count -->
                <div class="mt-8 pt-8 border-t text-sm text-gray-500">
                    {{ number_format($business->view_count) }} views
                </div>
            </div>

            <!-- Back Button -->
            <div class="mt-6">
                <a href="{{ route('home') }}" class="text-blue-600 hover:underline">
                    &larr; Back to Directory
                </a>
            </div>
        </div>
    </div>
</x-guest-layout>
