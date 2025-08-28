@extends('layouts.app')

@section('title', 'Dashboard - SISKA')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Shipping Instruction System Dashboard')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    
    <!-- Header Section -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Dashboard</h1>
                <p class="text-gray-600 mt-1">Shipping Instruction System Management</p>
            </div>
            <div class="text-right text-sm text-gray-500">
                <p class="font-medium text-gray-700">{{ now()->format('l, d F Y') }}</p>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Total Shipping Instructions -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-all duration-300">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center">
                        <i class="fas fa-file-alt text-blue-600 text-lg"></i>
                    </div>
                </div>
                <div class="ml-4 flex-1">
                    <p class="text-sm font-medium text-gray-600">Total Shipping Instructions</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ number_format($totalShippingInstructions) }}</p>
                    <p class="text-xs text-gray-500 mt-1">All documents</p>
                </div>
            </div>
        </div>

        <!-- Completed Shipping Instructions -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-all duration-300">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-green-50 rounded-xl flex items-center justify-center">
                        <i class="fas fa-check-circle text-green-600 text-lg"></i>
                    </div>
                </div>
                <div class="ml-4 flex-1">
                    <p class="text-sm font-medium text-gray-600">Completed Shipping Instructions</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ number_format($completedShippingInstructions) }}</p>
                    <p class="text-xs text-gray-500 mt-1">With SPAL documents</p>
                </div>
            </div>
        </div>

        <!-- Total Vendors -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-all duration-300">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-purple-50 rounded-xl flex items-center justify-center">
                        <i class="fas fa-anchor text-purple-600 text-lg"></i>
                    </div>
                </div>
                <div class="ml-4 flex-1">
                    <p class="text-sm font-medium text-gray-600">Total Vendors</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ number_format($totalVendors) }}</p>
                    <p class="text-xs text-gray-500 mt-1">Registered vendors</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        
        <!-- Quick Actions -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 h-full">
                <div class="p-6 border-b border-gray-100">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-bolt text-yellow-500 mr-2"></i>
                        Quick Actions
                    </h3>
                    <p class="text-sm text-gray-500 mt-1">Common tasks</p>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        <a href="/shipping-instruction" 
                           class="group flex items-center p-4 border border-gray-200 rounded-lg hover:border-blue-300 hover:bg-blue-50 transition-all duration-200">
                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-4 group-hover:bg-blue-200 transition-colors duration-200">
                                <i class="fas fa-plus text-blue-600"></i>
                            </div>
                            <div class="flex-1">
                                <p class="font-semibold text-gray-900 group-hover:text-blue-700">Create New SI</p>
                                <p class="text-xs text-gray-500 mt-0.5">Generate document</p>
                            </div>
                        </a>

                        <a href="/shipping-instruction-overview" 
                           class="group flex items-center p-4 border border-gray-200 rounded-lg hover:border-green-300 hover:bg-green-50 transition-all duration-200">
                            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-4 group-hover:bg-green-200 transition-colors duration-200">
                                <i class="fas fa-table text-green-600"></i>
                            </div>
                            <div class="flex-1">
                                <p class="font-semibold text-gray-900 group-hover:text-green-700">Manage SI</p>
                                <p class="text-xs text-gray-500 mt-0.5">View & edit documents</p>
                            </div>
                        </a>

                        <a href="/ship-vendor-management" 
                           class="group flex items-center p-4 border border-gray-200 rounded-lg hover:border-purple-300 hover:bg-purple-50 transition-all duration-200">
                            <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center mr-4 group-hover:bg-purple-200 transition-colors duration-200">
                                <i class="fas fa-anchor text-purple-600"></i>
                            </div>
                            <div class="flex-1">
                                <p class="font-semibold text-gray-900 group-hover:text-purple-700">Manage Vendors</p>
                                <p class="text-xs text-gray-500 mt-0.5">Add or edit vendors</p>
                            </div>
                        </a>

                        <a href="/report" 
                           class="group flex items-center p-4 border border-gray-200 rounded-lg hover:border-indigo-300 hover:bg-indigo-50 transition-all duration-200">
                            <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center mr-4 group-hover:bg-indigo-200 transition-colors duration-200">
                                <i class="fas fa-chart-bar text-indigo-600"></i>
                            </div>
                            <div class="flex-1">
                                <p class="font-semibold text-gray-900 group-hover:text-indigo-700">Generate Reports</p>
                                <p class="text-xs text-gray-500 mt-0.5">Create reports</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Documents -->
        <div class="lg:col-span-3">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 h-full">
                <div class="p-6 border-b border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                                <i class="fas fa-clock text-blue-500 mr-2"></i>
                                Recent Shipping Instructions
                            </h3>
                            <p class="text-sm text-gray-500 mt-1">Latest document activities</p>
                        </div>
                        <a href="/shipping-instruction-overview" 
                           class="text-sm text-blue-600 hover:text-blue-700 font-medium flex items-center transition-colors duration-200">
                            View All 
                            <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
                
                <div class="overflow-hidden">
                    @if($recentDocuments->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-100">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Number</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Vendor</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-100">
                                    @foreach($recentDocuments as $doc)
                                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $doc->created_at->format('d M Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $doc->number }}</div>
                                            <div class="text-xs text-gray-500 mt-0.5">{{ Str::limit($doc->tugbarge, 25) }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ Str::limit($doc->to, 30) }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($doc->completed_at)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    <i class="fas fa-check-circle mr-1.5"></i>
                                                    Completed
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                    <i class="fas fa-clock mr-1.5"></i>
                                                    Incomplete
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <a href="{{ url('/shipping-instruction-preview/'.$doc->id) }}" 
                                               class="inline-flex items-center px-3 py-1.5 bg-blue-100 text-blue-700 hover:bg-blue-200 text-sm font-medium rounded-lg transition-colors duration-200">
                                                <i class="fas fa-eye mr-1.5"></i>
                                                View
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-16">
                            <div class="w-20 h-20 mx-auto mb-4 bg-gray-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-inbox text-3xl text-gray-400"></i>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">No Recent Documents</h3>
                            <p class="text-gray-500 mb-6">Start by creating your first shipping instruction</p>
                            <a href="/shipping-instruction" 
                               class="inline-flex items-center px-6 py-3 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors duration-200 shadow-sm">
                                <i class="fas fa-plus mr-2"></i>
                                Create Shipping Instruction
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection