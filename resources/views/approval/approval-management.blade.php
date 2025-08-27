@extends('layouts.app')

@section('title', 'Approval Management - SISKA')
@section('page-title', 'Approval Management')
@section('page-subtitle', 'Manage authorized signatories for shipping instruction documents')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header Section -->
    <div class="bg-white rounded-xl shadow-sm mb-6">
        <div class="p-6 border-b border-gray-200">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                <div>
                    <h3 class="text-2xl font-bold text-gray-900">Approval Management</h3>
                    <p class="text-gray-600 mt-1">Manage authorized signatories and departments for shipping instruction documents</p>
                </div>
                <div class="flex flex-col sm:flex-row gap-3">
                    <button onclick="openAddDepartmentModal()" 
                        class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white rounded-lg font-medium transition duration-200 flex items-center justify-center">
                        <i class="fas fa-building mr-2"></i>
                        Add Department
                    </button>
                    <button onclick="openAddModal()" 
                        class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition duration-200 flex items-center justify-center">
                        <i class="fas fa-user-plus mr-2"></i>
                        Add Signatory
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <!-- Total Signatories -->
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium">Total Signatories</p>
                    <p class="text-3xl font-bold">{{ count($signatories) }}</p>
                    <p class="text-blue-200 text-xs mt-1">Authorized personnel</p>
                </div>
                <div class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center">
                    <i class="fas fa-users text-xl"></i>
                </div>
            </div>
        </div>
        
        <!-- Total Departments -->
        <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-xl p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm font-medium">Total Departments</p>
                    <p class="text-3xl font-bold">{{ count($departments) }}</p>
                    <p class="text-green-200 text-xs mt-1">Organizational units</p>
                </div>
                <div class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center">
                    <i class="fas fa-building text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Search Section -->
    <div class="bg-white rounded-xl shadow-sm mb-6">
        <div class="p-6">
            <div class="flex flex-col lg:flex-row gap-4">
                <div class="flex-1">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                        <input type="text" id="searchInput" 
                               placeholder="Search by name, position, or department..." 
                               class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200">
                    </div>
                </div>
                <div class="flex gap-3">
                    <select id="departmentFilter" 
                        class="px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 min-w-[160px]">
                        <option value="">All Departments</option>
                        @foreach($departments as $department)
                            <option value="{{ $department->name }}">{{ $department->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        <!-- Authorized Signatories Table -->
        <div class="xl:col-span-2">
            <div class="bg-white rounded-xl shadow-sm">
                <div class="p-6 border-b border-gray-200">
                    <h4 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-signature text-blue-500 mr-2"></i>
                        Authorized Signatories
                    </h4>
                    <p class="text-sm text-gray-600 mt-1">Personnel authorized to sign documents</p>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full" id="signatoryTable">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Name</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Position</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Department</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($signatories as $signatory)
                            <tr class="hover:bg-gray-50 transition duration-200">
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                                <span class="text-blue-600 font-medium text-sm">
                                                    {{ \Illuminate\Support\Str::of($signatory->name)->split('/\s+/')->map(fn($w) => $w[0])->join('') }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $signatory->name }}</div>
                                            <div class="text-sm text-gray-500">Added {{ $signatory->created_at->format('d M Y') }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                        @if(in_array($signatory->position, ['Direktur', 'Direktur Utama'])) bg-purple-100 text-purple-800
                                        @elseif(in_array($signatory->position, ['VP', 'Manager'])) bg-green-100 text-green-800
                                        @else bg-blue-100 text-blue-800
                                        @endif">
                                        {{ $signatory->position }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900">
                                        {{ $signatory->department->name ?? '-' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-2">
                                        <button onclick="editSignatory(this)" 
                                            data-id="{{ $signatory->id }}"
                                            data-name="{{ $signatory->name }}"
                                            data-position="{{ $signatory->position }}"
                                            data-department="{{ $signatory->department_id ?? '' }}"
                                            class="inline-flex items-center px-3 py-1.5 bg-blue-50 text-blue-700 text-xs font-medium rounded-lg hover:bg-blue-100 transition duration-200 border border-blue-200"
                                            title="Edit Signatory">
                                            <i class="fas fa-edit mr-1"></i>
                                            Edit
                                        </button>
                                        <button onclick="confirmDeleteSignatory({{ $signatory->id }})" 
                                            class="inline-flex items-center px-3 py-1.5 bg-red-50 text-red-700 text-xs font-medium rounded-lg hover:bg-red-100 transition duration-200 border border-red-200"
                                            title="Delete Signatory">
                                            <i class="fas fa-trash mr-1"></i>
                                            Delete
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center">
                                        <i class="fas fa-users text-4xl text-gray-300 mb-3"></i>
                                        <h3 class="text-lg font-medium text-gray-900 mb-1">No Signatories Found</h3>
                                        <p class="text-gray-500">Get started by adding your first signatory.</p>
                                        <button onclick="openAddModal()" 
                                            class="mt-4 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200">
                                            <i class="fas fa-plus mr-2"></i>
                                            Add Signatory
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

        <!-- Departments Sidebar -->
        <div class="xl:col-span-1">
            <div class="bg-white rounded-xl shadow-sm">
                <div class="p-6 border-b border-gray-200">
                    <h4 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-building text-green-500 mr-2"></i>
                        Departments
                    </h4>
                    <p class="text-sm text-gray-600 mt-1">Organizational departments</p>
                </div>
                <div class="p-6">
                    <div class="space-y-3 max-h-96 overflow-y-auto">
                        @forelse($departments as $department)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition duration-200">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mr-3">
                                    <i class="fas fa-building text-green-600 text-sm"></i>
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-gray-900">{{ $department->name }}</div>
                                    <div class="text-xs text-gray-500">
                                        {{ $signatories->where('department_id', $department->id)->count() }} signatory(s)
                                    </div>
                                </div>
                            </div>
                            <div class="flex space-x-1">
                                <button onclick="confirmDeleteDepartment({{ $department->id }})" 
                                    class="text-red-600 hover:text-red-900 p-1 rounded hover:bg-red-50 transition-colors duration-200"
                                    title="Delete Department">
                                    <i class="fas fa-trash text-sm"></i>
                                </button>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-8">
                            <i class="fas fa-building text-3xl text-gray-300 mb-3"></i>
                            <p class="text-gray-500 text-sm">No departments found</p>
                            <button onclick="openAddDepartmentModal()" 
                                class="mt-3 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition duration-200 text-sm">
                                <i class="fas fa-plus mr-1"></i>
                                Add Department
                            </button>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add/Edit Signatory Modal -->
<div id="signatoryModal" class="fixed inset-0 z-50 bg-black bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-lg mx-4 max-h-[90vh] overflow-y-auto">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 id="modalTitle" class="text-xl font-semibold text-gray-900">Add New Signatory</h3>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600 transition duration-200">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
        </div>
        
        <form id="signatoryForm" method="POST" action="{{ route('signatories.store') }}">
            @csrf
            <div id="methodField"></div>
            <div class="p-6 space-y-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Full Name *</label>
                    <input type="text" id="fullName" name="full_name" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200"
                        placeholder="e.g., Miftahul A.N. Basori">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Position *</label>
                    <select id="position" name="position" onchange="toggleDepartmentField()" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200">
                        <option value="">Select Position</option>
                        <option value="Supervisor">Supervisor</option>
                        <option value="Ass Manager">Ass Manager</option>
                        <option value="Manager">Manager</option>
                        <option value="VP">VP</option>
                        <option value="Direktur">Direktur</option>
                        <option value="Direktur Utama">Direktur Utama</option>
                    </select>
                </div>
                
                <div id="departmentField">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Department <span class="text-red-500" id="departmentRequired">*</span>
                    </label>
                    <select id="department" name="department"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200">
                        <option value="">Select Department</option>
                        @foreach($departments as $department)
                            <option value="{{ $department->id }}">{{ $department->name }}</option>
                        @endforeach
                    </select>
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
                    Save Signatory
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Add Department Modal -->
<div id="departmentModal" class="fixed inset-0 z-50 bg-black bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-md mx-4">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 class="text-xl font-semibold text-gray-900">Add New Department</h3>
                <button onclick="closeDepartmentModal()" class="text-gray-400 hover:text-gray-600 transition duration-200">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
        </div>
        
        <form id="departmentForm" method="POST" action="{{ route('departments.store') }}">
            @csrf
            <div class="p-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Department Name *</label>
                    <input type="text" id="departmentName" name="department_name" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200"
                        placeholder="e.g., Human Resources">
                </div>
            </div>
            
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end space-x-3 rounded-b-xl">
                <button type="button" onclick="closeDepartmentModal()" 
                    class="px-6 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition duration-200 font-medium">
                    Cancel
                </button>
                <button type="submit" 
                    class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition duration-200 font-medium">
                    <i class="fas fa-save mr-2"></i>
                    Save Department
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Delete Signatory Confirmation Modal -->
<div id="deleteSignatoryModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center">
    <div class="bg-white rounded-xl p-6 max-w-md w-full mx-4">
        <div class="text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
                <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Delete Signatory</h3>
            <p class="text-sm text-gray-500 mb-6">Are you sure you want to delete this signatory? This action cannot be undone.</p>
            <div class="flex space-x-3">
                <button onclick="closeDeleteSignatoryModal()" 
                        class="flex-1 px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition">
                    Cancel
                </button>
                <form id="deleteSignatoryForm" method="POST" class="flex-1">
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

<!-- Delete Department Confirmation Modal -->
<div id="deleteDepartmentModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center">
    <div class="bg-white rounded-xl p-6 max-w-md w-full mx-4">
        <div class="text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
                <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Delete Department</h3>
            <p class="text-sm text-gray-500 mb-6">Are you sure you want to delete this department? This action cannot be undone.</p>
            <div class="flex space-x-3">
                <button onclick="closeDeleteDepartmentModal()" 
                        class="flex-1 px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition">
                    Cancel
                </button>
                <form id="deleteDepartmentForm" method="POST" class="flex-1">
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
/* Custom scrollbar untuk departments sidebar */
.overflow-y-auto::-webkit-scrollbar {
    width: 4px;
}

.overflow-y-auto::-webkit-scrollbar-track {
    background: #f1f5f9;
    border-radius: 4px;
}

.overflow-y-auto::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 4px;
}

.overflow-y-auto::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
}

/* Animation untuk modal */
#signatoryModal, #departmentModal, #deleteSignatoryModal, #deleteDepartmentModal {
    animation: fadeIn 0.3s ease-out;
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
    document.getElementById('modalTitle').textContent = 'Add New Signatory';
    document.getElementById('signatoryForm').reset();
    document.getElementById('methodField').innerHTML = '';
    document.getElementById('signatoryForm').action = '{{ route("signatories.store") }}';
    document.getElementById('signatoryModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
    toggleDepartmentField();
    setTimeout(() => {
        document.getElementById('fullName').focus();
    }, 200);
}

function editSignatory(btn) {
    document.getElementById('modalTitle').textContent = 'Edit Signatory';
    document.getElementById('fullName').value = btn.getAttribute('data-name');
    document.getElementById('position').value = btn.getAttribute('data-position');
    document.getElementById('department').value = btn.getAttribute('data-department');
    document.getElementById('methodField').innerHTML = '@method("PUT")';
    document.getElementById('signatoryForm').action = `/signatories/${btn.getAttribute('data-id')}`;
    document.getElementById('signatoryModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
    toggleDepartmentField();
}

function closeModal() {
    document.getElementById('signatoryModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

function openAddDepartmentModal() {
    document.getElementById('departmentForm').reset();
    document.getElementById('departmentModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
    setTimeout(() => {
        document.getElementById('departmentName').focus();
    }, 200);
}

function closeDepartmentModal() {
    document.getElementById('departmentModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

function toggleDepartmentField() {
    const positionSelect = document.getElementById('position');
    const departmentField = document.getElementById('departmentField');
    const departmentSelect = document.getElementById('department');
    const departmentRequired = document.getElementById('departmentRequired');
    
    if (positionSelect.value === 'Direktur' || positionSelect.value === 'Direktur Utama') {
        departmentField.style.display = 'none';
        departmentSelect.removeAttribute('required');
        departmentRequired.style.display = 'none';
        departmentSelect.value = '';
    } else {
        departmentField.style.display = 'block';
        departmentSelect.setAttribute('required', 'required');
        departmentRequired.style.display = 'inline';
    }
}

// Delete Signatory Functions
function confirmDeleteSignatory(id) {
    const modal = document.getElementById('deleteSignatoryModal');
    const deleteForm = document.getElementById('deleteSignatoryForm');
    if (modal) {
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        
        // Set the form action to the delete URL
        deleteForm.action = `/signatories/${id}`;
    }
}

function closeDeleteSignatoryModal() {
    const modal = document.getElementById('deleteSignatoryModal');
    if (modal) {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
}

// Delete Department Functions
function confirmDeleteDepartment(id) {
    const modal = document.getElementById('deleteDepartmentModal');
    const deleteForm = document.getElementById('deleteDepartmentForm');
    if (modal) {
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        
        // Set the form action to the delete URL
        deleteForm.action = `/departments/${id}`;
    }
}

function closeDeleteDepartmentModal() {
    const modal = document.getElementById('deleteDepartmentModal');
    if (modal) {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
}

// Search and filter functionality
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const departmentFilter = document.getElementById('departmentFilter');
    
    function filterTable() {
        const searchTerm = searchInput.value.toLowerCase();
        const selectedDepartment = departmentFilter.value.toLowerCase();
        const rows = document.querySelectorAll('#signatoryTable tbody tr');
        
        rows.forEach(row => {
            if (row.querySelector('td') && row.querySelector('td').getAttribute('colspan')) {
                return; // Skip empty state row
            }
            
            const name = row.cells[0].textContent.toLowerCase();
            const position = row.cells[1].textContent.toLowerCase();
            const department = row.cells[2].textContent.toLowerCase();
            
            const matchesSearch = name.includes(searchTerm) || position.includes(searchTerm) || department.includes(searchTerm);
            const matchesDepartment = !selectedDepartment || department.includes(selectedDepartment);
            
            if (matchesSearch && matchesDepartment) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }
    
    searchInput.addEventListener('input', filterTable);
    departmentFilter.addEventListener('change', filterTable);
});

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