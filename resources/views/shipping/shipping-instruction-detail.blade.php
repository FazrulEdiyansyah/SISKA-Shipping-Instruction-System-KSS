@extends('layouts.app')

@section('title', 'Shipping Instruction Detail - SISKA')
@section('page-title', 'Shipping Instruction Detail')
@section('page-subtitle', 'View shipping instruction document details')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Back Button -->
    <div class="mb-4">
        <a href="{{ url('/shipping-instruction-overview') }}" 
           class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg transition duration-200 font-medium shadow-sm">
            <i class="fas fa-arrow-left mr-2"></i>
            Back
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-3 space-y-6">
            <!-- Document Information -->
            <div class="bg-white rounded-xl shadow-sm">
                <div class="p-6 border-b border-gray-200">
                    <h4 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-file-alt text-blue-500 mr-2"></i>
                        Document Information
                    </h4>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-2">Document Number</label>
                                <div class="bg-gray-50 p-3 rounded-lg border">
                                    <p class="text-lg text-gray-900">{{ $data['number'] ?? '-' }}</p>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-2">Addressed To</label>
                                <div class="bg-gray-50 p-3 rounded-lg border">
                                    <p class="text-gray-900">{{ $data['to'] ?? '-' }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-2">Place & Date</label>
                                <div class="bg-gray-50 p-3 rounded-lg border">
                                    <p class="text-gray-900">{{ $data['place_date'] ?? '-' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Vessel Information -->
            <div class="bg-white rounded-xl shadow-sm">
                <div class="p-6 border-b border-gray-200">
                    <h4 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-ship text-blue-500 mr-2"></i>
                        Vessel Information
                    </h4>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-2">Tugboat/Barge</label>
                            <div class="bg-gray-50 p-3 rounded-lg border">
                                <p class="text-gray-900">{{ $data['tugbarge'] ?? '-' }}</p>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-2">Flag State</label>
                            <div class="bg-gray-50 p-3 rounded-lg border">
                                <p class="text-gray-900">{{ $data['flag'] ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Parties Information -->
            <div class="bg-white rounded-xl shadow-sm">
                <div class="p-6 border-b border-gray-200">
                    <h4 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-users text-blue-500 mr-2"></i>
                        Parties Information
                    </h4>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-2">Shipper</label>
                                <div class="bg-gray-50 p-3 rounded-lg border">
                                    <p class="text-gray-900">{{ $data['shipper'] ?? '-' }}</p>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-2">Consignee</label>
                                <div class="bg-gray-50 p-3 rounded-lg border">
                                    <p class="text-gray-900">{{ $data['consignee'] ?? '-' }}</p>
                                </div>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-2">Notify Address</label>
                            <div class="bg-gray-50 p-3 rounded-lg border">
                                <p class="text-gray-900 whitespace-pre-line">{{ $data['notify_address'] ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Port & Route Information -->
            <div class="bg-white rounded-xl shadow-sm">
                <div class="p-6 border-b border-gray-200">
                    <h4 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-map-marker-alt text-blue-500 mr-2"></i>
                        Port & Route Information
                    </h4>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-2">Port of Loading</label>
                            <div class="bg-gray-50 p-3 rounded-lg border">
                                <p class="text-gray-900">{{ $data['port_loading'] ?? '-' }}</p>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-2">Port of Discharging</label>
                            <div class="bg-gray-50 p-3 rounded-lg border">
                                <p class="text-gray-900">{{ $data['port_discharging'] ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Cargo Information -->
            <div class="bg-white rounded-xl shadow-sm">
                <div class="p-6 border-b border-gray-200">
                    <h4 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-boxes text-blue-500 mr-2"></i>
                        Cargo Information
                    </h4>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-2">Commodities</label>
                            <div class="bg-gray-50 p-3 rounded-lg border">
                                <p class="text-gray-900">{{ $data['commodities'] ?? '-' }}</p>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-2">Quantity</label>
                            <div class="bg-gray-50 p-3 rounded-lg border">
                                <p class="text-gray-900">{{ $data['quantity'] ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Schedule Information -->
            <div class="bg-white rounded-xl shadow-sm">
                <div class="p-6 border-b border-gray-200">
                    <h4 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-calendar-alt text-blue-500 mr-2"></i>
                        Schedule Information
                    </h4>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-2">Laycan Period</label>
                            <div class="bg-blue-50 p-3 rounded-lg border-l-4 border-blue-400">
                                <p class="text-blue-900 font-medium">{{ $data['laycan'] ?? '-' }}</p>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-2">Laycan Start</label>
                            <div class="bg-gray-50 p-3 rounded-lg border">
                                <p class="text-gray-900">{{ $data['laycan_start'] ? \Carbon\Carbon::parse($data['laycan_start'])->format('d F Y') : '-' }}</p>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-2">Laycan End</label>
                            <div class="bg-gray-50 p-3 rounded-lg border">
                                <p class="text-gray-900">{{ $data['laycan_end'] ? \Carbon\Carbon::parse($data['laycan_end'])->format('d F Y') : '-' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SPAL Document -->
            <div class="bg-white rounded-xl shadow-sm">
                <div class="p-6 border-b border-gray-200">
                    <h4 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-file-contract text-blue-500 mr-2"></i>
                        SPAL Document
                    </h4>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-2">SPAL Number</label>
                            <div class="bg-gray-50 p-3 rounded-lg border">
                                <p class="text-gray-900">{{ $data['spal_number'] ?? '-' }}</p>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-2">SPAL Document</label>
                            <div class="bg-gray-50 p-3 rounded-lg border flex items-center gap-3">
                                <p class="text-gray-900 mb-0">
                                    {{ $data['spal_document'] ?? '-' }}
                                </p>
                                @if(!empty($data['spal_document']))
                                    <a href="{{ asset('storage/spal_documents/' . $data['spal_document']) }}" 
                                       class="inline-flex items-center px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 text-xs"
                                       download="SPAL-{{ $data['spal_number'] ?? 'document' }}.pdf">
                                    <i class="fas fa-download mr-1"></i> Download
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Signatory Information -->
            <div class="bg-white rounded-xl shadow-sm">
                <div class="p-6 border-b border-gray-200">
                    <h4 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-signature text-blue-500 mr-2"></i>
                        Signatory Information
                    </h4>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-2">Signed By</label>
                            <div class="bg-gray-50 p-3 rounded-lg border">
                                <p class="text-gray-900 font-semibold">{{ $data['signed_by'] ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1 space-y-6">
            <!-- Document Metadata -->
            <div class="bg-white rounded-xl shadow-sm h-fit sticky-sidebar-item">
                <div class="p-4 border-b border-gray-200">
                    <h4 class="text-base font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-info-circle text-blue-500 mr-2"></i>
                        Document Info
                    </h4>
                </div>
                <div class="p-4 space-y-3">
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-gray-500">Created:</span>
                        <span class="text-gray-900 font-medium">{{ $si->created_at->format('d M Y') }}</span>
                    </div>
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-gray-500">Updated:</span>
                        <span class="text-gray-900 font-medium">{{ $si->updated_at->format('d M Y') }}</span>
                    </div>
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-gray-500">Status:</span>
                        @if($si->spal_number && $si->spal_document)
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                <i class="fas fa-check-circle mr-1"></i>
                                Completed
                            </span>
                        @else
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                <i class="fas fa-clock mr-1"></i>
                                Only SI
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Document Actions -->
            <div class="bg-white rounded-xl shadow-sm h-fit sticky-sidebar-item" style="top: calc(1.5rem + 200px);">
                <div class="p-4 border-b border-gray-200">
                    <h4 class="text-base font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-cogs text-blue-500 mr-2"></i>
                        Actions
                    </h4>
                </div>
                <div class="p-4 space-y-3">
                    <a href="{{ url('/shipping-instruction/'.$si->id.'/pdf') }}" 
                       target="_blank"
                       class="w-full inline-flex items-center justify-center px-4 py-3 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition duration-200 shadow-sm">
                        <i class="fas fa-file-pdf mr-2"></i>
                        View PDF
                    </a>
                    <a href="{{ route('shipping-instruction.edit', $si->id) }}" 
                       class="w-full inline-flex items-center justify-center px-4 py-3 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition duration-200 shadow-sm">
                        <i class="fas fa-edit mr-2"></i>
                        Edit Document
                    </a>
                    <button onclick="confirmDelete({{ $si->id }})"
                            class="w-full inline-flex items-center justify-center px-4 py-3 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition duration-200 shadow-sm">
                        <i class="fas fa-trash mr-2"></i>
                        Delete Document
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center">
    <div class="bg-white rounded-xl p-6 max-w-md w-full mx-4">
        <div class="text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
                <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Delete Shipping Instruction</h3>
            <p class="text-sm text-gray-500 mb-6">Are you sure you want to delete this shipping instruction? This action cannot be undone.</p>
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
<div id="successAlert" class="fixed top-6 right-6 z-50 flex items-center max-w-md w-full px-4 py-3 rounded-lg bg-green-100 text-green-800 border border-green-200 shadow-lg">
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
/* Hapus animasi slideInRight dan slideOutRight pada notifikasi */
#successAlert {
    /* animation: slideInRight 0.3s ease-out; */
}

/* Hapus animasi hover pada .bg-white */
.bg-white:hover {
    /* transform: translateY(-1px); */
    /* box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1); */
    /* transition: all 0.3s ease; */
}

/* Sticky sidebar styles tetap */
.sticky-sidebar-item {
    position: sticky;
    top: 1.5rem;
    z-index: 10;
}

/* Responsive adjustments dan modal tetap */
@media (max-width: 768px) {
    .grid-cols-1.md\\:grid-cols-2 {
        grid-template-columns: 1fr;
    }
    .lg\\:col-span-4 {
        grid-column: span 1;
    }
    .sticky-sidebar-item {
        position: static;
    }
}
@media (min-width: 1024px) {
    .sticky-sidebar-item:first-child {
        top: 1.5rem;
    }
    .sticky-sidebar-item:last-child {
        top: calc(1.5rem + 220px);
    }
}
</style>

<script>
// Hapus animasi slideOutRight pada closeAlert
function closeAlert() {
    const alert = document.getElementById('successAlert');
    if (alert) {
        // alert.style.animation = 'slideOutRight 0.3s ease-in forwards';
        // setTimeout(() => {
        //     alert.remove();
        // }, 300);
        alert.remove();
    }
}

// Auto close notification setelah 5 detik tetap ada
document.addEventListener('DOMContentLoaded', function() {
    const successAlert = document.getElementById('successAlert');
    if (successAlert) {
        setTimeout(() => {
            closeAlert();
        }, 5000);
    }
});

function confirmDelete(id) {
    const modal = document.getElementById('deleteModal');
    const deleteForm = document.getElementById('deleteForm');
    if (modal) {
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        
        // Set the form action to the delete URL
        deleteForm.action = `/shipping-instruction-delete/${id}`;
    }
}

function closeDeleteModal() {
    const modal = document.getElementById('deleteModal');
    if (modal) {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
}
</script>
@endsection