@extends('layouts.app')

@section('title', 'Ship Vendor Management - SISKA')
@section('page-title', 'Ship Vendor Management')
@section('page-subtitle', 'Manage shipping vendors and their information')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header Section -->
    <div class="bg-white rounded-xl shadow-sm mb-6">
        <div class="p-6 border-b border-gray-200">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                <div>
                    <h3 class="text-2xl font-bold text-gray-900">Ship Vendor Management</h3>
                    <p class="text-gray-600 mt-1">Manage shipping vendors, companies, and their information</p>
                </div>
                <div class="flex items-center space-x-4">
                    <!-- Stats Card -->
                    <div class="bg-blue-50 border border-blue-100 rounded-xl px-4 py-2 text-center">
                        <div class="text-lg font-bold text-blue-600">{{ $vendors->count() }}</div>
                        <div class="text-blue-700 text-sm">Total Vendors</div>
                    </div>
                    <button onclick="openAddModal()" 
                        class="px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white rounded-lg transition duration-200 font-medium shadow-lg">
                        <i class="fas fa-plus mr-2"></i>
                        Add New Vendor
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Search Section -->
    <div class="bg-white rounded-xl shadow-sm mb-6">
        <div class="p-6">
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-search text-gray-400"></i>
                </div>
                <input type="text" id="searchInput" 
                       placeholder="Search by company name or initials..." 
                       class="w-full pl-10 pr-12 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200">
                <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                    <button id="clearSearch" class="text-gray-400 hover:text-gray-600 hidden">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Vendors Table -->
    <div class="bg-white rounded-xl shadow-sm">
        <div class="p-6 border-b border-gray-200">
            <h4 class="text-lg font-semibold text-gray-900 flex items-center">
                <i class="fas fa-building text-blue-500 mr-2"></i>
                Vendor List
            </h4>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full" id="vendorsTable">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Company Name
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Initials
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($vendors as $vendor)
                    <tr class="hover:bg-gray-50 transition duration-200">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                        <i class="fas fa-building text-blue-600"></i>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $vendor->company }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                {{ $vendor->initials }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-2">
                                <button onclick="editVendor(this)" 
                                    data-company="{{ $vendor->company }}"
                                    data-initials="{{ $vendor->initials }}"
                                    data-id="{{ $vendor->id }}"
                                    class="inline-flex items-center px-3 py-1.5 bg-blue-50 text-blue-700 text-xs font-medium rounded-lg hover:bg-blue-100 transition duration-200 border border-blue-200"
                                    title="Edit Vendor">
                                    <i class="fas fa-edit mr-1"></i>
                                    Edit
                                </button>
                                <button onclick="confirmDelete({{ $vendor->id }})" 
                                    class="inline-flex items-center px-3 py-1.5 bg-red-50 text-red-700 text-xs font-medium rounded-lg hover:bg-red-100 transition duration-200 border border-red-200"
                                    title="Delete Vendor">
                                    <i class="fas fa-trash mr-1"></i>
                                    Delete
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <i class="fas fa-building text-4xl text-gray-300 mb-3"></i>
                                <h3 class="text-lg font-medium text-gray-900 mb-1">No Vendors Found</h3>
                                <p class="text-gray-500">Get started by adding your first vendor.</p>
                                <button onclick="openAddModal()" 
                                    class="mt-4 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200">
                                    <i class="fas fa-plus mr-2"></i>
                                    Add Vendor
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add/Edit Vendor Modal -->
<div id="vendorModal" class="fixed inset-0 z-50 bg-black bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-md mx-4 max-h-[90vh] overflow-y-auto">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 id="modalTitle" class="text-xl font-semibold text-gray-900">Add New Vendor</h3>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600 transition duration-200">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
        </div>
        
        <form id="vendorForm" method="POST" action="{{ route('vendor.store') }}">
            @csrf
            <div id="methodField"></div>
            <div class="p-6 space-y-6">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Company Name *</label>
                        <input type="text" name="company" id="company" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200"
                            placeholder="e.g., PT Bunga Teratai">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Initials *</label>
                        <input type="text" name="initials" id="initials" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200"
                            placeholder="e.g., BT">
                    </div>
                </div>
            </div>
            
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end space-x-3 rounded-b-xl">
                <button type="button" onclick="closeModal()" 
                    class="px-6 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition duration-200 font-medium">
                    Cancel
                </button>
                <button type="submit" 
                    class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200 font-medium">
                    <i class="fas fa-save mr-2"></i>
                    Save Vendor
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center">
    <div class="bg-white rounded-xl p-6 max-w-md w-full mx-4">
        <div class="text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
                <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Delete Vendor</h3>
            <p class="text-sm text-gray-500 mb-6">Are you sure you want to delete this vendor? This action cannot be undone.</p>
            <div class="flex space-x-3">
                <button onclick="closeDeleteModal()" 
                        class="flex-1 px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition">
                    Cancel
                </button>
                <form id="deleteForm" method="POST" class="flex-1">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="w-full px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                        Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@if(session('success'))
<div id="successAlert" class="fixed top-6 left-1/2 transform -translate-x-1/2 z-50 flex items-center justify-between max-w-md w-full px-4 py-3 rounded-lg bg-green-100 text-green-800 border border-green-200 shadow-lg">
    <div class="flex items-center">
        <svg class="w-5 h-5 mr-3 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
        </svg>
        <span class="font-medium">{{ session('success') }}</span>
    </div>
    <button onclick="closeAlert()" class="ml-4 text-green-600 hover:text-green-800 transition-colors duration-200">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
    </button>
</div>
@endif

<style>
/* Custom styles untuk tampilan yang lebih menarik */
.hover-card {
    transition: all 0.3s ease;
}

.hover-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

/* Success alert animation */
@keyframes slideInDown {
    from {
        opacity: 0;
        transform: translate(-50%, -20px);
    }
    to {
        opacity: 1;
        transform: translate(-50%, 0);
    }
}

#successAlert {
    animation: slideInDown 0.3s ease-out;
}
</style>

