<x-guest-layout>
    <div class="min-h-screen bg-gray-50">
        <!-- Hero Section -->
        <div class="bg-blue-600 text-white py-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h1 class="text-4xl font-bold mb-4">Embilipitiya Business Directory</h1>
                    <p class="text-xl mb-8">Discover local businesses in Embilipitiya</p>

                    <!-- Search Form -->
                    <form action="{{ route('search') }}" method="GET" class="max-w-3xl mx-auto">
                        <div class="flex gap-2">
                            <input
                                type="text"
                                name="q"
                                placeholder="Search businesses..."
                                class="flex-1 px-4 py-3 rounded-lg text-gray-900"
                            >
                            <button type="submit" class="px-8 py-3 bg-white text-blue-600 rounded-lg font-semibold hover:bg-gray-100">
                                Search
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Categories Section -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <h2 class="text-3xl font-bold mb-8">Browse by Category</h2>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                @foreach($categories as $category)
                    <a href="{{ route('search', ['category' => $category->id]) }}"
                       class="p-6 bg-white rounded-lg shadow hover:shadow-lg transition text-center">
                        <h3 class="font-semibold text-gray-900">{{ $category->name }}</h3>
                        <p class="text-sm text-gray-500 mt-2">{{ $category->businesses_count }} businesses</p>
                    </a>
                @endforeach
            </div>
        </div>

        <!-- Featured Businesses -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <h2 class="text-3xl font-bold mb-8">Featured Businesses</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($featuredBusinesses as $business)
                    <a href="{{ route('business.show', $business->slug) }}"
                       class="bg-white rounded-lg shadow hover:shadow-lg transition p-6">
                        <div class="mb-4">
                            <span class="text-sm text-blue-600">{{ $business->category->name }}</span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $business->name }}</h3>
                        <p class="text-gray-600 mb-4">{{ Str::limit($business->description, 100) }}</p>
                        <div class="text-sm text-gray-500">
                            @if($business->address)
                                <p>{{ $business->address }}</p>
                            @endif
                            @if($business->phone)
                                <p>{{ $business->phone }}</p>
                            @endif
                        </div>
                        <div class="mt-4 text-sm text-gray-400">
                            {{ $business->view_count }} views
                        </div>
                    </a>
                @endforeach
            </div>
        </div>

        <!-- CTA Section -->
        <div class="bg-gray-100 py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h2 class="text-3xl font-bold mb-4">List Your Business</h2>
                <p class="text-xl text-gray-600 mb-8">Get your free business profile with automatic subdomain</p>
                <a href="{{ route('register') }}" class="inline-block px-8 py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700">
                    Get Started Free
                </a>
            </div>
        </div>
    </div>
</x-guest-layout>
