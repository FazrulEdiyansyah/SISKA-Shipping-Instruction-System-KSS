@extends('layouts.app')

@section('title', 'SI Overview')
@section('page-title', 'Shipping Instruction Overview')

@section('content')
<div class="bg-white rounded-xl shadow-sm p-6">
    @if(session('success'))
    <div id="successAlert" class="fixed top-6 left-1/2 transform -translate-x-1/2 z-50 flex items-center justify-between max-w-md w-full px-4 py-3 rounded-lg bg-green-100 text-green-800 border border-green-200 shadow-lg mb-4">
        <div class="flex items-center">
            <svg class="w-5 h-5 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            <span>{{ session('success') }}</span>
        </div>
        <button onclick="document.getElementById('successAlert').style.display='none'" class="ml-4 text-green-700 hover:text-green-900 transition-colors duration-200">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>
    @endif

    <!-- Enhanced Header Section -->
    <div class="mb-6">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-6">
            <div>
                <h3 class="text-2xl font-bold text-gray-900">Shipping Instruction Overview</h3>
                <p class="text-gray-600 mt-1">Manage and view all shipping instructions</p>
            </div>
            
            <!-- Stats Cards -->
            <div class="flex gap-4">
                <div class="bg-blue-50 border border-blue-100 rounded-xl px-6 py-4 text-center">
                    <div class="text-2xl font-bold text-blue-600">{{ $totalSI }}</div>
                    <div class="text-sm text-blue-700 font-medium mt-1">Total SI</div>
                </div>
                <div class="bg-green-50 border border-green-100 rounded-xl px-6 py-4 text-center">
                    <div class="text-2xl font-bold text-green-600">{{ $totalCompleted }}</div>
                    <div class="text-sm text-green-700 font-medium mt-1">Completed</div>
                </div>
                <div class="bg-yellow-50 border border-yellow-100 rounded-xl px-6 py-4 text-center">
                    <div class="text-2xl font-bold text-yellow-600">{{ $totalIncomplete }}</div>
                    <div class="text-sm text-yellow-700 font-medium mt-1">Incomplete</div>
                </div>
            </div>
        </div>

        <!-- Enhanced Search and Filter Section -->
        <div class="bg-gray-50 rounded-xl p-4 border border-gray-200">
            <div class="flex flex-col lg:flex-row gap-4">
                <!-- Advanced Search Bar -->
                <div class="flex-1">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                        <input type="text" 
                               id="siSearchInput" 
                               placeholder="Search by SI Number, Vendor, Tugbarge, Shipper..." 
                               class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200" />
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <button id="clearSearch" class="text-gray-400 hover:text-gray-600 transition-colors duration-200 hidden">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Quick Filters -->
                <div class="flex gap-2">
                    <button id="filterCompleted" class="px-4 py-3 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-all duration-200 text-sm font-medium">
                        <i class="fas fa-check-circle text-green-500 mr-1"></i>
                        Completed
                    </button>
                    <button id="filterIncomplete" class="px-4 py-3 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-all duration-200 text-sm font-medium">
                        <i class="fas fa-clock text-yellow-500 mr-1"></i>
                        Incomplete
                    </button>
                    <button id="filterBtn" class="px-4 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-all duration-200 flex items-center gap-2 font-medium">
                        <i class="fas fa-filter"></i>
                        Advanced Filter
                    </button>
                    <button id="resetAllFilters" class="px-4 py-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-all duration-200 font-medium">
                        <i class="fas fa-refresh mr-1"></i>
                        Reset
                    </button>
                </div>
            </div>

            <!-- Active Filters Display -->
            <div id="activeFilters" class="mt-3 flex flex-wrap gap-2 hidden">
                <!-- Active filter tags will be inserted here -->
            </div>
        </div>
    </div>

    <!-- Enhanced Table Section -->
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table id="siTable" class="min-w-full">
                <thead>
                    <tr class="bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                        <th class="px-4 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider w-16">
                            <div class="flex items-center">
                                No
                            </div>
                        </th>
                        <th class="px-4 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            <div class="flex items-center cursor-pointer hover:text-gray-900 transition-colors duration-200" onclick="sortTable(1)">
                                SI Number
                                <i class="fas fa-sort ml-1 opacity-50"></i>
                            </div>
                        </th>
                        <th class="px-4 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Vendor
                        </th>
                        <th class="px-4 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Tug/Barge
                        </th>
                        <th class="px-4 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Shipper
                        </th>
                        <th class="px-4 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Commodities
                        </th>
                        <th class="px-4 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Quantity
                        </th>
                        <th class="px-4 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Status
                        </th>
                        <th class="px-4 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($shippingInstructions as $si)
                    <tr class="hover:bg-gray-50 transition-colors duration-200" data-status="{{ $si->completed_at ? 'completed' : 'incomplete' }}">
                        <td class="px-4 py-4 text-sm text-gray-600 font-medium">
                            {{ ($shippingInstructions->currentPage() - 1) * $shippingInstructions->perPage() + $loop->iteration }}
                        </td>
                        <td class="px-4 py-4">
                            <div class="text-sm font-semibold text-gray-900">{{ $si->number }}</div>
                            <div class="text-xs text-gray-500 mt-0.5">{{ $si->created_at->format('d M Y') }}</div>
                        </td>
                        <td class="px-4 py-4">
                            <div class="text-sm font-medium text-gray-900">{{ $si->to }}</div>
                        </td>
                        <td class="px-4 py-4">
                            <div class="text-sm text-gray-700">{{ Str::limit($si->tugbarge, 30) }}</div>
                        </td>
                        <td class="px-4 py-4">
                            <div class="text-sm text-gray-700">{{ Str::limit($si->shipper, 25) }}</div>
                        </td>
                        <td class="px-4 py-4">
                            <div class="text-sm text-gray-700">{{ Str::limit($si->commodities, 20) }}</div>
                        </td>
                        <td class="px-4 py-4">
                            <div class="text-sm text-gray-700">{{ $si->quantity }}</div>
                        </td>
                        <td class="px-4 py-4 text-center">
                            @if($si->completed_at)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 border border-green-200">
                                    <i class="fas fa-check-circle mr-1.5"></i>
                                    Completed
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 border border-yellow-200">
                                    <i class="fas fa-clock mr-1.5"></i>
                                    Incomplete
                                </span>
                            @endif
                        </td>
                        <td class="px-4 py-4 text-center">
                            <div class="flex items-center justify-center space-x-2">
                                <a href="{{ url('/shipping-instruction-preview/'.$si->id) }}" 
                                   class="inline-flex items-center px-3 py-1.5 bg-blue-50 text-blue-700 text-xs font-medium rounded-lg hover:bg-blue-100 transition-colors duration-200 border border-blue-200"
                                   title="View Details">
                                    <i class="fas fa-eye mr-1.5"></i>
                                    View
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr id="emptyRow">
                        <td colspan="9" class="px-4 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <i class="fas fa-inbox text-4xl text-gray-300 mb-3"></i>
                                <h3 class="text-lg font-medium text-gray-900 mb-1">No Shipping Instructions</h3>
                                <p class="text-gray-500">No shipping instructions found matching your criteria.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Custom Enhanced Pagination -->
    @if($shippingInstructions->hasPages())
    <div class="mt-6 bg-white rounded-xl border border-gray-200 px-6 py-4">
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
            <!-- Pagination Info -->
            <div class="text-sm text-gray-700">
                <span class="font-medium">{{ $shippingInstructions->firstItem() ?? 0 }}</span>
                to
                <span class="font-medium">{{ $shippingInstructions->lastItem() ?? 0 }}</span>
                of
                <span class="font-medium">{{ $shippingInstructions->total() }}</span>
                results
            </div>
            
            <!-- Pagination Links -->
            <div class="flex items-center space-x-1">
                {{-- Previous Page Link --}}
                @if ($shippingInstructions->onFirstPage())
                    <span class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-300 bg-gray-100 border border-gray-300 cursor-not-allowed rounded-lg">
                        <i class="fas fa-chevron-left mr-1"></i>
                        Previous
                    </span>
                @else
                    <a href="{{ $shippingInstructions->previousPageUrl() }}" 
                       class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 hover:text-gray-500 transition-colors duration-200">
                        <i class="fas fa-chevron-left mr-1"></i>
                        Previous
                    </a>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($shippingInstructions->getUrlRange(1, $shippingInstructions->lastPage()) as $page => $url)
                    @if ($page == $shippingInstructions->currentPage())
                        <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-blue-600 rounded-lg">
                            {{ $page }}
                        </span>
                    @else
                        <a href="{{ $url }}" 
                           class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 hover:text-gray-500 transition-colors duration-200">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($shippingInstructions->hasMorePages())
                    <a href="{{ $shippingInstructions->nextPageUrl() }}" 
                       class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 hover:text-gray-500 transition-colors duration-200">
                        Next
                        <i class="fas fa-chevron-right ml-1"></i>
                    </a>
                @else
                    <span class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-300 bg-gray-100 border border-gray-300 cursor-not-allowed rounded-lg">
                        Next
                        <i class="fas fa-chevron-right ml-1"></i>
                    </span>
                @endif
            </div>
        </div>
    </div>
    @endif