<script>
// Modal functions
function openAddModal() {
    document.getElementById('modalTitle').textContent = 'Add New Vendor';
    document.getElementById('vendorForm').reset();
    document.getElementById('methodField').innerHTML = '';
    document.getElementById('vendorForm').action = '{{ route("vendor.store") }}';
    document.getElementById('vendorModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function editVendor(btn) {
    document.getElementById('modalTitle').textContent = 'Edit Vendor';
    document.getElementById('company').value = btn.getAttribute('data-company');
    document.getElementById('initials').value = btn.getAttribute('data-initials');
    document.getElementById('methodField').innerHTML = '@method("PUT")';
    document.getElementById('vendorForm').action = `/ship-vendor-management/${btn.getAttribute('data-id')}`;
    document.getElementById('vendorModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeModal() {
    document.getElementById('vendorModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

function confirmDelete(id) {
    const modal = document.getElementById('deleteModal');
    const deleteForm = document.getElementById('deleteForm');
    if (modal) {
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        
        // Set the form action to the delete URL
        deleteForm.action = `/ship-vendor-management/${id}`;
    }
}

function closeDeleteModal() {
    const modal = document.getElementById('deleteModal');
    if (modal) {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
}

// Search functionality
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const clearSearch = document.getElementById('clearSearch');
    
    searchInput.addEventListener('input', function() {
        if (this.value) {
            clearSearch.classList.remove('hidden');
        } else {
            clearSearch.classList.add('hidden');
        }
        filterTable();
    });
    
    clearSearch.addEventListener('click', function() {
        searchInput.value = '';
        this.classList.add('hidden');
        filterTable();
    });
});

function filterTable() {
    const searchTerm = document.getElementById('searchInput').value.toLowerCase();
    const rows = document.querySelectorAll('#vendorsTable tbody tr');
    
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        if (text.includes(searchTerm)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}

function closeAlert() {
    const alert = document.getElementById('successAlert');
    if (alert) {
        alert.remove();
    }
}

// Auto close notification
document.addEventListener('DOMContentLoaded', function() {
    const successAlert = document.getElementById('successAlert');
    if (successAlert) {
        setTimeout(() => {
            closeAlert();
        }, 5000);
    }
});
</script>
@endsection