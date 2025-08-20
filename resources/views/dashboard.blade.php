@extends('layouts.app')

@section('title', 'SISKA Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Today | September 20')

@section('content')
<!-- Stats Grid - 3 Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <!-- Card 1 - Total Shipping Instruction Documents -->
    <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-blue-100 text-sm">Total Shipping Instruction</p>
                <p class="text-3xl font-bold">{{ $totalShippingInstructions }}</p>
                <p class="text-blue-100 text-xs mt-1">Documents</p>
            </div>
            <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                <i class="fas fa-file-alt text-xl"></i>
            </div>
        </div>
    </div>

    <!-- Card 2 - Total Vendors -->
    <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-xl p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-green-100 text-sm">Total Vendor</p>
                <p class="text-3xl font-bold">{{ $totalVendors }}</p>
                <p class="text-green-100 text-xs mt-1">Companies</p>
            </div>
            <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                <i class="fas fa-anchor text-xl"></i>
            </div>
        </div>
    </div>

    <!-- Card 3 - Total Signatories -->
    <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-xl p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-purple-100 text-sm">Signatory</p>
                <p class="text-3xl font-bold">{{ $totalSignatories }}</p>
                <p class="text-purple-100 text-xs mt-1">Authorized</p>
            </div>
            <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                <i class="fas fa-signature text-xl"></i>
            </div>
        </div>
    </div>
</div>

<!-- Recent Documents Table -->
<div class="bg-white rounded-xl shadow-sm">
    <div class="p-6 border-b">
        <h3 class="text-lg font-semibold text-gray-800">Recent Documents</h3>
        <p class="text-sm text-gray-500 mt-1">Latest shipping instruction documents created</p>
    </div>
    <div class="p-6">
        @php
            $colors = [
                'bg-blue-100 text-blue-500',
                'bg-green-100 text-green-500',
                'bg-yellow-100 text-yellow-500',
                'bg-purple-100 text-purple-500',
                'bg-pink-100 text-pink-500',
                'bg-red-100 text-red-500',
                'bg-indigo-100 text-indigo-500',
                'bg-teal-100 text-teal-500',
                'bg-orange-100 text-orange-500',
            ];
        @endphp
        <div class="space-y-4">
            @forelse($recentDocuments as $doc)
            @php
                $color = $colors[array_rand($colors)];
            @endphp
            <div class="flex items-center justify-between py-3 border-b border-gray-100">
                <div class="flex items-center">
                    <div class="w-10 h-10 {{ explode(' ', $color)[0] }} rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-file-alt {{ explode(' ', $color)[1] }}"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-800">{{ $doc->number }}</p>
                        <p class="text-xs text-gray-500">Kapal: {{ $doc->tugbarge }}</p>
                    </div>
                </div>
                <div class="text-right">
                    <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-medium">
                        Completed
                    </span>
                    <p class="text-xs text-gray-400 mt-1">{{ $doc->created_at->diffForHumans() }}</p>
                </div>
            </div>
            @empty
            <p class="text-gray-500">No documents found.</p>
            @endforelse
        </div>
        
        <div class="mt-6 text-center">
            <a href="/shipping-instruction" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                View All Documents →
            </a>
        </div>
    </div>
</div>
@endsection