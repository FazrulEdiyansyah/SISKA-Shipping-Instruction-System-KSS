@extends('layouts.app')

@section('title', 'Shipping Instruction - SISKA')
@section('page-title', 'Shipping Instruction')
@section('page-subtitle', 'Create new shipping instruction document')

@section('content')
<div class="max-w-6xl mx-auto">
    <!-- Header Section -->
    <div class="bg-white rounded-xl shadow-sm mb-6">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-xl font-bold text-gray-900">Create New Shipping Instruction</h3>
                    <p class="text-sm text-gray-600 mt-1">Fill in the details below to generate shipping instruction document</p>
                </div>
                <div class="flex items-center space-x-2">
                    <div class="w-3 h-3 bg-green-400 rounded-full"></div>
                    <span class="text-sm text-gray-600">Ready to Create</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Section -->
    <form action="/shipping-instruction" method="POST" class="space-y-6">
        @csrf
        <input type="hidden" name="number" value="" id="docNumberInput">
        
        <!-- Document Information Section -->
        <div class="bg-white rounded-xl shadow-sm">
            <div class="p-6 border-b border-gray-200">
                <h4 class="text-lg font-semibold text-gray-900 flex items-center">
                    <i class="fas fa-file-alt text-blue-500 mr-2"></i>
                    Document Information
                </h4>
                <p class="text-sm text-gray-600 mt-1">Basic document identification details</p>
            </div>
            <div class="p-6">
                <div class="space-y-6">
                    <!-- Place & Date -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">Place & Date Document *</label>
                        <div class="flex gap-2">
                            <input type="text" name="place"
                                class="w-1/2 px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                                placeholder="e.g., Cilegon" required
                                value="{{ session('si_preview_data.place') ?? old('place') }}">
                            <input type="date" name="date"
                                class="w-1/2 px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                                required
                                value="{{ session('si_preview_data.date') ?? old('date') }}">
                        </div>
                        <p class="text-xs text-gray-500">Document issuance location and date</p>
                    </div>

                    <!-- Addressed To -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">Addressed To *</label>
                        <select name="to" id="vendorInput"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required>
                            <option value="">-- Select Vendor --</option>
                            @foreach($vendors as $vendor)
                                <option value="{{ $vendor->company }}"
                                    {{ (session('si_preview_data.to') ?? old('to')) == $vendor->company ? 'selected' : '' }}>
                                    {{ $vendor->company }}
                                </option>
                            @endforeach
                        </select>
                        <p class="text-xs text-gray-500">Company or organization name</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Project Type Section -->
        <div class="bg-white rounded-xl shadow-sm">
            <div class="p-6 border-b border-gray-200">
                <h4 class="text-lg font-semibold text-gray-900 flex items-center">
                    <i class="fas fa-project-diagram text-blue-500 mr-2"></i>
                    Project Type
                </h4>
                <p class="text-sm text-gray-600 mt-1">Select project type to show relevant fields</p>
            </div>
            <div class="p-6">
                <div class="flex gap-3">
                    <button type="button" id="projectDefaultBtn" 
                            class="px-6 py-3 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 transition duration-200 flex items-center gap-2">
                        <i class="fas fa-ship"></i>
                        Default
                    </button>
                    <button type="button" id="projectSTSBtn" 
                            class="px-6 py-3 bg-gray-200 text-gray-700 rounded-lg font-medium hover:bg-gray-300 transition duration-200 flex items-center gap-2">
                        <i class="fas fa-exchange-alt"></i>
                        Ship To Ship
                    </button>
                </div>
                <input type="hidden" name="project_type" id="projectTypeInput" value="default">
            </div>
        </div>

        <!-- Vessel Information Section -->
        <div class="bg-white rounded-xl shadow-sm">
            <div class="p-6 border-b border-gray-200">
                <h4 class="text-lg font-semibold text-gray-900 flex items-center">
                    <i class="fas fa-ship text-blue-500 mr-2"></i>
                    Vessel Information
                </h4>
                <p class="text-sm text-gray-600 mt-1">Details about the vessel and its registration</p>
            </div>
            <div class="p-6">
                <!-- Field khusus untuk Ship To Ship -->
                <div id="stsFields" style="display:none;" class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                    <h5 class="text-md font-semibold text-blue-900 mb-4 flex items-center">
                        <i class="fas fa-anchor text-blue-600 mr-2"></i>
                        Ship To Ship Information
                    </h5>
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-blue-800">Vessel Name *</label>
                            <input type="text" name="vessel_name"
                                class="w-full px-4 py-3 border border-blue-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white"
                                placeholder="Enter vessel name"
                                value="{{ session('si_preview_data.vessel_name') ?? old('vessel_name') }}">
                            <p class="text-xs text-blue-600">Name of the receiving vessel</p>
                        </div>
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-blue-800">Vessel Arrived *</label>
                            <div class="grid grid-cols-2 gap-2">
                                <div>
                                    <input type="date" name="vessel_arrived"
                                        class="w-full px-4 py-3 border border-blue-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white"
                                        value="{{ session('si_preview_data.vessel_arrived') ?? old('vessel_arrived') }}">
                                    <p class="text-xs text-blue-600 mt-1">Arrival date</p>
                                </div>
                                <div>
                                    <input type="text" name="vessel_arrived_note"
                                        class="w-full px-4 py-3 border border-blue-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white"
                                        placeholder="Additional notes (optional)"
                                        value="{{ session('si_preview_data.vessel_arrived_note') ?? old('vessel_arrived_note') }}">
                                    <p class="text-xs text-blue-600 mt-1">Optional notes</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Standard vessel fields -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">Tugboat/Barge *</label>
                        <input type="text" name="tugbarge"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                            placeholder="e.g., TB. SARASWANTI 4 / BG. SARASWANTI 3" required
                            value="{{ session('si_preview_data.tugbarge') ?? old('tugbarge') }}">
                        <p class="text-xs text-gray-500">Vessel name and identification</p>
                    </div>
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">Flag State *</label>
                        <input type="text" name="flag"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                            placeholder="e.g., Indonesia" required
                            value="{{ session('si_preview_data.flag') ?? old('flag') }}">
                        <p class="text-xs text-gray-500">Country of vessel registration</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Parties Information Section -->
        <div class="bg-white rounded-xl shadow-sm">
            <div class="p-6 border-b border-gray-200">
                <h4 class="text-lg font-semibold text-gray-900 flex items-center">
                    <i class="fas fa-users text-blue-500 mr-2"></i>
                    Parties Information
                </h4>
                <p class="text-sm text-gray-600 mt-1">Shipper, consignee, and notification details</p>
            </div>
            <div class="p-6">
                <div class="space-y-6">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700">Shipper *</label>
                            <input type="text" name="shipper"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                                placeholder="e.g., PT Dizamatra Powerindo" required
                                value="{{ session('si_preview_data.shipper') ?? old('shipper') }}">
                            <p class="text-xs text-gray-500">Company shipping the goods</p>
                        </div>
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700">Consignee *</label>
                            <input type="text" name="consignee"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                                placeholder="e.g., To the order" required
                                value="{{ session('si_preview_data.consignee') ?? old('consignee') }}">
                            <p class="text-xs text-gray-500">Company receiving the goods</p>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <label id="notifyLabel" class="block text-sm font-semibold text-gray-700">Notify Address *</label>
                        <textarea name="notify_address" rows="3"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                                  placeholder="e.g., PLTU Palton Unit 7-8" required>{{ session('si_preview_data.notify_address') ?? old('notify_address') }}</textarea>
                        <p class="text-xs text-gray-500">Complete address for notifications</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Port & Route Information Section -->
        <div class="bg-white rounded-xl shadow-sm">
            <div class="p-6 border-b border-gray-200">
                <h4 class="text-lg font-semibold text-gray-900 flex items-center">
                    <i class="fas fa-map-marker-alt text-blue-500 mr-2"></i>
                    Port & Route Information
                </h4>
                <p class="text-sm text-gray-600 mt-1">Loading and discharging port details</p>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">Port of Loading *</label>
                        <input type="text" name="port_loading"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                            placeholder="e.g., Jetty Patratani, Muara Enim, Indonesia" required
                            value="{{ session('si_preview_data.port_loading') ?? old('port_loading') }}">
                        <p class="text-xs text-gray-500">Port where cargo will be loaded</p>
                    </div>
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">Port of Discharging *</label>
                        <input type="text" name="port_discharging"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                            placeholder="e.g., PLTU Palton Unit 7-8" required
                            value="{{ session('si_preview_data.port_discharging') ?? old('port_discharging') }}">
                        <p class="text-xs text-gray-500">Port where cargo will be discharged</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cargo Information Section -->
        <div class="bg-white rounded-xl shadow-sm">
            <div class="p-6 border-b border-gray-200">
                <h4 class="text-lg font-semibold text-gray-900 flex items-center">
                    <i class="fas fa-boxes text-blue-500 mr-2"></i>
                    Cargo Information
                </h4>
                <p class="text-sm text-gray-600 mt-1">Details about the cargo being shipped</p>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">Commodities *</label>
                        <input type="text" name="commodities"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                            placeholder="e.g., Indonesian Steam Coal in Bulk" required
                            value="{{ session('si_preview_data.commodities') ?? old('commodities') }}">
                        <p class="text-xs text-gray-500">Type of goods being shipped</p>
                    </div>
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">Quantity *</label>
                        <input type="text" name="quantity"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                            placeholder="e.g., 8.500 MT +/- 10%" required
                            value="{{ session('si_preview_data.quantity') ?? old('quantity') }}">
                        <p class="text-xs text-gray-500">Amount and measurement unit</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Schedule & Terms Section -->
        <div class="bg-white rounded-xl shadow-sm">
            <div class="p-6 border-b border-gray-200">
                <h4 class="text-lg font-semibold text-gray-900 flex items-center">
                    <i class="fas fa-calendar-alt text-blue-500 mr-2"></i>
                    Schedule & Terms
                </h4>
                <p class="text-sm text-gray-600 mt-1">Scheduling and additional terms information</p>
            </div>
            <div class="p-6">
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700">Laycan Period *</label>
                    <div class="flex gap-2">
                        <input type="date" name="laycan_start"
                            class="w-1/2 px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                            required
                            value="{{ session('si_preview_data.laycan_start') ?? old('laycan_start') }}">
                        <span class="flex items-center px-2">to</span>
                        <input type="date" name="laycan_end"
                            class="w-1/2 px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                            required
                            value="{{ session('si_preview_data.laycan_end') ?? old('laycan_end') }}">
                    </div>
                    <p class="text-xs text-gray-500">Loading/discharge window period</p>
                </div>
            </div>
        </div>

        <!-- Signatory Section -->
        <div class="bg-white rounded-xl shadow-sm">
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
                                {{ (session('si_preview_data.signed_by') ?? old('signed_by')) == $signatory->id ? 'selected' : '' }}>
                                {{ $signatory->name }}
                            </option>
                        @endforeach
                    </select>
                    <input type="hidden" name="position" id="signatoryPosition"
                        value="{{ session('si_preview_data.position') ?? old('position') }}">
                    <input type="hidden" name="department" id="signatoryDepartment"
                        value="{{ session('si_preview_data.department') ?? old('department') }}">
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="bg-white rounded-xl shadow-sm">
            <div class="p-6">
                <div class="flex flex-col sm:flex-row justify-between items-center space-y-4 sm:space-y-0 sm:space-x-4">
                    <div class="flex items-center text-sm text-gray-600">
                        <i class="fas fa-info-circle text-blue-500 mr-2"></i>
                        <span>All fields marked with (*) are required</span>
                    </div>
                    <div class="flex flex-wrap gap-4 justify-center">
                        <button type="submit" formaction="/shipping-instruction/save"
                            class="px-8 py-3 bg-gradient-to-r from-green-400 to-green-600 hover:from-green-500 hover:to-green-700 text-white rounded-lg transition duration-200 font-medium shadow-lg">
                            <i class="fas fa-save mr-2"></i>
                            Save
                        </button>
                        <button type="submit" formaction="/shipping-instruction/preview-data"
                            class="px-8 py-3 bg-gradient-to-r from-blue-400 to-blue-600 hover:from-blue-500 hover:to-blue-700 text-white rounded-lg transition duration-200 font-medium shadow-lg">
                            <i class="fas fa-eye mr-2"></i>
                            Preview
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

