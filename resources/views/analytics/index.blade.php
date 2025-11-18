<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Analytics') }} - {{ $business->name }}
            </h2>
            <div class="flex space-x-3">
                <a href="{{ route('business.edit', $business) }}" class="text-sm text-blue-600 hover:text-blue-900">
                    Edit Business
                </a>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                    Premium Feature
                </span>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Overview Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <!-- Total Views -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-8 w-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600">Total Views</p>
                                <p class="text-2xl font-bold text-gray-900">{{ number_format($viewCount) }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Photos -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600">Photos</p>
                                <p class="text-2xl font-bold text-gray-900">{{ $photoCount }} / {{ $maxPhotos }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Subscription Status -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-8 w-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600">Plan</p>
                                <p class="text-2xl font-bold text-gray-900">{{ $business->getCurrentPlan()?->name ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Daily Views Chart -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('Views Over Last 30 Days') }}</h3>

                    <div class="overflow-x-auto">
                        <div class="flex items-end space-x-2 h-64">
                            @foreach($dailyViews as $day)
                                <div class="flex flex-col items-center flex-1 min-w-[20px]">
                                    <div class="w-full bg-blue-600 rounded-t hover:bg-blue-700 transition-colors cursor-pointer"
                                         style="height: {{ $day['views'] > 0 ? ($day['views'] / max(array_column($dailyViews, 'views')) * 200) : 2 }}px"
                                         title="{{ $day['date'] }}: {{ $day['views'] }} views">
                                    </div>
                                    <span class="text-xs text-gray-600 mt-2 transform -rotate-45 origin-top-left whitespace-nowrap">
                                        {{ $day['date'] }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Popular Hours -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('Popular Viewing Hours') }}</h3>

                        <div class="space-y-2">
                            @foreach(array_slice($popularHours, 0, 10) as $hour)
                                <div class="flex items-center">
                                    <span class="text-sm text-gray-600 w-16">{{ $hour['hour'] }}</span>
                                    <div class="flex-1 bg-gray-200 rounded-full h-4 ml-3">
                                        <div class="bg-green-600 h-4 rounded-full"
                                             style="width: {{ $hour['views'] > 0 ? ($hour['views'] / max(array_column($popularHours, 'views')) * 100) : 0 }}%">
                                        </div>
                                    </div>
                                    <span class="text-sm text-gray-900 ml-3 w-12 text-right">{{ $hour['views'] }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('Recent Activity') }}</h3>

                        <div class="space-y-4">
                            @foreach($recentActivity as $activity)
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        @if($activity['type'] === 'subscription')
                                            <div class="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center">
                                                <svg class="h-5 w-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            </div>
                                        @elseif($activity['type'] === 'photos')
                                            <div class="h-8 w-8 rounded-full bg-green-100 flex items-center justify-center">
                                                <svg class="h-5 w-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                            </div>
                                        @else
                                            <div class="h-8 w-8 rounded-full bg-gray-100 flex items-center justify-center">
                                                <svg class="h-5 w-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="ml-3 flex-1">
                                        <p class="text-sm text-gray-900">{{ $activity['message'] }}</p>
                                        <p class="text-xs text-gray-500">{{ $activity['date']->diffForHumans() }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Insights -->
            <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-6">
                <h3 class="text-lg font-semibold text-blue-900 mb-2">{{ __('Insights') }}</h3>
                <ul class="space-y-2 text-sm text-blue-800">
                    <li class="flex items-start">
                        <svg class="h-5 w-5 text-blue-600 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>Your business has been viewed {{ number_format($viewCount) }} times</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="h-5 w-5 text-blue-600 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>You're using {{ $photoCount }} of {{ $maxPhotos }} available photo slots</span>
                    </li>
                    @if($photoCount < $maxPhotos)
                        <li class="flex items-start">
                            <svg class="h-5 w-5 text-blue-600 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>Add more photos to increase engagement</span>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>