</div>

<!-- Enhanced Filter Modal -->
<div id="filterModal" class="fixed inset-0 z-50 bg-black bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-2xl mx-4 max-h-[90vh] overflow-y-auto">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 class="text-xl font-semibold text-gray-900">Advanced Filters</h3>
                <button id="closeFilterModal" class="text-gray-400 hover:text-gray-600 transition-colors duration-200">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
        </div>
        
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Document Date</label>
                    <input type="date" id="filterDate" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200" />
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                    <select id="filterStatus" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200">
                        <option value="">All Status</option>
                        <option value="completed">Completed</option>
                        <option value="incomplete">Incomplete</option>
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Vendor</label>
                    <select id="filterVendor" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200">
                        <option value="">All Vendors</option>
                        @foreach(\App\Models\Vendor::orderBy('company')->get() as $vendor)
                            <option value="{{ $vendor->company }}">{{ $vendor->company }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Signatory</label>
                    <select id="filterSignatory" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200">
                        <option value="">All Signatories</option>
                        @foreach(\App\Models\Signatory::orderBy('name')->get() as $signatory)
                            <option value="{{ $signatory->name }}">{{ $signatory->name }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Laycan Period</label>
                    <div class="flex gap-3">
                        <div class="flex-1">
                            <input type="date" id="filterLaycanStart" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200" placeholder="From" />
                        </div>
                        <div class="flex items-center px-2 text-gray-500">to</div>
                        <div class="flex-1">
                            <input type="date" id="filterLaycanEnd" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200" placeholder="To" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end gap-3">
            <button id="resetFilter" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors duration-200 font-medium">
                <i class="fas fa-refresh mr-1"></i>
                Reset
            </button>
            <button id="applyFilter" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200 font-medium">
                <i class="fas fa-check mr-1"></i>
                Apply Filters
            </button>
        </div>
    </div>
</div>

<script>
// Enhanced search and filter functionality
let currentFilters = {};
let sortDirection = {};

document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('siSearchInput');
    const clearSearchBtn = document.getElementById('clearSearch');
    
    // Enhanced search functionality
    searchInput.addEventListener('input', function() {
        const searchValue = this.value.trim();
        if (searchValue) {
            clearSearchBtn.classList.remove('hidden');
        } else {
            clearSearchBtn.classList.add('hidden');
        }
        filterTable();
    });
    
    clearSearchBtn.addEventListener('click', function() {
        searchInput.value = '';
        this.classList.add('hidden');
        filterTable();
    });
    
    // Quick filter buttons
    document.getElementById('filterCompleted').addEventListener('click', function() {
        toggleQuickFilter('status', 'completed', this);
    });
    
    document.getElementById('filterIncomplete').addEventListener('click', function() {
        toggleQuickFilter('status', 'incomplete', this);
    });
    
    document.getElementById('resetAllFilters').addEventListener('click', function() {
        resetAllFilters();
    });
});

