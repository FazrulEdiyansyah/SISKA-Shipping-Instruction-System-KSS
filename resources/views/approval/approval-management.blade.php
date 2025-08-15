@extends('layouts.app')

@section('title', 'Approval Management - SISKA')
@section('page-title', 'Approval Management')
@section('page-subtitle', 'Manage authorized signatories for shipping instruction documents')

@section('content')
<div class="max-w-6xl mx-auto">
    <!-- Header Section -->
    <div class="bg-white rounded-xl shadow-sm mb-6">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-xl font-bold text-gray-900">Approval Management</h3>
                    <p class="text-sm text-gray-600 mt-1">Manage authorized signatories for shipping instruction documents</p>
                </div>
                <div class="flex items-center gap-3">
                    <button onclick="openAddDepartmentModal()" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition duration-200 flex items-center">
                        <i class="fas fa-plus mr-2"></i>
                        Add New Department
                    </button>
                    <button onclick="openAddModal()" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition duration-200 flex items-center">
                        <i class="fas fa-plus mr-2"></i>
                        Add New Signatory
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
                    <p class="text-blue-100 text-sm">Total Signatories</p>
                    <p class="text-2xl font-bold">8</p>
                </div>
                <div class="w-10 h-10 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                    <i class="fas fa-users"></i>
                </div>
            </div>
        </div>
        <!-- Departments -->
        <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-xl p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm">Departments</p>
                    <p class="text-2xl font-bold">4</p>
                </div>
                <div class="w-10 h-10 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                    <i class="fas fa-building"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filter -->
    <div class="bg-white rounded-xl shadow-sm mb-6">
        <div class="p-6">
            <div class="flex flex-col sm:flex-row gap-4">
                <div class="flex-1">
                    <div class="relative">
                        <input type="text" placeholder="Search by name or position..." class="w-full px-4 py-3 pl-10 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <i class="fas fa-search absolute left-3 top-4 text-gray-400"></i>
                    </div>
                </div>
                <div class="flex gap-3">
                    <select class="px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 min-w-[140px]">
                        <option>All Departments</option>
                        <option>Management</option>
                        <option>Operations</option>
                        <option>Procurement</option>
                        <option>Finance</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Signatories & Departments Table (Side by Side) -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Authorized Signatories Table -->
        <div class="bg-white rounded-xl shadow-sm">
            <div class="p-6 border-b">
                <h3 class="text-lg font-semibold text-gray-800">Authorized Signatories</h3>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @forelse($signatories ?? [] as $signatory)
                    <div class="flex items-center justify-between py-2 border-b border-gray-100">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center mr-4">
                                <span class="text-white font-medium text-sm">{{ \Illuminate\Support\Str::of($signatory->name)->split('/\s+/')->map(fn($w) => $w[0])->join('') }}</span>
                            </div>
                            <div>
                                <div class="text-sm font-medium text-gray-900">{{ $signatory->name }}</div>
                                <div class="text-xs text-gray-500">{{ $signatory->position }}</div>
                                <span class="inline-block px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs mt-1">{{ $signatory->department->name ?? 'No Department' }}</span>
                            </div>
                        </div>
                        <div class="flex space-x-1">
                            <button onclick="editSignatory({{ $signatory->id }})" class="text-blue-600 hover:text-blue-900 p-1 rounded hover:bg-blue-50 transition-colors duration-200">
                                <i class="fas fa-edit text-sm"></i>
                            </button>
                            <button onclick="deleteSignatory({{ $signatory->id }})" class="text-red-600 hover:text-red-900 p-1 rounded hover:bg-red-50 transition-colors duration-200">
                                <i class="fas fa-trash text-sm"></i>
                            </button>
                        </div>
                    </div>
                    @empty
                    <p class="text-gray-500">No signatories found.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Departments Table -->
        <div class="bg-white rounded-xl shadow-sm">
            <div class="p-6 border-b">
                <h3 class="text-lg font-semibold text-gray-800">Departments</h3>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @forelse($departments ?? [] as $department)
                    <div class="flex items-center justify-between py-2">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center mr-3">
                                <i class="fas fa-building text-gray-500 text-sm"></i>
                            </div>
                            <span class="text-sm text-gray-600">{{ is_object($department) ? $department->name : $department }}</span>
                        </div>
                        <div class="flex space-x-1">
                            <button class="text-blue-600 hover:text-blue-900 p-1 rounded hover:bg-blue-50 transition-colors duration-200">
                                <i class="fas fa-edit text-sm"></i>
                            </button>
                            <button class="text-red-600 hover:text-red-900 p-1 rounded hover:bg-red-50 transition-colors duration-200">
                                <i class="fas fa-trash text-sm"></i>
                            </button>
                        </div>
                    </div>
                    @empty
                    <p class="text-gray-500">No departments found.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
    <!-- End Signatories & Departments Table (Side by Side) -->
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