{{-- Notifikasi sukses --}}
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

@if(request()->has('from_preview'))
<script>
    // Hanya redirect jika user melakukan refresh (bukan saat kembali dari preview)
    if (performance.navigation.type === 1 && window.location.search.includes('from_preview=1')) {
        window.location.replace('/shipping-instruction');
    }
</script>
@endif

<style>
/* Custom styles untuk form yang lebih profesional */
.form-section {
    transition: all 0.3s ease;
}

.form-section:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
}

input:focus, textarea:focus {
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

.gradient-button {
    background: linear-gradient(135deg, #3B82F6 0%, #1D4ED8 100%);
}

/* Animasi untuk notifikasi */
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
function closeAlert() {
    const alert = document.getElementById('successAlert');
    if (alert) {
        alert.style.animation = 'slideOutUp 0.3s ease-in forwards';
        setTimeout(() => {
            alert.remove();
        }, 300);
    }
}

// Auto close notifikasi setelah 5 detik
document.addEventListener('DOMContentLoaded', function() {
    const successAlert = document.getElementById('successAlert');
    if (successAlert) {
        setTimeout(() => {
            closeAlert();
        }, 5000);
    }

    const vendorInput = document.getElementById('vendorInput');
    const docNumberInput = document.getElementById('docNumberInput');
    const signatorySelect = document.getElementById('signatorySelect');
    const signatoryPosition = document.getElementById('signatoryPosition');
    const signatoryDepartment = document.getElementById('signatoryDepartment');
    
    if(signatorySelect) {
        signatorySelect.addEventListener('change', function() {
            const selected = signatorySelect.options[signatorySelect.selectedIndex];
            signatoryPosition.value = selected.getAttribute('data-position') || '';
            signatoryDepartment.value = selected.getAttribute('data-department') || '';
        });
    }

    vendorInput.addEventListener('blur', function() {
        const vendor = vendorInput.value;
        if (vendor.length > 0) {
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
                docNumberInput.value = data.document_number;
            });
        }
    });

    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('input', function() {
            // No preview button, so nothing to update here
        });
    }
});