function toggleQuickFilter(filterType, filterValue, button) {
    if (currentFilters[filterType] === filterValue) {
        delete currentFilters[filterType];
        button.classList.remove('bg-blue-600', 'text-white');
        button.classList.add('bg-white', 'border-gray-300');
    } else {
        currentFilters[filterType] = filterValue;
        button.classList.remove('bg-white', 'border-gray-300');
        button.classList.add('bg-blue-600', 'text-white');
        
        // Remove active state from other status buttons
        document.querySelectorAll('[id^="filter"]:not(#' + button.id + ')').forEach(btn => {
            if (btn.id.includes('Completed') || btn.id.includes('Incomplete')) {
                btn.classList.remove('bg-blue-600', 'text-white');
                btn.classList.add('bg-white', 'border-gray-300');
            }
        });
    }
    updateActiveFilters();
    filterTable();
}

function filterTable() {
    const search = document.getElementById('siSearchInput').value.toLowerCase();
    const rows = document.querySelectorAll('#siTable tbody tr:not(#emptyRow)');
    let visibleCount = 0;
    
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        let show = true;
        
        // Search filter
        if (search && !text.includes(search)) {
            show = false;
        }
        
        // Status filter
        if (currentFilters.status) {
            const rowStatus = row.getAttribute('data-status');
            if (rowStatus !== currentFilters.status) {
                show = false;
            }
        }
        
        // Advanced filters
        if (currentFilters.vendor && !row.children[2].textContent.toLowerCase().includes(currentFilters.vendor.toLowerCase())) {
            show = false;
        }
        
        if (currentFilters.signatory && !text.includes(currentFilters.signatory.toLowerCase())) {
            show = false;
        }
        
        if (currentFilters.date) {
            const dateMatch = row.textContent.match(/\d{2} \w{3} \d{4}/);
            if (!dateMatch) {
                show = false;
            } else {
                const rowDate = new Date(dateMatch[0]).toISOString().split('T')[0];
                if (rowDate !== currentFilters.date) {
                    show = false;
                }
            }
        }
        
        // Laycan filters
        if (currentFilters.laycanStart || currentFilters.laycanEnd) {
            // Implementation for laycan filtering
            // This would need to be customized based on your laycan data structure
        }
        
        if (show) {
            row.style.display = '';
            visibleCount++;
        } else {
            row.style.display = 'none';
        }
    });
    
    // Show/hide empty state
    const emptyRow = document.getElementById('emptyRow');
    if (visibleCount === 0 && !emptyRow) {
        const tbody = document.querySelector('#siTable tbody');
        const newEmptyRow = document.createElement('tr');
        newEmptyRow.id = 'noResults';
        newEmptyRow.innerHTML = `
            <td colspan="9" class="px-4 py-12 text-center">
                <div class="flex flex-col items-center">
                    <i class="fas fa-search text-4xl text-gray-300 mb-3"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-1">No Results Found</h3>
                    <p class="text-gray-500">Try adjusting your search or filter criteria.</p>
                </div>
            </td>
        `;
        tbody.appendChild(newEmptyRow);
    } else if (visibleCount > 0) {
        const noResultsRow = document.getElementById('noResults');
        if (noResultsRow) {
            noResultsRow.remove();
        }
    }
}