<!-- Add/Edit Signatory Modal -->
<div id="signatoryModal" class="fixed inset-0 z-40 flex items-center justify-center bg-black bg-opacity-40 hidden">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-lg mx-4 relative">
        <!-- Modal Header -->
        <div class="flex items-center justify-between px-8 pt-8 pb-4 border-b">
            <h2 class="text-2xl font-bold" id="modalTitle">Add New Signatory</h2>
            <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600 transition">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <!-- Modal Body -->
        <form id="signatoryForm" method="POST" action="{{ route('signatories.store') }}" class="px-8 pt-6 pb-4">
            @csrf
            <div class="mb-5">
                <label for="fullName" class="block text-base font-semibold mb-2">Full Name <span class="text-red-500">*</span></label>
                <input type="text" id="fullName" name="full_name" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 placeholder-gray-400"
                    placeholder="e.g., Miftahul A.N. Basori">
            </div>
            <div class="mb-5">
                <label for="position" class="block text-base font-semibold mb-2">Position <span class="text-red-500">*</span></label>
                <select id="position" name="position" onchange="toggleDepartmentField()" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Select Position</option>
                    <option value="Supervisor">Supervisor</option>
                    <option value="Ass Manager">Ass Manager</option>
                    <option value="Manager">Manager</option>
                    <option value="VP">VP</option>
                    <option value="Direktur">Direktur</option>
                    <option value="Direktur Utama">Direktur Utama</option>
                </select>
            </div>
            <div class="mb-5" id="departmentField">
                <label for="department" class="block text-base font-semibold mb-2">Department <span class="text-red-500" id="departmentRequired">*</span></label>
                <select id="department" name="department"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Select Department</option>
                    @foreach($departments ?? [] as $department)
                        <option value="{{ $department->id }}">{{ $department->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex justify-end gap-3 mt-8">
                <button type="button" onclick="closeModal()" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">Cancel</button>
                <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold">Add Signatory</button>
            </div>
        </form>
    </div>
</div>

<!-- Add Department Modal -->
<div id="departmentModal" class="fixed inset-0 z-40 flex items-center justify-center bg-black bg-opacity-40 hidden">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-lg mx-4 relative">
        <!-- Modal Header -->
        <div class="flex items-center justify-between px-8 pt-8 pb-4 border-b">
            <h2 class="text-2xl font-bold">Add New Department</h2>
            <button onclick="closeDepartmentModal()" class="text-gray-400 hover:text-gray-600 transition">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <!-- Modal Body -->
        <form id="departmentForm" method="POST" action="{{ route('departments.store') }}" class="px-8 pt-6 pb-4">
            @csrf
            <div class="mb-5">
                <label for="departmentName" class="block text-base font-semibold mb-2">Department Name <span class="text-red-500">*</span></label>
                <input type="text" id="departmentName" name="department_name" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 placeholder-gray-400"
                    placeholder="e.g., Human Resources">
            </div>
            <div class="flex justify-end gap-3 mt-8">
                <button type="button" onclick="closeDepartmentModal()" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">Cancel</button>
                <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold">Add Department</button>
            </div>
        </form>
    </div>
</div>

<script>
function openAddModal() {
    document.getElementById('modalTitle').textContent = 'Add New Signatory';
    document.getElementById('signatoryForm').reset();
    document.getElementById('signatoryModal').classList.remove('hidden');
    toggleDepartmentField();
    setTimeout(() => {
        document.getElementById('fullName').focus();
    }, 200);
}

function closeModal() {
    document.getElementById('signatoryModal').classList.add('hidden');
}

function openAddDepartmentModal() {
    document.getElementById('departmentForm').reset();
    document.getElementById('departmentModal').classList.remove('hidden');
    setTimeout(() => {
        document.getElementById('departmentName').focus();
    }, 200);
}

function closeDepartmentModal() {
    document.getElementById('departmentModal').classList.add('hidden');
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

function editSignatory(id) {
    alert('Edit signatory: ' + id);
}

function deleteSignatory(id) {
    if (confirm('Are you sure you want to delete this signatory?')) {
        alert('Delete signatory: ' + id);
    }
}
</script>
@endsection