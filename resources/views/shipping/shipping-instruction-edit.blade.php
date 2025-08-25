@extends('layouts.app')

@section('title', 'Edit Shipping Instruction - SISKA')
@section('page-title', 'Edit Shipping Instruction')
@section('page-subtitle', 'Update shipping instruction document details')

@section('content')
<div class="max-w-6xl mx-auto">
    <!-- Back Button -->
    <div class="mb-4">
        <a href="{{ route('shipping-instruction.detail', $si->id) }}" 
           class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg transition duration-200 font-medium shadow-sm">
            <i class="fas fa-arrow-left mr-2"></i>
            Back to Detail
        </a>
    </div>

    <!-- Form Section -->
    <form method="POST" action="{{ route('shipping-instruction.update', $si->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <!-- Basic Information -->
        <div class="bg-white rounded-xl shadow-sm mb-6">
            <div class="p-6 border-b border-gray-200">
                <h4 class="text-lg font-semibold text-gray-900 flex items-center">
                    <i class="fas fa-file-alt text-blue-500 mr-2"></i>
                    Document Information
                </h4>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Document Number (Read Only) -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">Document Number</label>
                        <input type="text" id="docNumberInput" name="number" value="{{ $si->number }}" readonly
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-50 text-gray-600">
                    </div>
                    
                    <!-- Place & Date -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">Place & Date Document *</label>
                        <div class="flex gap-2">
                            <input type="text" name="place" value="{{ $si->place }}"
                                class="w-1/2 px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="e.g., Cilegon" required>
                            <input type="date" name="date" value="{{ $si->date }}"
                                class="w-1/2 px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                required>
                        </div>
                    </div>
                    
                    <!-- Addressed To -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">Addressed To *</label>
                        <select name="to" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @foreach($vendors as $vendor)
                                <option value="{{ $vendor->company }}" {{ $si->to == $vendor->company ? 'selected' : '' }}>
                                    {{ $vendor->company }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Vessel Information -->
        <div class="bg-white rounded-xl shadow-sm mb-6">
            <div class="p-6 border-b border-gray-200">
                <h4 class="text-lg font-semibold text-gray-900 flex items-center">
                    <i class="fas fa-ship text-blue-500 mr-2"></i>
                    Vessel Information
                </h4>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">Tugbarge *</label>
                        <input type="text" name="tugbarge" value="{{ $si->tugbarge }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="e.g., KSS BARGE 019" required>
                    </div>
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">Flag *</label>
                        <input type="text" name="flag" value="{{ $si->flag }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="e.g., Indonesia" required>
                    </div>
                </div>
            </div>
        </div>

        <!-- Parties Information -->
        <div class="bg-white rounded-xl shadow-sm mb-6">
            <div class="p-6 border-b border-gray-200">
                <h4 class="text-lg font-semibold text-gray-900 flex items-center">
                    <i class="fas fa-users text-blue-500 mr-2"></i>
                    Parties Information
                </h4>
            </div>
            <div class="p-6">
                <div class="space-y-6">
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">Shipper *</label>
                        <textarea name="shipper" rows="3"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Company name and address" required>{{ $si->shipper }}</textarea>
                    </div>
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">Consignee *</label>
                        <textarea name="consignee" rows="3"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Company name and address" required>{{ $si->consignee }}</textarea>
                    </div>
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">Notify Address *</label>
                        <textarea name="notify_address" rows="3"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Notification address" required>{{ $si->notify_address }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- Port & Route Information -->
        <div class="bg-white rounded-xl shadow-sm mb-6">
            <div class="p-6 border-b border-gray-200">
                <h4 class="text-lg font-semibold text-gray-900 flex items-center">
                    <i class="fas fa-anchor text-blue-500 mr-2"></i>
                    Port & Route Information
                </h4>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">Port of Loading *</label>
                        <input type="text" name="port_loading" value="{{ $si->port_loading }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="e.g., Jetty Patratani, Muara Enim, Indonesia" required>
                    </div>
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">Port of Discharging *</label>
                        <input type="text" name="port_discharging" value="{{ $si->port_discharging }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="e.g., PLTU Palton Unit 7-8" required>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cargo Information -->
        <div class="bg-white rounded-xl shadow-sm mb-6">
            <div class="p-6 border-b border-gray-200">
                <h4 class="text-lg font-semibold text-gray-900 flex items-center">
                    <i class="fas fa-boxes text-blue-500 mr-2"></i>
                    Cargo Information
                </h4>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">Commodities *</label>
                        <input type="text" name="commodities" value="{{ $si->commodities }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="e.g., Indonesian Steam Coal in Bulk" required>
                    </div>
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">Quantity *</label>
                        <input type="text" name="quantity" value="{{ $si->quantity }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="e.g., 8.500 MT +/- 10%" required>
                    </div>
                </div>
            </div>
        </div>

        <!-- Schedule Information -->
        <div class="bg-white rounded-xl shadow-sm mb-6">
            <div class="p-6 border-b border-gray-200">
                <h4 class="text-lg font-semibold text-gray-900 flex items-center">
                    <i class="fas fa-calendar-alt text-blue-500 mr-2"></i>
                    Schedule Information
                </h4>
            </div>
            <div class="p-6">
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700">Laycan Period *</label>
                    <div class="flex items-center gap-2">
                        <input type="date" name="laycan_start" value="{{ $si->laycan_start }}"
                            class="w-1/2 px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required>
                        <span class="flex items-center px-2">to</span>
                        <input type="date" name="laycan_end" value="{{ $si->laycan_end }}"
                            class="w-1/2 px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required>
                    </div>
                </div>
            </div>
        </div>

        <!-- SPAL Information -->
        <div class="bg-white rounded-xl shadow-sm mb-6">
            <div class="p-6 border-b border-gray-200">
                <h4 class="text-lg font-semibold text-gray-900 flex items-center">
                    <i class="fas fa-file-invoice text-blue-500 mr-2"></i>
                    SPAL Information
                </h4>
                <p class="text-sm text-gray-600 mt-1">Add SPAL details to complete the shipping instruction</p>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- SPAL Number -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">SPAL Number</label>
                        <input type="text" name="spal_number" value="{{ $si->spal_number }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="e.g., SPAL/001/2025">
                        <p class="text-xs text-gray-500">Enter the SPAL document number</p>
                    </div>
                    
                    <!-- Current SPAL Document -->
                    @if($si->spal_document)
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">Current SPAL Document</label>
                        <div class="flex items-center space-x-3">
                            <a href="{{ asset('storage/spal_documents/' . $si->spal_document) }}" target="_blank"
                               class="inline-flex items-center px-3 py-2 bg-blue-100 text-blue-800 rounded-lg text-sm hover:bg-blue-200">
                                <i class="fas fa-file-pdf mr-2"></i>
                                View Current SPAL
                            </a>
                        </div>
                    </div>
                    @endif
                </div>
                
                <!-- Upload New SPAL Document -->
                <div class="mt-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        {{ $si->spal_document ? 'Replace SPAL Document' : 'Upload SPAL Document' }}
                    </label>
                    <input type="file" name="spal_document" accept=".pdf"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <p class="text-xs text-gray-500 mt-1">Upload PDF document (Max: 10MB)</p>
                </div>
            </div>
        </div>

        <!-- Signatory Information -->
        <div class="bg-white rounded-xl shadow-sm mb-6">
            <div class="p-6 border-b border-gray-200">
                <h4 class="text-lg font-semibold text-gray-900 flex items-center">
                    <i class="fas fa-signature text-blue-500 mr-2"></i>
                    Signatory (Tanda Tangan Dokumen)
                </h4>
                <p class="text-sm text-gray-600 mt-1">Person who will sign the document</p>
            </div>
            <div class="p-6">
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700">Signatory *</label>
                    <select name="signed_by" id="signatorySelect"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                        required>
                        <option value="">-- Select Signatory --</option>
                        @foreach($signatories as $signatory)
                            <option value="{{ $signatory->id }}"
                                data-position="{{ $signatory->position }}"
                                data-department="{{ $signatory->department->name ?? '' }}"
                                {{ (old('signed_by', $si->signed_by) == $signatory->id) ? 'selected' : '' }}>
                                {{ $signatory->name }}
                            </option>
                        @endforeach
                    </select>
                    <input type="hidden" name="position" id="signatoryPosition"
                        value="{{ old('position', $si->position) }}">
                    <input type="hidden" name="department" id="signatoryDepartment"
                        value="{{ old('department', $si->department) }}">
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="bg-white rounded-xl shadow-sm mb-6">
            <div class="p-6">
                <div class="flex flex-col sm:flex-row justify-between items-center space-y-4 sm:space-y-0 sm:space-x-4">
                    <div class="flex items-center text-sm text-gray-600">
                        <i class="fas fa-info-circle text-blue-500 mr-2"></i>
                        <span>Complete SPAL information to change status to "Completed"</span>
                    </div>
                    <div class="flex flex-wrap gap-4">
                        <button type="submit"
                            class="px-8 py-3 bg-gradient-to-r from-green-400 to-green-600 hover:from-green-500 hover:to-green-700 text-white rounded-lg transition duration-200 font-medium shadow-lg">
                            <i class="fas fa-save mr-2"></i>
                            Update Shipping Instruction
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const vendorInput = document.querySelector('select[name="to"]');
    const docNumberInput = document.getElementById('docNumberInput');
    if (vendorInput && docNumberInput) {
        vendorInput.addEventListener('change', function() {
            const vendor = vendorInput.value;
            if (vendor.length > 0) {
                // Ambil nomor SI lama
                const oldNumber = docNumberInput.value;
                // Ambil 3 digit urut, bulan, tahun dari nomor lama
                const match = oldNumber.match(/^(\d{3})\/SI\/KSS-[^\/]+\/([IVXLCDM]+)\/(\d{4})$/);
                if (match) {
                    const urut = match[1];
                    const bulan = match[2];
                    const tahun = match[3];
                    // Hitung inisial vendor baru
                    fetch('/shipping-instruction/generate-number', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ vendor })
                    })
                    .then(res => res.json())
                    .then(data => {
                        // Ambil inisial dari hasil endpoint
                        const docNum = data.document_number;
                        const inisialMatch = docNum.match(/^(\d{3})\/SI\/KSS-([^\/]+)\/([IVXLCDM]+)\/(\d{4})$/);
                        if (inisialMatch) {
                            const inisial = inisialMatch[2];
                            // Gabungkan urut lama + inisial baru + bulan & tahun lama
                            docNumberInput.value = `${urut}/SI/KSS-${inisial}/${bulan}/${tahun}`;
                        }
                    });
                }
            }
        });
    }
});
</script>
@endsection