// Tambah animasi slide out
const style = document.createElement('style');
style.textContent = `
    @keyframes slideOutUp {
        from {
            opacity: 1;
            transform: translate(-50%, 0);
        }
        to {
            opacity: 0;
            transform: translate(-50%, -20px);
        }
    }
`;
document.head.appendChild(style);
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const vendorInput = document.getElementById('vendorInput');
    const bungaTerataiFields = document.getElementById('bungaTerataiFields');
    const notifyLabel = document.getElementById('notifyLabel');
    
    function toggleBungaTerataiFields() {
        if (vendorInput.value === 'PT Bunga Teratai') {
            bungaTerataiFields.style.display = '';
            notifyLabel.textContent = 'Notify Party *';
        } else {
            bungaTerataiFields.style.display = 'none';
            notifyLabel.textContent = 'Notify Address *';
        }
    }
    
    vendorInput.addEventListener('change', toggleBungaTerataiFields);
    toggleBungaTerataiFields(); // initial load
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const projectDefaultBtn = document.getElementById('projectDefaultBtn');
    const projectSTSBtn = document.getElementById('projectSTSBtn');
    const projectTypeInput = document.getElementById('projectTypeInput');
    const stsFields = document.getElementById('stsFields');

    function updateProjectButtons(selectedType) {
        if (selectedType === 'sts') {
            // STS button active
            projectSTSBtn.classList.remove('bg-gray-200', 'text-gray-700', 'hover:bg-gray-300');
            projectSTSBtn.classList.add('bg-blue-600', 'text-white', 'hover:bg-blue-700');
            
            // Default button inactive
            projectDefaultBtn.classList.remove('bg-blue-600', 'text-white', 'hover:bg-blue-700');
            projectDefaultBtn.classList.add('bg-gray-200', 'text-gray-700', 'hover:bg-gray-300');
            
            // Show STS fields
            stsFields.style.display = '';
        } else {
            // Default button active
            projectDefaultBtn.classList.remove('bg-gray-200', 'text-gray-700', 'hover:bg-gray-300');
            projectDefaultBtn.classList.add('bg-blue-600', 'text-white', 'hover:bg-blue-700');
            
            // STS button inactive
            projectSTSBtn.classList.remove('bg-blue-600', 'text-white', 'hover:bg-blue-700');
            projectSTSBtn.classList.add('bg-gray-200', 'text-gray-700', 'hover:bg-gray-300');
            
            // Hide STS fields
            stsFields.style.display = 'none';
        }
    }

    projectDefaultBtn.addEventListener('click', function() {
        projectTypeInput.value = 'default';
        updateProjectButtons('default');
    });

    projectSTSBtn.addEventListener('click', function() {
        projectTypeInput.value = 'sts';
        updateProjectButtons('sts');
    });

    // Initial state
    updateProjectButtons(projectTypeInput.value);
});
</script>
@endsection