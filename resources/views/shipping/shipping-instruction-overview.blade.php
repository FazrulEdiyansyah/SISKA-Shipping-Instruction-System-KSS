@extends('layouts.app')

@section('title', 'SI Overview')
@section('page-title', 'Shipping Instruction Overview')

@section('content')
<div class="bg-white rounded-xl shadow-sm p-6">
    <h3 class="text-lg font-bold text-gray-800 mb-4">Shipping Instruction List</h3>
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200 rounded-lg">
            <thead>
                <tr class="bg-gray-50 text-gray-700 text-sm text-center">
                    <th class="px-4 py-2 border-b">No</th>
                    <th class="px-4 py-2 border-b">SI Number</th>
                    <th class="px-4 py-2 border-b">Vendor</th>
                    <th class="px-4 py-2 border-b">Tug/Barge</th>
                    <th class="px-4 py-2 border-b">Shipper</th>
                    <th class="px-4 py-2 border-b">Status</th>
                    <th class="px-4 py-2 border-b">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($shippingInstructions as $si)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-2 border-b text-center text-gray-600">
                        {{ ($shippingInstructions->currentPage() - 1) * $shippingInstructions->perPage() + $loop->iteration }}
                    </td>
                    <td class="px-4 py-2 border-b text-gray-800">{{ $si->number }}</td>
                    <td class="px-4 py-2 border-b text-gray-700">{{ $si->to }}</td>
                    <td class="px-4 py-2 border-b text-gray-700">{{ $si->tugbarge }}</td>
                    <td class="px-4 py-2 border-b text-gray-700">{{ $si->shipper }}</td>
                    <td class="px-4 py-2 border-b text-center">
                        <span class="inline-block px-2 py-1 rounded text-xs font-semibold
                            {{ $si->remarks ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                            {{ $si->remarks ? 'Completed' : 'Draft' }}
                        </span>
                    </td>
                    <td class="px-4 py-2 border-b text-center">
                        <a href="{{ url('/shipping-instruction-preview/'.$si->id) }}" class="inline-flex items-center px-2 py-1 text-blue-600 hover:text-blue-800 text-xs font-medium rounded hover:bg-blue-50 transition" title="Preview">
                            <i class="fas fa-eye mr-1"></i> Preview
                        </a>
                        <a href="{{ url('/shipping-instruction/preview-pdf?id='.$si->id) }}" class="inline-flex items-center px-2 py-1 text-green-600 hover:text-green-800 text-xs font-medium rounded hover:bg-green-50 transition" title="Download PDF">
                            <i class="fas fa-file-pdf mr-1"></i> PDF
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-4 py-6 text-center text-gray-400">No Shipping Instructions found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">
        {{ $shippingInstructions->links() }}
    </div>
</div>
@endsection