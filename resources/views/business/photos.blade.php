<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Manage Photos') }} - {{ $business->name }}
            </h2>
            <a href="{{ route('business.edit', $business) }}" class="text-sm text-blue-600 hover:text-blue-900">
                Edit Business
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

            <!-- Upload Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">{{ __('Upload Photos') }}</h3>
                            <p class="text-sm text-gray-600 mt-1">
                                You have used {{ count($currentPhotos) }} of {{ $maxPhotos }} available photo slots.
                                @if($remainingSlots > 0)
                                    <span class="text-green-600 font-semibold">{{ $remainingSlots }} remaining.</span>
                                @else
                                    <span class="text-red-600 font-semibold">No slots remaining.</span>
                                @endif
                            </p>
                        </div>
                        @if($business->isOnFreePlan())
                            <a href="{{ route('subscription.plans', $business) }}"
                               class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold py-2 px-4 rounded transition duration-150">
                                Upgrade for More Photos
                            </a>
                        @endif
                    </div>

                    @if($remainingSlots > 0)
                        <form action="{{ route('business.photos.upload', $business) }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Select Photos (max {{ $remainingSlots }})
                                </label>
                                <input type="file"
                                       name="photos[]"
                                       multiple
                                       accept="image/jpeg,image/png,image/jpg,image/webp"
                                       class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none"
                                       required>
                                <p class="text-xs text-gray-500 mt-1">
                                    Accepted formats: JPG, PNG, WEBP. Max size: 5MB per image.
                                </p>
                            </div>

                            <button type="submit"
                                    class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-150">
                                Upload Photos
                            </button>
                        </form>
                    @else
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                            <p class="text-yellow-800">
                                You have reached your photo limit.
                                @if($business->isOnFreePlan())
                                    <a href="{{ route('subscription.plans', $business) }}" class="underline font-semibold">Upgrade your plan</a>
                                    to upload more photos.
                                @endif
                            </p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Current Photos -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('Current Photos') }}</h3>

                    @if(count($currentPhotos) > 0)
                        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                            @foreach($currentPhotos as $photo)
                                <div class="relative group">
                                    <img src="{{ Storage::url($photo) }}"
                                         alt="Business photo"
                                         class="w-full h-48 object-cover rounded-lg">

                                    @if($business->logo === $photo)
                                        <div class="absolute top-2 left-2">
                                            <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-blue-600 text-white">
                                                Logo
                                            </span>
                                        </div>
                                    @endif

                                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-50 transition-opacity rounded-lg flex items-center justify-center opacity-0 group-hover:opacity-100">
                                        <div class="flex space-x-2">
                                            @if($business->logo !== $photo)
                                                <form action="{{ route('business.photos.setLogo', $business) }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="photo_path" value="{{ $photo }}">
                                                    <button type="submit"
                                                            class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold py-1 px-3 rounded"
                                                            title="Set as logo">
                                                        Set Logo
                                                    </button>
                                                </form>
                                            @endif

                                            <form action="{{ route('business.photos.destroy', $business) }}" method="POST"
                                                  onsubmit="return confirm('Are you sure you want to delete this photo?');">
                                                @csrf
                                                @method('DELETE')
                                                <input type="hidden" name="photo_path" value="{{ $photo }}">
                                                <button type="submit"
                                                        class="bg-red-600 hover:bg-red-700 text-white text-xs font-bold py-1 px-3 rounded"
                                                        title="Delete photo">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <p class="mt-2 text-sm text-gray-600">No photos uploaded yet.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
