<x-guest-layout>
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-8">
                <h1 class="text-3xl font-bold mb-4">Search Results</h1>

                <!-- Search Form -->
                <form action="{{ route('search') }}" method="GET" class="mb-6">
                    <div class="flex gap-2">
                        <input
                            type="text"
                            name="q"
                            value="{{ $query }}"
                            placeholder="Search businesses..."
                            class="flex-1 px-4 py-2 border rounded-lg"
                        >
                        <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                            Search
                        </button>
                    </div>
                </form>

                @if($query)
                    <p class="text-gray-600">
                        Showing results for: <strong>{{ $query }}</strong>
                    </p>
                @endif
            </div>

            <!-- Results -->
            @if($businesses->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                    @foreach($businesses as $business)
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
                        </a>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-8">
                    {{ $businesses->links() }}
                </div>
            @else
                <div class="bg-white rounded-lg shadow p-8 text-center">
                    <p class="text-gray-600 text-lg">No businesses found.</p>
                    <a href="{{ route('home') }}" class="text-blue-600 hover:underline mt-4 inline-block">
                        Back to Home
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-guest-layout>