function updateActiveFilters() {
    const activeFiltersContainer = document.getElementById('activeFilters');
    activeFiltersContainer.innerHTML = '';
    
    if (Object.keys(currentFilters).length > 0) {
        activeFiltersContainer.classList.remove('hidden');
        
        Object.entries(currentFilters).forEach(([key, value]) => {
            const filterTag = document.createElement('span');
            filterTag.className = 'inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800';
            filterTag.innerHTML = `
                ${key}: ${value}
                <button onclick="removeFilter('${key}')" class="ml-1 text-blue-600 hover:text-blue-800 transition-colors duration-200">
                    <i class="fas fa-times"></i>
                </button>
            `;
            activeFiltersContainer.appendChild(filterTag);
        });
    } else {
        activeFiltersContainer.classList.add('hidden');
    }
}

function removeFilter(filterKey) {
    delete currentFilters[filterKey];
    
    // Reset corresponding UI elements
    if (filterKey === 'status') {
        document.querySelectorAll('[id^="filter"][id*="Completed"], [id^="filter"][id*="Incomplete"]').forEach(btn => {
            btn.classList.remove('bg-blue-600', 'text-white');
            btn.classList.add('bg-white', 'border-gray-300');
        });
    }
    
    updateActiveFilters();
    filterTable();
}

