@extends('layouts.app')

@section('title', 'Shipping Instruction Detail - SISKA')
@section('page-title', 'Shipping Instruction Detail')
@section('page-subtitle', 'View shipping instruction document details')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ url('/shipping-instruction-overview') }}" 
           class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg transition-colors duration-200 font-medium shadow-sm">
            <i class="fas fa-arrow-left mr-2"></i>
            Back to Overview
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
                    <p class="text-sm text-gray-600 mt-1">Basic document identification details</p>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-2">Document Number</label>
                                <div class="bg-gray-50 p-3 rounded-lg border">
                                    <p class="text-lg font-semibold text-gray-900">{{ $data['number'] ?? '-' }}</p>
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
                    <p class="text-sm text-gray-600 mt-1">Details about the vessel and its registration</p>
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
                    @if(($data['project_type'] ?? 'default') === 'sts')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-2">Vessel Name</label>
                            <div class="bg-blue-50 p-3 rounded-lg border border-blue-200">
                                <p class="text-blue-900 font-medium">{{ $data['vessel_name'] ?? '-' }}</p>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-2">Vessel Arrived</label>
                            <div class="bg-blue-50 p-3 rounded-lg border border-blue-200">
                                <div class="flex gap-3 items-center">
                                    <p class="text-blue-900 font-medium">
                                        {{ $data['vessel_arrived'] ? \Carbon\Carbon::parse($data['vessel_arrived'])->format('d F Y') : '-' }}
                                        @if(!empty($data['vessel_arrived_note']))
                                        <span class="text-blue-900 ml-2">{{ $data['vessel_arrived_note'] }}</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Parties Information -->
            <div class="bg-white rounded-xl shadow-sm">
                <div class="p-6 border-b border-gray-200">
                    <h4 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-users text-blue-500 mr-2"></i>
                        Parties Information
                    </h4>
                    <p class="text-sm text-gray-600 mt-1">Shipper, consignee, and notification details</p>
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
                    <p class="text-sm text-gray-600 mt-1">Loading and discharging port details</p>
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
                    <p class="text-sm text-gray-600 mt-1">Details about the cargo being shipped</p>
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
                    <p class="text-sm text-gray-600 mt-1">Scheduling and laycan period details</p>
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
                    <p class="text-sm text-gray-600 mt-1">SPAL number and document details</p>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-2">SPAL Number</label>
                            <div class="bg-gray-50 p-3 rounded-lg border">
                                <p class="text-gray-900 font-medium">{{ $data['spal_number'] ?? '-' }}</p>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-2">SPAL Document</label>
                            <div class="bg-gray-50 p-3 rounded-lg border flex items-center gap-3">
                                <p class="text-gray-900 mb-0 flex-1">
                                    {{ $data['spal_document'] ?? '-' }}
                                </p>
                                @if(!empty($data['spal_document']))
                                    <a href="{{ asset('storage/spal_documents/' . $data['spal_document']) }}" 
                                       class="inline-flex items-center px-3 py-1.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-xs font-medium transition-colors duration-200"
                                       download="SPAL-{{ $data['spal_number'] ?? 'document' }}.pdf">
                                        <i class="fas fa-download mr-1.5"></i>
                                        Download
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- MRA & RAB Document -->
            <div class="bg-white rounded-xl shadow-sm">
                <div class="p-6 border-b border-gray-200">
                    <h4 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-file-contract text-blue-500 mr-2"></i>
                        MRA & RAB Document
                    </h4>
                    <p class="text-sm text-gray-600 mt-1">Marine Risk Assessment and Risk Analysis document</p>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-2">MRA & RAB Document</label>
                            <div class="bg-gray-50 p-3 rounded-lg border flex items-center gap-3">
                                <p class="text-gray-900 mb-0 flex-1">
                                    {{ $data['mra_rab_document'] ?? '-' }}
                                </p>
                                @if(!empty($data['mra_rab_document']))
                                    <a href="{{ asset('storage/mra_rab_documents/' . $data['mra_rab_document']) }}" 
                                       class="inline-flex items-center px-3 py-1.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-xs font-medium transition-colors duration-200"
                                       download="MRA-RAB-{{ $data['number'] ?? 'document' }}.pdf">
                                        <i class="fas fa-download mr-1.5"></i>
                                        Download
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
                    <p class="text-sm text-gray-600 mt-1">Document signatory details</p>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-2">Signed By</label>
                            <div class="bg-gray-50 p-3 rounded-lg border">
                                <p class="text-gray-900">{{ $data['signed_by'] ?? '-' }}</p>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-2">Position</label>
                            <div class="bg-gray-50 p-3 rounded-lg border">
                                <p class="text-gray-900">{{ $data['position'] ?? '-' }}</p>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-2">Department</label>
                            <div class="bg-gray-50 p-3 rounded-lg border">
                                <p class="text-gray-900">{{ $data['department'] ?? '-' }}</p>
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
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                            {{ $si->status === 'Completed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                            <i class="fas {{ $si->status === 'Completed' ? 'fa-check-circle' : 'fa-exclamation-circle' }} mr-1.5"></i>
                            {{ $si->status }}
                        </span>
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
                       class="w-full inline-flex items-center justify-center px-4 py-3 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition-colors duration-200 shadow-sm">
                        <i class="fas fa-file-pdf mr-2"></i>
                        View PDF
                    </a>
                    <a href="{{ route('shipping-instruction.edit', $si->id) }}" 
                       class="w-full inline-flex items-center justify-center px-4 py-3 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors duration-200 shadow-sm">
                        <i class="fas fa-edit mr-2"></i>
                        Edit Document
                    </a>
                    <button onclick="confirmDelete({{ $si->id }})"
                            class="w-full inline-flex items-center justify-center px-4 py-3 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition-colors duration-200 shadow-sm">
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
                        class="flex-1 px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition-colors duration-200">
                    Cancel
                </button>
                <form id="deleteForm" method="POST" class="flex-1">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="w-full px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors duration-200">
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
/* Sticky sidebar styles */
.sticky-sidebar-item {
    position: sticky;
    top: 1.5rem;
    z-index: 10;
}

/* Responsive adjustments */
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

/* Enhanced visual elements */
.hover-card {
    transition: all 0.2s ease-in-out;
}

.hover-card:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

/* Document field enhancements */
.document-field {
    background: linear-gradient(145deg, #f8f9fa 0%, #e9ecef 100%);
    border-left: 3px solid #007bff;
}

.document-field p {
    margin: 0;
    color: #495057;
    font-weight: 500;
}

/* Status badge improvements */
.status-badge {
    display: inline-flex;
    align-items: center;
    font-weight: 600;
    padding: 0.375rem 0.75rem;
    border-radius: 0.5rem;
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.025em;
}

/* Button improvements */
.action-button {
    position: relative;
    overflow: hidden;
}

.action-button::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: left 0.5s;
}

.action-button:hover::before {
    left: 100%;
}

/* Enhanced download buttons */
.download-btn {
    background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
    box-shadow: 0 2px 4px rgba(0, 123, 255, 0.2);
}

.download-btn:hover {
    background: linear-gradient(135deg, #0056b3 0%, #004085 100%);
    box-shadow: 0 4px 8px rgba(0, 123, 255, 0.3);
    transform: translateY(-1px);
}

/* Card section improvements */
.info-card {
    background: linear-gradient(145deg, #ffffff 0%, #f8f9fa 100%);
    border: 1px solid #e9ecef;
    transition: all 0.3s ease;
}

.info-card:hover {
    border-color: #007bff;
    box-shadow: 0 4px 12px rgba(0, 123, 255, 0.1);
}

/* Vessel STS fields enhancement */
.sts-field {
    background: linear-gradient(145deg, #e3f2fd 0%, #bbdefb 100%);
    border: 1px solid #2196f3;
}

.sts-field p {
    color: #0d47a1;
    font-weight: 600;
}

/* Modal enhancements */
.modal-overlay {
    backdrop-filter: blur(4px);
}

.modal-content {
    background: linear-gradient(145deg, #ffffff 0%, #f8f9fa 100%);
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
}

/* Animation for success alert */
@keyframes slideInRight {
    from {
        opacity: 0;
        transform: translateX(100%);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

#successAlert {
    animation: slideInRight 0.3s ease-out;
}

/* Loading states */
.loading {
    position: relative;
    color: transparent;
}

.loading::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 16px;
    height: 16px;
    margin: -8px 0 0 -8px;
    border: 2px solid #f3f3f3;
    border-top: 2px solid #007bff;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Improved focus states */
button:focus,
a:focus {
    outline: 2px solid #007bff;
    outline-offset: 2px;
}

/* Dark mode support */
@media (prefers-color-scheme: dark) {
    .bg-gray-50 {
        background-color: #374151;
    }
    
    .text-gray-900 {
        color: #f9fafb;
    }
    
    .border-gray-200 {
        border-color: #4b5563;
    }
}
</style>

<script>
function closeAlert() {
    const alert = document.getElementById('successAlert');
    if (alert) {
        alert.style.animation = 'slideOutRight 0.3s ease-in forwards';
        setTimeout(() => {
            alert.remove();
        }, 300);
    }
}

// Auto close notification after 5 seconds
document.addEventListener('DOMContentLoaded', function() {
    const successAlert = document.getElementById('successAlert');
    if (successAlert) {
        setTimeout(() => {
            closeAlert();
        }, 5000);
    }
    
    // Add smooth scroll behavior
    document.documentElement.style.scrollBehavior = 'smooth';
    
    // Add loading states to action buttons
    const actionButtons = document.querySelectorAll('.action-button');
    actionButtons.forEach(button => {
        button.addEventListener('click', function() {
            if (this.href && !this.href.includes('#')) {
                this.classList.add('loading');
                this.style.pointerEvents = 'none';
            }
        });
    });
});

function confirmDelete(id) {
    const modal = document.getElementById('deleteModal');
    const deleteForm = document.getElementById('deleteForm');
    if (modal) {
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        modal.classList.add('modal-overlay');
        
        // Set the form action to the delete URL
        deleteForm.action = `/shipping-instruction-delete/${id}`;
        
        // Add modal animation
        const modalContent = modal.querySelector('.bg-white');
        modalContent.classList.add('modal-content');
        modalContent.style.animation = 'slideInDown 0.3s ease-out';
    }
}

function closeDeleteModal() {
    const modal = document.getElementById('deleteModal');
    if (modal) {
        const modalContent = modal.querySelector('.bg-white');
        modalContent.style.animation = 'slideOutUp 0.3s ease-in';
        
        setTimeout(() => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            modal.classList.remove('modal-overlay');
        }, 300);
    }
}

// Add slide animations for modal
const style = document.createElement('style');
style.textContent = `
    @keyframes slideInDown {
        from {
            opacity: 0;
            transform: translateY(-20px) scale(0.95);
        }
        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }
    
    @keyframes slideOutUp {
        from {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
        to {
            opacity: 0;
            transform: translateY(-20px) scale(0.95);
        }
    }
    
    @keyframes slideOutRight {
        from {
            opacity: 1;
            transform: translateX(0);
        }
        to {
            opacity: 0;
            transform: translateX(100%);
        }
    }
`;
document.head.appendChild(style);

// Keyboard shortcuts
document.addEventListener('keydown', function(e) {
    // ESC to close modal
    if (e.key === 'Escape') {
        closeDeleteModal();
        closeAlert();
    }
    
    // Ctrl+E to edit
    if (e.ctrlKey && e.key === 'e') {
        e.preventDefault();
        const editButton = document.querySelector('a[href*="edit"]');
        if (editButton) editButton.click();
    }
    
    // Ctrl+P to view PDF
    if (e.ctrlKey && e.key === 'p') {
        e.preventDefault();
        const pdfButton = document.querySelector('a[href*="pdf"]');
        if (pdfButton) pdfButton.click();
    }
});

// Add tooltips for action buttons
document.addEventListener('DOMContentLoaded', function() {
    const actionButtons = document.querySelectorAll('[title]');
    actionButtons.forEach(button => {
        button.addEventListener('mouseenter', function() {
            const tooltip = document.createElement('div');
            tooltip.className = 'tooltip';
            tooltip.textContent = this.title;
            tooltip.style.cssText = `
                position: absolute;
                background: #333;
                color: white;
                padding: 4px 8px;
                border-radius: 4px;
                font-size: 12px;
                z-index: 1000;
                pointer-events: none;
                opacity: 0;
                transition: opacity 0.2s;
            `;
            document.body.appendChild(tooltip);
            
            const rect = this.getBoundingClientRect();
            tooltip.style.left = rect.left + (rect.width / 2) - (tooltip.offsetWidth / 2) + 'px';
            tooltip.style.top = rect.bottom + 5 + 'px';
            
            setTimeout(() => tooltip.style.opacity = '1', 10);
            
            this.addEventListener('mouseleave', function() {
                tooltip.remove();
            }, { once: true });
        });
    });
});
</script>
@endsection