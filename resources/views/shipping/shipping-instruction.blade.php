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
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">Document Number *</label>
                        <input type="text" name="number" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200" 
                               placeholder="e.g., 009/SI/KSS-BLT/VIII/2025" required>
                        <p class="text-xs text-gray-500">Unique document identification number</p>
                    </div>
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">Addressed To *</label>
                        <input type="text" name="to" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200" 
                               placeholder="e.g., PT BERLIAN LINTAS TAMA" required>
                        <p class="text-xs text-gray-500">Company or organization name</p>
                    </div>
                </div>
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
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">Tugboat/Barge *</label>
                        <input type="text" name="tugbarge" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200" 
                               placeholder="e.g., TB. SARASWANTI 4 / BG. SARASWANTI 3" required>
                        <p class="text-xs text-gray-500">Vessel name and identification</p>
                    </div>
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">Flag State *</label>
                        <input type="text" name="flag" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200" 
                               placeholder="e.g., Indonesia" required>
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
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">Shipper *</label>
                        <input type="text" name="shipper" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200" 
                               placeholder="e.g., PT Dizamatra Powerindo" required>
                        <p class="text-xs text-gray-500">Company shipping the goods</p>
                    </div>
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">Consignee *</label>
                        <input type="text" name="consignee" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200" 
                               placeholder="e.g., To the order" required>
                        <p class="text-xs text-gray-500">Company receiving the goods</p>
                    </div>
                </div>
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700">Notify Address *</label>
                    <textarea name="notify_address" rows="3"
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200" 
                              placeholder="e.g., PLTU Palton Unit 7-8" required></textarea>
                    <p class="text-xs text-gray-500">Complete address for notifications</p>
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
                               placeholder="e.g., Jetty Patratani, Muara Enim, Indonesia" required>
                        <p class="text-xs text-gray-500">Port where cargo will be loaded</p>
                    </div>
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">Port of Discharging *</label>
                        <input type="text" name="port_discharging" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200" 
                               placeholder="e.g., PLTU Palton Unit 7-8" required>
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
                               placeholder="e.g., Indonesian Steam Coal in Bulk" required>
                        <p class="text-xs text-gray-500">Type of goods being shipped</p>
                    </div>
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">Quantity *</label>
                        <input type="text" name="quantity" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200" 
                               placeholder="e.g., 8.500 MT +/- 10%" required>
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
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">Laycan Period *</label>
                        <input type="text" name="laycan" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200" 
                               placeholder="e.g., 18 - 19 August 2025" required>
                        <p class="text-xs text-gray-500">Loading/discharge window period</p>
                    </div>
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">Place & Date *</label>
                        <input type="text" name="place_date" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200" 
                               placeholder="e.g., Cilegon, 13 August 2025" required>
                        <p class="text-xs text-gray-500">Document issuance location and date</p>
                    </div>
                </div>
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700">Remarks *</label>
                    <textarea name="remarks" rows="4"
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200" 
                              placeholder="e.g., Freight Payable as Per Charter Party (SPAL)" required></textarea>
                    <p class="text-xs text-gray-500">Additional terms and conditions</p>
                </div>
            </div>
        </div>

        <!-- Authorization Section -->
        <div class="bg-white rounded-xl shadow-sm">
            <div class="p-4 border-b border-gray-200">
                <h4 class="text-base font-semibold text-gray-900 flex items-center">
                    <i class="fas fa-signature text-blue-500 mr-2"></i>
                    Authorization & Signature
                </h4>
                <p class="text-sm text-gray-600 mt-1">Select authorized signatory for this document</p>
            </div>
            <div class="p-4">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">Select Authorized Signatory *</label>
                        <select name="signatory_id" onchange="updateSignatoryInfo()" id="signatorySelect"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200" required>
                            <option value="">Choose Signatory...</option>
                            <option value="1" data-name="Miftahul A.N. Basori" data-position="Procurement & ITSM Manager">Miftahul A.N. Basori - Procurement & ITSM Manager</option>
                            <option value="2" data-name="Joko Susanto" data-position="Operations Director">Joko Susanto - Operations Director</option>
                            <option value="3" data-name="Rina Pratiwi" data-position="Finance Manager">Rina Pratiwi - Finance Manager</option>
                        </select>
                        <p class="text-xs text-gray-500">Select from approved signatory list</p>
                    </div>
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">Alternative Signatory</label>
                        <input type="text" name="signed_by" id="manualSignatory"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200" 
                               placeholder="Manual entry if needed">
                        <p class="text-xs text-gray-500">Manual override if needed</p>
                    </div>
                </div>
                <div class="mt-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Position/Title</label>
                    <input type="text" name="position" id="signatoryPosition"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200" 
                           placeholder="Position will be auto-filled" required>
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
                    <div class="flex space-x-3">
                        <button type="button" class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition duration-200 font-medium">
                            <i class="fas fa-save mr-2"></i>
                            Save Draft
                        </button>
                        <button type="submit" class="px-8 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white rounded-lg transition duration-200 font-medium shadow-lg">
                            <i class="fas fa-file-pdf mr-2"></i>
                            Generate & Download PDF
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

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
</style>

<script>
function updateSignatoryInfo() {
    const select = document.getElementById('signatorySelect');
    const selectedOption = select.options[select.selectedIndex];
    
    if (selectedOption.value) {
        const name = selectedOption.getAttribute('data-name');
        const position = selectedOption.getAttribute('data-position');
        
        document.getElementById('manualSignatory').value = name;
        document.getElementById('signatoryPosition').value = position;
    } else {
        document.getElementById('manualSignatory').value = '';
        document.getElementById('signatoryPosition').value = '';
    }
}
</script>
@endsection