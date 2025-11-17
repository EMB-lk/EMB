<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Create Business Profile
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('business.store') }}" method="POST">
                    @csrf

                    <div class="space-y-6">
                        <!-- Name -->
                        <div>
                            <label for="name" class="block font-medium text-sm text-gray-700">Business Name *</label>
                            <input id="name" type="text" name="name" value="{{ old('name') }}" required
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Category -->
                        <div>
                            <label for="category_id" class="block font-medium text-sm text-gray-700">Category *</label>
                            <select id="category_id" name="category_id" required
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                <option value="">Select a category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="description" class="block font-medium text-sm text-gray-700">Description</label>
                            <textarea id="description" name="description" rows="4"
                                      class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Address -->
                        <div>
                            <label for="address" class="block font-medium text-sm text-gray-700">Address</label>
                            <input id="address" type="text" name="address" value="{{ old('address') }}"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            @error('address')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Phone -->
                        <div>
                            <label for="phone" class="block font-medium text-sm text-gray-700">Phone</label>
                            <input id="phone" type="text" name="phone" value="{{ old('phone') }}"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            @error('phone')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block font-medium text-sm text-gray-700">Email</label>
                            <input id="email" type="email" name="email" value="{{ old('email') }}"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Website -->
                        <div>
                            <label for="website" class="block font-medium text-sm text-gray-700">Website</label>
                            <input id="website" type="url" name="website" value="{{ old('website') }}"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            @error('website')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Opening Hours -->
                        <div>
                            <label for="opening_hours" class="block font-medium text-sm text-gray-700">Opening Hours</label>
                            <textarea id="opening_hours" name="opening_hours" rows="3"
                                      class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('opening_hours') }}</textarea>
                            @error('opening_hours')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end gap-4">
                        <a href="{{ route('dashboard') }}"
                           class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">
                            Cancel
                        </a>
                        <button type="submit"
                                class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                            Create Business Profile
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
