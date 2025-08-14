@extends('layouts.app')

@section('title', 'Ship Vendor Management - SISKA')
@section('page-title', 'Ship Vendor Management')
@section('page-subtitle', 'Manage ship vendors and their information')

@section('content')
<div class="max-w-6xl mx-auto">
    <!-- Header Section -->
    <div class="bg-white rounded-xl shadow-sm mb-6">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-xl font-bold text-gray-900">Ship Vendor Management</h3>
                    <p class="text-sm text-gray-600 mt-1">Manage all ship vendors and their company information</p>
                </div>
                <button onclick="openAddModal()" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition duration-200">
                    <i class="fas fa-plus mr-2"></i>
                    Add New Vendor
                </button>
            </div>
        </div>
    </div>

    <!-- Stats Card -->
    <div class="grid grid-cols-1 mb-6">
        <!-- Total Vendors -->
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm">Total Vendors</p>
                    <p class="text-2xl font-bold">{{ $vendors->count() }}</p>
                    <p class="text-blue-100 text-xs mt-1">Registered ship vendors</p>
                </div>
                <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                    <i class="fas fa-building text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter and Search -->
    <div class="bg-white rounded-xl shadow-sm mb-6">
        <div class="p-6">
            <div class="flex flex-col sm:flex-row gap-4">
                <div class="flex-1">
                    <div class="relative">
                        <input type="text" placeholder="Search vendors by name..." class="w-full px-4 py-3 pl-10 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <i class="fas fa-search absolute left-3 top-4 text-gray-400"></i>
                    </div>
                </div>
                <div class="flex gap-3">
                    <select class="px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 min-w-[120px]">
                        <option>All Status</option>
                        <option>Active</option>
                        <option>Inactive</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Vendors List -->
    <div class="bg-white rounded-xl shadow-sm">
        <div class="p-6 border-b border-gray-200">
            <h4 class="text-lg font-semibold text-gray-900">Ship Vendors</h4>
            <p class="text-sm text-gray-600 mt-1">Complete list of ship vendors</p>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Vendor Company</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Initials</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody id="vendor-table-body" class="bg-white divide-y divide-gray-200">
                    @if($vendors->isEmpty())
                        <tr>
                            <td colspan="4" class="py-12 text-center text-gray-400">
                                <div class="flex flex-col items-center justify-center">
                                    <!-- Inbox Icon SVG -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mb-3 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V7a2 2 0 00-2-2H6a2 2 0 00-2 2v6m16 0v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4m16 0H4m16 0l-3.293 3.293a1 1 0 01-1.414 0L12 15l-3.293 3.293a1 1 0 01-1.414 0L4 13"/>
                                    </svg>
                                    <span class="text-lg font-medium text-gray-400">No Data</span>
                                </div>
                            </td>
                        </tr>
                    @else
                        @foreach($vendors as $vendor)
                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center mr-4">
                                        <i class="fas fa-building text-white text-sm"></i>
                                    </div>
                                    <div>
                                        <div class="text-sm font-bold text-gray-900">{{ $vendor->company }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center">
                                    <span class="text-white font-bold text-sm">{{ $vendor->initials }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">{{ $vendor->status }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <button onclick="editVendor({{ $vendor->id }})" class="text-blue-600 hover:text-blue-900 p-2 rounded-lg hover:bg-blue-50 transition-colors duration-200">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button onclick="viewVendor({{ $vendor->id }})" class="text-green-600 hover:text-green-900 p-2 rounded-lg hover:bg-green-50 transition-colors duration-200">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button onclick="deleteVendor({{ $vendor->id }})" class="text-red-600 hover:text-red-900 p-2 rounded-lg hover:bg-red-50 transition-colors duration-200">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-gray-200">
            <div class="flex items-center justify-between">
                <div class="text-sm text-gray-500">
                    Showing 1 to 6 of 12 vendors
                </div>
                <div class="flex space-x-2">
                    <button class="px-3 py-2 border border-gray-300 rounded-lg text-sm text-gray-500 hover:bg-gray-50 transition-colors duration-200">Previous</button>
                    <button class="px-3 py-2 bg-blue-600 text-white rounded-lg text-sm">1</button>
                    <button class="px-3 py-2 border border-gray-300 rounded-lg text-sm text-gray-500 hover:bg-gray-50 transition-colors duration-200">2</button>
                    <button class="px-3 py-2 border border-gray-300 rounded-lg text-sm text-gray-500 hover:bg-gray-50 transition-colors duration-200">Next</button>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Notifikasi sukses --}}
@if(session('success'))
    <div id="successAlert" class="fixed top-6 left-1/2 transform -translate-x-1/2 z-50 flex items-center justify-between max-w-md w-full px-4 py-3 rounded bg-green-100 text-green-800 border border-green-200 shadow-lg">
        <div class="flex items-center">
            <svg class="w-5 h-5 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            <span>{{ session('success') }}</span>
        </div>
        <button onclick="document.getElementById('successAlert').style.display='none'" class="ml-4 text-green-700 hover:text-green-900">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>
@endif

<!-- Modal Add Vendor -->
<div id="addVendorModal" class="fixed inset-0 z-40 flex items-center justify-center bg-black bg-opacity-40 @if($errors->any()) @else hidden @endif">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-lg mx-4 relative">
        <!-- Modal Header -->
        <div class="flex items-center justify-between px-8 pt-8 pb-4 border-b">
            <h2 class="text-2xl font-bold">Add New Vendor</h2>
            <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600 transition">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <!-- Modal Body -->
        <form id="addVendorForm" method="POST" action="{{ route('vendor.store') }}" class="px-8 pt-6 pb-4">
            @csrf
            <div class="mb-5">
                <label for="vendor_company" class="block text-base font-semibold mb-2">Vendor Company <span class="text-red-500">*</span></label>
                <input type="text" id="vendor_company" name="company" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 placeholder-gray-400"
                    placeholder="e.g., PT BERLIAN LINTAS TAMA" value="{{ old('company') }}">
                @error('company')
                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-2">
                <label for="vendor_initials" class="block text-base font-semibold mb-2">Initials <span class="text-red-500">*</span></label>
                <input type="text" id="vendor_initials" name="initials" maxlength="5" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 placeholder-gray-400 uppercase"
                    placeholder="E.G., BLT" value="{{ old('initials') }}">
                <p class="text-xs text-gray-500 mt-1">Maximum 5 characters</p>
            </div>
            <div class="flex justify-end gap-3 mt-8">
                <button type="button" onclick="closeModal()" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">Cancel</button>
                <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold">Add Vendor</button>
            </div>
        </form>
    </div>
</div>

<script>
function openAddModal() {
    document.getElementById('addVendorModal').classList.remove('hidden');
    setTimeout(() => {
        document.getElementById('vendor_company').focus();
    }, 200);
}
function closeModal() {
    document.getElementById('addVendorModal').classList.add('hidden');
}
document.getElementById('vendor_initials').addEventListener('input', function(e) {
    e.target.value = e.target.value.toUpperCase();
});
</script>
@endsection