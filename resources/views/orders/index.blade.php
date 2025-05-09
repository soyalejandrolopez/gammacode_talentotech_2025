<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Orders') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">My Orders</h3>
                    
                    @if($orders->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white">
                                <thead>
                                    <tr>
                                        <th class="py-3 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order #</th>
                                        <th class="py-3 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                        <th class="py-3 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                        <th class="py-3 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="py-3 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Payment</th>
                                        <th class="py-3 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $order)
                                        <tr>
                                            <td class="py-4 px-4 border-b border-gray-200 text-sm text-gray-900">
                                                {{ $order->order_number }}
                                            </td>
                                            <td class="py-4 px-4 border-b border-gray-200 text-sm text-gray-900">
                                                {{ $order->created_at->format('M d, Y') }}
                                            </td>
                                            <td class="py-4 px-4 border-b border-gray-200 text-sm text-gray-900">
                                                ${{ number_format($order->total_amount, 2) }}
                                            </td>
                                            <td class="py-4 px-4 border-b border-gray-200 text-sm">
                                                @if($order->status == 'pending')
                                                    <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full">Pending</span>
                                                @elseif($order->status == 'processing')
                                                    <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full">Processing</span>
                                                @elseif($order->status == 'completed')
                                                    <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full">Completed</span>
                                                @elseif($order->status == 'declined')
                                                    <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full">Declined</span>
                                                @endif
                                            </td>
                                            <td class="py-4 px-4 border-b border-gray-200 text-sm">
                                                @if($order->payment_status == 'pending')
                                                    <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full">Pending</span>
                                                @elseif($order->payment_status == 'paid')
                                                    <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full">Paid</span>
                                                @elseif($order->payment_status == 'failed')
                                                    <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full">Failed</span>
                                                @endif
                                            </td>
                                            <td class="py-4 px-4 border-b border-gray-200 text-sm">
                                                <a href="{{ route('orders.show', $order) }}" class="text-blue-500 hover:text-blue-700">
                                                    <i class="fas fa-eye"></i> View
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-6">
                            {{ $orders->links() }}
                        </div>
                    @else
                        <div class="text-center py-8">
                            <i class="fas fa-shopping-bag text-gray-400 text-5xl mb-4"></i>
                            <h3 class="text-xl font-medium text-gray-900 mb-2">No Orders Found</h3>
                            <p class="text-gray-600 mb-4">You haven't placed any orders yet.</p>
                            <a href="{{ route('products.index') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                <i class="fas fa-shopping-bag mr-2"></i> Browse Products
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
