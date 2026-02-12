<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Financial Report') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 mb-6">
                <form method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-4">
                    <input type="date" name="from_date" value="{{ request('from_date') }}"
                        class="rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                    <input type="date" name="to_date" value="{{ request('to_date') }}"
                        class="rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                    <select name="status" class="rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        <option value="">All Status</option>
                        @foreach(['pending', 'partial', 'completed'] as $status)
                            <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                        @endforeach
                    </select>
                    <select name="payment_type" class="rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        <option value="">All Types</option>
                        @foreach(['consultation_fee', 'application_fee', 'visa_fee', 'tuition_fee'] as $type)
                            <option value="{{ $type }}" {{ request('payment_type') == $type ? 'selected' : '' }}>{{ ucfirst(str_replace('_', ' ', $type)) }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">Generate</button>
                </form>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                    <p class="text-sm text-gray-500">Total Amount</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white">NPR {{ number_format($summary['total_amount'], 2) }}</p>
                </div>
                <div class="bg-green-50 dark:bg-green-900 shadow-sm sm:rounded-lg p-6">
                    <p class="text-sm text-gray-500">Collected</p>
                    <p class="text-3xl font-bold text-green-600">NPR {{ number_format($summary['collected'], 2) }}</p>
                </div>
                <div class="bg-red-50 dark:bg-red-900 shadow-sm sm:rounded-lg p-6">
                    <p class="text-sm text-gray-500">Pending</p>
                    <p class="text-3xl font-bold text-red-600">NPR {{ number_format($summary['pending'], 2) }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">By Payment Type</h3>
                    <div class="space-y-3">
                        @foreach($summary['by_type'] as $type => $data)
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600 dark:text-gray-400">{{ ucfirst(str_replace('_', ' ', $type)) }}</span>
                            <div class="text-right">
                                <p class="font-medium text-gray-900 dark:text-white">NPR {{ number_format($data['total'], 2) }}</p>
                                <p class="text-xs text-green-600">Collected: NPR {{ number_format($data['collected'], 2) }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">By Status</h3>
                    <div class="space-y-3">
                        @foreach($summary['by_status'] as $status => $count)
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600 dark:text-gray-400">{{ ucfirst($status) }}</span>
                            <span class="font-medium text-gray-900 dark:text-white">{{ $count }} payments</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg overflow-hidden">
                <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Payment ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Student</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Amount</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Paid</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($payments as $payment)
                        <tr>
                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">{{ $payment->payment_id }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">{{ $payment->student?->full_name ?? 'N/A' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ ucfirst(str_replace('_', ' ', $payment->payment_type)) }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">{{ $payment->currency }} {{ number_format($payment->amount, 2) }}</td>
                            <td class="px-6 py-4 text-sm text-green-600">{{ $payment->currency }} {{ number_format($payment->paid_amount, 2) }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 text-xs rounded-full 
                                    @if($payment->status == 'completed') bg-green-100 text-green-800
                                    @elseif($payment->status == 'partial') bg-yellow-100 text-yellow-800
                                    @else bg-red-100 text-red-800 @endif">
                                    {{ ucfirst($payment->status) }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
