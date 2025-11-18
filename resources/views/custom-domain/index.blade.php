<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Custom Domains') }} - {{ $business->name }}
            </h2>
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                Premium Feature
            </span>
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

            <!-- Add Domain Form -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('Add Custom Domain') }}</h3>

                    <form action="{{ route('custom-domain.store', $business) }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label for="domain" class="block text-sm font-medium text-gray-700 mb-2">
                                Domain Name
                            </label>
                            <input type="text"
                                   id="domain"
                                   name="domain"
                                   placeholder="yourdomain.com"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   required>
                            @error('domain')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">
                                Enter your domain without http:// or www (e.g., yourbusiness.com)
                            </p>
                        </div>

                        <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-150">
                            Add Domain
                        </button>
                    </form>
                </div>
            </div>

            <!-- Current Domains -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('Your Custom Domains') }}</h3>

                    @if($customDomains->count() > 0)
                        <div class="space-y-4">
                            @foreach($customDomains as $domain)
                                <div class="border border-gray-200 rounded-lg p-4">
                                    <div class="flex justify-between items-start">
                                        <div class="flex-1">
                                            <div class="flex items-center">
                                                <h4 class="text-lg font-semibold text-gray-900">{{ $domain->domain }}</h4>
                                                @if($domain->is_verified)
                                                    <span class="ml-3 inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-green-100 text-green-800">
                                                        <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                        </svg>
                                                        Verified
                                                    </span>
                                                @else
                                                    <span class="ml-3 inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-yellow-100 text-yellow-800">
                                                        Pending Verification
                                                    </span>
                                                @endif
                                            </div>

                                            @if($domain->is_verified)
                                                <p class="text-sm text-gray-600 mt-1">
                                                    Verified on {{ $domain->verified_at->format('M d, Y') }}
                                                </p>
                                            @else
                                                <p class="text-sm text-gray-600 mt-1">
                                                    Added on {{ $domain->created_at->format('M d, Y') }}
                                                </p>
                                            @endif
                                        </div>

                                        <div class="flex space-x-2 ml-4">
                                            @if(!$domain->is_verified)
                                                <a href="{{ route('custom-domain.show', ['business' => $business, 'customDomain' => $domain]) }}"
                                                   class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold py-1 px-3 rounded">
                                                    Setup DNS
                                                </a>

                                                <form action="{{ route('custom-domain.verify', ['business' => $business, 'customDomain' => $domain]) }}" method="POST">
                                                    @csrf
                                                    <button type="submit"
                                                            class="bg-green-600 hover:bg-green-700 text-white text-sm font-bold py-1 px-3 rounded">
                                                        Verify
                                                    </button>
                                                </form>
                                            @endif

                                            <form action="{{ route('custom-domain.destroy', ['business' => $business, 'customDomain' => $domain]) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('Are you sure you want to remove this domain?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="bg-red-600 hover:bg-red-700 text-white text-sm font-bold py-1 px-3 rounded">
                                                    Remove
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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
                            </svg>
                            <p class="mt-2 text-sm text-gray-600">No custom domains added yet.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