function resetAllFilters() {
    currentFilters = {};
    document.getElementById('siSearchInput').value = '';
    document.getElementById('clearSearch').classList.add('hidden');
    
    // Reset quick filter buttons
    document.querySelectorAll('[id^="filter"]:not(#filterBtn):not(#resetAllFilters)').forEach(btn => {
        btn.classList.remove('bg-blue-600', 'text-white');
        btn.classList.add('bg-white', 'border-gray-300');
    });
    
    // Reset advanced filter form
    document.getElementById('filterDate').value = '';
    document.getElementById('filterStatus').value = '';
    document.getElementById('filterVendor').value = '';
    document.getElementById('filterSignatory').value = '';
    document.getElementById('filterLaycanStart').value = '';
    document.getElementById('filterLaycanEnd').value = '';
    
    updateActiveFilters();
    filterTable();
}

// Sort functionality
function sortTable(columnIndex) {
    const table = document.getElementById('siTable');
    const tbody = table.querySelector('tbody');
    const rows = Array.from(tbody.querySelectorAll('tr:not(#emptyRow):not(#noResults)'));
    
    const direction = sortDirection[columnIndex] === 'asc' ? 'desc' : 'asc';
    sortDirection[columnIndex] = direction;
    
    rows.sort((a, b) => {
        const aText = a.children[columnIndex].textContent.trim();
        const bText = b.children[columnIndex].textContent.trim();
        
        if (direction === 'asc') {
            return aText.localeCompare(bText);
        } else {
            return bText.localeCompare(aText);
        }
    });
    
    // Clear tbody and re-append sorted rows
    tbody.innerHTML = '';
    rows.forEach(row => tbody.appendChild(row));
    
    // Update sort indicators
    document.querySelectorAll('th .fas.fa-sort, th .fas.fa-sort-up, th .fas.fa-sort-down').forEach(icon => {
        icon.className = 'fas fa-sort ml-1 opacity-50';
    });
    
    const currentIcon = document.querySelector(`th:nth-child(${columnIndex + 1}) .fas`);
    if (currentIcon) {
        currentIcon.className = `fas fa-sort-${direction === 'asc' ? 'up' : 'down'} ml-1 opacity-75`;
    }
}

// Modal functionality
const filterBtn = document.getElementById('filterBtn');
const filterModal = document.getElementById('filterModal');
const closeFilterModal = document.getElementById('closeFilterModal');
const applyFilter = document.getElementById('applyFilter');
const resetFilter = document.getElementById('resetFilter');

filterBtn.addEventListener('click', () => {
    filterModal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
});

closeFilterModal.addEventListener('click', () => {
    filterModal.classList.add('hidden');
    document.body.style.overflow = 'auto';
});

// Close modal when clicking outside
filterModal.addEventListener('click', (e) => {
    if (e.target === filterModal) {
        filterModal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }
});

