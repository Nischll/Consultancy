<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Payment: {{ $payment->payment_id }}
            </h2>
            <a href="{{ route('consultancy.payments.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg">Back</a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Payment Details</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-500">Student</p>
                                <p class="font-medium text-gray-900 dark:text-white">
                                    <a href="{{ route('consultancy.students.show', $payment->student) }}" class="text-blue-600 hover:underline">
                                        {{ $payment->student->full_name ?? 'N/A' }}
                                    </a>
                                </p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Type</p>
                                <p class="font-medium text-gray-900 dark:text-white">{{ ucfirst(str_replace('_', ' ', $payment->payment_type)) }}</p>
                            </div>
                            <div class="col-span-2">
                                <p class="text-sm text-gray-500">Description</p>
                                <p class="font-medium text-gray-900 dark:text-white">{{ $payment->description }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Payment Method</p>
                                <p class="font-medium text-gray-900 dark:text-white">{{ $payment->payment_method ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Transaction ID</p>
                                <p class="font-medium text-gray-900 dark:text-white">{{ $payment->transaction_id ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Record Payment Form -->
                    @if($payment->status != 'completed' && $payment->due_amount > 0)
                    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Record Payment</h3>
                        <form action="{{ route('consultancy.payments.record', $payment) }}" method="POST" class="space-y-4">
                            @csrf
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Amount *</label>
                                    <input type="number" name="amount" required step="0.01" max="{{ $payment->due_amount }}"
                                        class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                                    <p class="text-xs text-gray-500 mt-1">Max: {{ $payment->currency }} {{ number_format($payment->due_amount, 2) }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Payment Method *</label>
                                    <select name="payment_method" required class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                                        @foreach(['Cash', 'Bank Transfer', 'eSewa', 'Khalti', 'Card', 'Check'] as $method)
                                            <option value="{{ $method }}">{{ $method }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Transaction ID</label>
                                    <input type="text" name="transaction_id"
                                        class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Receipt Number</label>
                                    <input type="text" name="receipt_number"
                                        class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                                </div>
                            </div>
                            <button type="submit" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg">Record Payment</button>
                        </form>
                    </div>
                    @endif
                </div>

                <div class="space-y-6">
                    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                        <span class="px-3 py-1 text-sm rounded-full 
                            @if($payment->status == 'completed') bg-green-100 text-green-800
                            @elseif($payment->status == 'partial') bg-yellow-100 text-yellow-800
                            @else bg-red-100 text-red-800 @endif">
                            {{ ucfirst($payment->status) }}
                        </span>
                        
                        <div class="mt-4 space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-500">Total Amount</span>
                                <span class="font-bold text-gray-900 dark:text-white">{{ $payment->currency }} {{ number_format($payment->amount, 2) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500">Paid</span>
                                <span class="font-bold text-green-600">{{ $payment->currency }} {{ number_format($payment->paid_amount, 2) }}</span>
                            </div>
                            <div class="flex justify-between border-t pt-2">
                                <span class="text-gray-500">Due</span>
                                <span class="font-bold text-red-600">{{ $payment->currency }} {{ number_format($payment->due_amount, 2) }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Dates</h3>
                        <div class="space-y-3">
                            <div>
                                <p class="text-sm text-gray-500">Due Date</p>
                                <p class="font-medium text-gray-900 dark:text-white">{{ $payment->due_date?->format('M d, Y') ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Paid Date</p>
                                <p class="font-medium text-gray-900 dark:text-white">{{ $payment->paid_date?->format('M d, Y') ?? 'Not paid' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Received By</p>
                                <p class="font-medium text-gray-900 dark:text-white">{{ $payment->receivedBy->name ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
