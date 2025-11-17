<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                My Businesses
            </h2>
            <a href="{{ route('business.create') }}"
               class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                Create New Business
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if($businesses->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($businesses as $business)
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                            <div class="mb-4">
                                <span class="text-sm text-blue-600">{{ $business->category->name }}</span>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $business->name }}</h3>
                            <p class="text-gray-600 mb-4">{{ Str::limit($business->description, 100) }}</p>

                            <div class="mb-4">
                                <p class="text-sm text-gray-500">{{ $business->subdomain }}</p>
                                @if($business->currentSubscription)
                                    <span class="inline-block mt-2 px-2 py-1 bg-blue-100 text-blue-800 rounded text-xs">
                                        {{ $business->currentSubscription->plan->name }}
                                    </span>
                                @endif
                            </div>

                            <div class="flex gap-2">
                                <a href="{{ route('business.show', $business->slug) }}"
                                   class="text-blue-600 hover:underline text-sm">
                                    View
                                </a>
                                <a href="{{ route('business.edit', $business) }}"
                                   class="text-blue-600 hover:underline text-sm">
                                    Edit
                                </a>
                                <form action="{{ route('business.destroy', $business) }}" method="POST"
                                      onsubmit="return confirm('Are you sure you want to delete this business?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline text-sm">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8 text-center">
                    <p class="text-gray-600 mb-4">You haven't created any business profiles yet.</p>
                    <a href="{{ route('business.create') }}"
                       class="inline-block px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        Create Your First Business
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
