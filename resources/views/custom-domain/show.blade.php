<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('DNS Setup') }} - {{ $customDomain->domain }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('Setup Instructions') }}</h3>

                    <p class="text-gray-600 mb-6">
                        To verify your custom domain, you need to add the following DNS records to your domain's DNS settings.
                        These records tell the internet that you own this domain and want to use it with EMB.LK.
                    </p>

                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                        <h4 class="font-semibold text-blue-900 mb-2">{{ __('Step 1: Add TXT Record for Verification') }}</h4>
                        <p class="text-sm text-blue-800 mb-3">
                            Add this TXT record to verify domain ownership:
                        </p>

                        <div class="bg-white border border-blue-300 rounded p-3 font-mono text-sm">
                            <div class="grid grid-cols-3 gap-2 mb-2">
                                <div class="font-semibold">Type:</div>
                                <div class="col-span-2">TXT</div>
                            </div>
                            <div class="grid grid-cols-3 gap-2 mb-2">
                                <div class="font-semibold">Name:</div>
                                <div class="col-span-2">@</div>
                            </div>
                            <div class="grid grid-cols-3 gap-2">
                                <div class="font-semibold">Value:</div>
                                <div class="col-span-2 break-all">emb-verification={{ $customDomain->verification_token }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
                        <h4 class="font-semibold text-green-900 mb-2">{{ __('Step 2: Add CNAME Record') }}</h4>
                        <p class="text-sm text-green-800 mb-3">
                            Add this CNAME record to point your domain to EMB.LK:
                        </p>

                        <div class="bg-white border border-green-300 rounded p-3 font-mono text-sm">
                            <div class="grid grid-cols-3 gap-2 mb-2">
                                <div class="font-semibold">Type:</div>
                                <div class="col-span-2">CNAME</div>
                            </div>
                            <div class="grid grid-cols-3 gap-2 mb-2">
                                <div class="font-semibold">Name:</div>
                                <div class="col-span-2">www (or @)</div>
                            </div>
                            <div class="grid grid-cols-3 gap-2">
                                <div class="font-semibold">Value:</div>
                                <div class="col-span-2">{{ $business->subdomain }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
                        <h4 class="font-semibold text-yellow-900 mb-2">{{ __('Important Notes') }}</h4>
                        <ul class="text-sm text-yellow-800 space-y-1 list-disc list-inside">
                            <li>DNS changes can take up to 48 hours to propagate</li>
                            <li>You need to configure these records with your domain registrar (e.g., GoDaddy, Namecheap, etc.)</li>
                            <li>Make sure to remove any existing A or CNAME records that conflict</li>
                            <li>After adding DNS records, return to this page and click "Verify Domain"</li>
                        </ul>
                    </div>

                    <div class="flex space-x-3">
                        <form action="{{ route('custom-domain.verify', ['business' => $business, 'customDomain' => $customDomain]) }}" method="POST">
                            @csrf
                            <button type="submit"
                                    class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-150">
                                Verify Domain Now
                            </button>
                        </form>

                        <a href="{{ route('custom-domain.index', $business) }}"
                           class="bg-gray-300 hover:bg-gray-400 text-gray-700 font-bold py-2 px-4 rounded transition duration-150">
                            Back to Domains
                        </a>
                    </div>
                </div>
            </div>

            <!-- How to find DNS settings -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('Where to Find DNS Settings') }}</h3>

                    <div class="space-y-3 text-sm text-gray-700">
                        <div>
                            <p class="font-semibold">GoDaddy:</p>
                            <p>My Products → Domain → DNS → Manage DNS</p>
                        </div>
                        <div>
                            <p class="font-semibold">Namecheap:</p>
                            <p>Domain List → Manage → Advanced DNS</p>
                        </div>
                        <div>
                            <p class="font-semibold">Cloudflare:</p>
                            <p>Select your domain → DNS → Records</p>
                        </div>
                        <div>
                            <p class="font-semibold">Google Domains:</p>
                            <p>My domains → Select domain → DNS</p>
                        </div>
                    </div>

                    <p class="mt-4 text-sm text-gray-600">
                        If you need help, please contact our support team at support@emb.lk
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
