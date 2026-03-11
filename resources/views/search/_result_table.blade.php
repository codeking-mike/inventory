<div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
    <table class="w-full text-left">
        <thead class="bg-gray-50 border-b border-gray-100">
            <tr>
                <th class="px-6 py-3 text-xs font-bold text-gray-500 uppercase">Item Details</th>
                <th class="px-6 py-3 text-xs font-bold text-gray-500 uppercase">Quantity</th>
                <th class="px-6 py-3 text-xs font-bold text-gray-500 uppercase text-right">Action</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
            @foreach($items as $item)
            <tr class="hover:bg-gray-50/50 transition">
                <td class="px-6 py-4">
                    <div class="text-sm font-bold text-gray-900">{{ $item->product_name }}</div>
                    
                </td>
                <td class="px-6 py-4 text-sm text-gray-600 font-mono">
                    {{ $item->quantity_in_stock ?? 'N/A' }}
                </td>
                <td class="px-6 py-4 text-right">
                    <a href="{{ route($type . '.show', $item->id) }}" class="text-blue-600 hover:text-blue-800 text-sm font-bold">
                        View Item →
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>