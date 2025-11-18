<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Payment Pending') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-center">
                    <!-- Pending Icon -->
                    <div class="flex justify-center mb-6">
                        <div class="rounded-full bg-yellow-100 p-6">
                            <svg class="h-16 w-16 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>

                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Payment Pending Verification</h3>

                    <p class="text-gray-600 mb-6">
                        Your payment is pending verification. We'll activate your subscription once we confirm your payment.
                    </p>

                    @if(session('info'))
                        <div class="mb-6 p-4 bg-blue-100 border border-blue-400 text-blue-700 rounded">
                            {{ session('info') }}
                        </div>
                    @endif

                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 mb-6 text-left">
                        <h4 class="font-semibold text-gray-900 mb-4">Bank Transfer Instructions</h4>

                        <div class="space-y-3 text-sm">
                            <div>
                                <p class="text-gray-600">Bank Name</p>
                                <p class="font-semibold">Commercial Bank of Ceylon</p>
                            </div>
                            <div>
                                <p class="text-gray-600">Account Name</p>
                                <p class="font-semibold">EMB.LK (Pvt) Ltd</p>
                            </div>
                            <div>
                                <p class="text-gray-600">Account Number</p>
                                <p class="font-semibold">1234567890</p>
                            </div>
                            <div>
                                <p class="text-gray-600">Branch</p>
                                <p class="font-semibold">Embilipitiya Branch</p>
                            </div>
                            <div class="pt-3 border-t border-yellow-300">
                                <p class="text-gray-600">Reference Number</p>
                                <p class="font-semibold text-lg">{{ $business->id }}-{{ now()->format('Ymd') }}</p>
                                <p class="text-xs text-gray-500 mt-1">Please include this reference in your transfer</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                        <h4 class="font-semibold text-gray-900 mb-2">Next Steps</h4>
                        <ol class="text-sm text-gray-700 space-y-2 text-left list-decimal list-inside">
                            <li>Complete the bank transfer using the details above</li>
                            <li>Include the reference number in your transfer</li>
                            <li>Email the transfer receipt to payments@emb.lk</li>
                            <li>We'll verify and activate your subscription within 24 hours</li>
                        </ol>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-3 justify-center">
                        <a href="{{ route('subscription.manage', $business) }}"
                           class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded transition duration-150">
                            View Subscription
                        </a>
                        <a href="{{ route('dashboard') }}"
                           class="bg-gray-300 hover:bg-gray-400 text-gray-700 font-bold py-3 px-6 rounded transition duration-150">
                            Go to Dashboard
                        </a>
                    </div>
                </div>
            </div>

            <!-- Help Section -->
            <div class="mt-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h4 class="font-semibold text-gray-900 mb-4">{{ __('Need Help?') }}</h4>

                    <p class="text-sm text-gray-600 mb-3">
                        If you have any questions about your payment or need assistance, please contact us:
                    </p>

                    <div class="space-y-2 text-sm">
                        <div class="flex items-center">
                            <svg class="h-5 w-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            <span class="text-gray-700">payments@emb.lk</span>
                        </div>
                        <div class="flex items-center">
                            <svg class="h-5 w-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                            <span class="text-gray-700">+94 47 222 3333</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