applyFilter.addEventListener('click', () => {
    // Apply advanced filters
    const date = document.getElementById('filterDate').value;
    const status = document.getElementById('filterStatus').value;
    const vendor = document.getElementById('filterVendor').value;
    const signatory = document.getElementById('filterSignatory').value;
    const laycanStart = document.getElementById('filterLaycanStart').value;
    const laycanEnd = document.getElementById('filterLaycanEnd').value;
    
    if (date) currentFilters.date = date;
    if (status) currentFilters.status = status;
    if (vendor) currentFilters.vendor = vendor;
    if (signatory) currentFilters.signatory = signatory;
    if (laycanStart) currentFilters.laycanStart = laycanStart;
    if (laycanEnd) currentFilters.laycanEnd = laycanEnd;
    
    updateActiveFilters();
    filterTable();
    filterModal.classList.add('hidden');
    document.body.style.overflow = 'auto';
});

resetFilter.addEventListener('click', () => {
    document.getElementById('filterDate').value = '';
    document.getElementById('filterStatus').value = '';
    document.getElementById('filterVendor').value = '';
    document.getElementById('filterSignatory').value = '';
    document.getElementById('filterLaycanStart').value = '';
    document.getElementById('filterLaycanEnd').value = '';
});

// Auto-close success alert
setTimeout(() => {
    const successAlert = document.getElementById('successAlert');
    if (successAlert) {
        successAlert.style.display = 'none';
    }
}, 5000);
</script>

<style>
/* Custom styles for enhanced appearance */
.table-hover-effect {
    transition: all 0.2s ease-in-out;
}

.table-hover-effect:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

/* Animation for filter tags */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}

#activeFilters span {
    animation: fadeIn 0.3s ease-out;
}

/* Custom scrollbar for modal */
.max-h-\[90vh\]::-webkit-scrollbar {
    width: 6px;
}

.max-h-\[90vh\]::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 3px;
}

.max-h-\[90vh\]::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 3px;
}

.max-h-\[90vh\]::-webkit-scrollbar-thumb:hover {
    background: #a8a8a8;
}

/* Responsive table improvements */
@media (max-width: 768px) {
    #siTable {
        font-size: 0.875rem;
    }
    
    #siTable th,
    #siTable td {
        padding: 0.5rem;
    }
}

/* Loading animation */
.loading {
    opacity: 0.6;
    pointer-events: none;
}

.loading::after {
    content: "";
    position: absolute;
    top: 50%;
    left: 50%;
    width: 20px;
    height: 20px;
    margin: -10px 0 0 -10px;
    border: 2px solid #f3f3f3;
    border-top: 2px solid #3498db;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Custom Pagination Styles */
.pagination-container {
    background: white;
    border-radius: 12px;
    border: 1px solid #e5e7eb;
    padding: 1.5rem;
    margin-top: 1.5rem;
}

.pagination-info {
    color: #374151;
    font-size: 0.875rem;
}

.pagination-info .font-medium {
    font-weight: 600;
    color: #111827;
}

.pagination-nav {
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

.pagination-nav a,
.pagination-nav span {
    display: inline-flex;
    align-items: center;
    padding: 0.5rem 1rem;
    font-size: 0.875rem;
    font-weight: 500;
    border: 1px solid #d1d5db;
    border-radius: 0.5rem;
    transition: all 0.2s;
    text-decoration: none;
}

.pagination-nav a {
    color: #374151;
    background-color: white;
}

.pagination-nav a:hover {
    background-color: #f9fafb;
    color: #6b7280;
}

.pagination-nav .current-page {
    color: white;
    background-color: #2563eb;
    border-color: #2563eb;
}

.pagination-nav .disabled {
    color: #d1d5db;
    background-color: #f3f4f6;
    cursor: not-allowed;
}

@media (max-width: 640px) {
    .pagination-container {
        padding: 1rem;
    }
    
    .pagination-container > div {
        flex-direction: column;
        gap: 1rem;
        text-align: center;
    }
    
    .pagination-nav a,
    .pagination-nav span {
        padding: 0.5rem 0.75rem;
        font-size: 0.75rem;
    }
}
</style>
@endsection