@extends('layouts.app')

@section('title', 'Reports - SISKA')
@section('page-title', 'Reports')
@section('page-subtitle', 'Generate and view shipping instruction reports')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header Section -->
    <div class="bg-white rounded-xl shadow-sm mb-6">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-xl font-bold text-gray-900">Generate Report</h3>
                    <p class="text-sm text-gray-600 mt-1">Create custom reports for shipping instruction documents</p>
                </div>
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-chart-bar text-blue-500"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Report Configuration Form -->
    <div class="bg-white rounded-xl shadow-sm">
        <div class="p-6 border-b border-gray-200">
            <h4 class="text-lg font-semibold text-gray-900 flex items-center">
                <i class="fas fa-cog text-blue-500 mr-2"></i>
                Report Configuration
            </h4>
            <p class="text-sm text-gray-600 mt-1">Configure your report parameters and settings</p>
        </div>
        
        <form method="POST" action="{{ route('report.show') }}" class="p-6">
            @csrf
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Left Column: Date Range -->
                <div class="space-y-6">
                    <div>
                        <h5 class="text-md font-semibold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-calendar-alt text-green-500 mr-2"></i>
                            Date Range Selection
                        </h5>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">From Date *</label>
                                <input type="date" name="date_from" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                                       value="{{ date('Y-m-01') }}" required>
                                <p class="text-xs text-gray-500 mt-1">Select the start date for the report period</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">To Date *</label>
                                <input type="date" name="date_to" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                                       value="{{ date('Y-m-t') }}" required>
                                <p class="text-xs text-gray-500 mt-1">Select the end date for the report period</p>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Date Presets -->
                    <div>
                        <h6 class="text-sm font-medium text-gray-700 mb-3">Quick Date Presets</h6>
                        <div class="grid grid-cols-2 gap-2">
                            <button type="button" onclick="setDateRange('today')" 
                                    class="px-3 py-2 text-xs bg-gray-100 hover:bg-gray-200 text-gray-700 rounded transition duration-200">
                                Today
                            </button>
                            <button type="button" onclick="setDateRange('thisWeek')" 
                                    class="px-3 py-2 text-xs bg-gray-100 hover:bg-gray-200 text-gray-700 rounded transition duration-200">
                                This Week
                            </button>
                            <button type="button" onclick="setDateRange('thisMonth')" 
                                    class="px-3 py-2 text-xs bg-gray-100 hover:bg-gray-200 text-gray-700 rounded transition duration-200">
                                This Month
                            </button>
                            <button type="button" onclick="setDateRange('thisYear')" 
                                    class="px-3 py-2 text-xs bg-gray-100 hover:bg-gray-200 text-gray-700 rounded transition duration-200">
                                This Year
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Column Selection -->
                <div class="space-y-6">
                    <div>
                        <h5 class="text-md font-semibold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-columns text-purple-500 mr-2"></i>
                            Column Selection
                        </h5>
                        <p class="text-sm text-gray-600 mb-4">Choose which columns to include in your report</p>
                        
                        <div class="space-y-3 max-h-80 overflow-y-auto border border-gray-200 rounded-lg p-4 bg-gray-50">
                            <label class="flex items-center space-x-3 p-2 hover:bg-white rounded transition duration-200">
                                <input type="checkbox" name="columns[]" value="date" checked 
                                       class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                                <span class="text-sm font-medium text-gray-700">Date</span>
                                <span class="text-xs text-gray-500">(Document date)</span>
                            </label>
                            <label class="flex items-center space-x-3 p-2 hover:bg-white rounded transition duration-200">
                                <input type="checkbox" name="columns[]" value="number" checked 
                                       class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                                <span class="text-sm font-medium text-gray-700">Number</span>
                                <span class="text-xs text-gray-500">(SI Number)</span>
                            </label>
                            <label class="flex items-center space-x-3 p-2 hover:bg-white rounded transition duration-200">
                                <input type="checkbox" name="columns[]" value="to" checked 
                                       class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                                <span class="text-sm font-medium text-gray-700">Vendor</span>
                                <span class="text-xs text-gray-500">(Addressed to)</span>
                            </label>
                            <label class="flex items-center space-x-3 p-2 hover:bg-white rounded transition duration-200">
                                <input type="checkbox" name="columns[]" value="tugbarge" 
                                       class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                                <span class="text-sm font-medium text-gray-700">Tugbarge</span>
                                <span class="text-xs text-gray-500">(Vessel name)</span>
                            </label>
                            <label class="flex items-center space-x-3 p-2 hover:bg-white rounded transition duration-200">
                                <input type="checkbox" name="columns[]" value="shipper" 
                                       class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                                <span class="text-sm font-medium text-gray-700">Shipper</span>
                                <span class="text-xs text-gray-500">(Cargo shipper)</span>
                            </label>
                            <label class="flex items-center space-x-3 p-2 hover:bg-white rounded transition duration-200">
                                <input type="checkbox" name="columns[]" value="commodities" 
                                       class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                                <span class="text-sm font-medium text-gray-700">Commodities</span>
                                <span class="text-xs text-gray-500">(Cargo type)</span>
                            </label>
                            <label class="flex items-center space-x-3 p-2 hover:bg-white rounded transition duration-200">
                                <input type="checkbox" name="columns[]" value="quantity" 
                                       class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                                <span class="text-sm font-medium text-gray-700">Quantity</span>
                                <span class="text-xs text-gray-500">(Cargo quantity)</span>
                            </label>
                            <label class="flex items-center space-x-3 p-2 hover:bg-white rounded transition duration-200">
                                <input type="checkbox" name="columns[]" value="port_loading" 
                                       class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                                <span class="text-sm font-medium text-gray-700">Port Loading</span>
                                <span class="text-xs text-gray-500">(Loading port)</span>
                            </label>
                            <label class="flex items-center space-x-3 p-2 hover:bg-white rounded transition duration-200">
                                <input type="checkbox" name="columns[]" value="port_discharging" 
                                       class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                                <span class="text-sm font-medium text-gray-700">Port Discharging</span>
                                <span class="text-xs text-gray-500">(Discharge port)</span>
                            </label>
                            <label class="flex items-center space-x-3 p-2 hover:bg-white rounded transition duration-200">
                                <input type="checkbox" name="columns[]" value="laycan" 
                                       class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                                <span class="text-sm font-medium text-gray-700">Laycan</span>
                                <span class="text-xs text-gray-500">(Loading window)</span>
                            </label>
                            <label class="flex items-center space-x-3 p-2 hover:bg-white rounded transition duration-200">
                                <input type="checkbox" name="columns[]" value="spal_number" 
                                       class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                                <span class="text-sm font-medium text-gray-700">SPAL Number</span>
                                <span class="text-xs text-gray-500">(SPAL document number)</span>
                            </label>
                            <label class="flex items-center space-x-3 p-2 hover:bg-white rounded transition duration-200">
                                <input type="checkbox" name="columns[]" value="status" checked 
                                       class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                                <span class="text-sm font-medium text-gray-700">Status</span>
                                <span class="text-xs text-gray-500">(Document status)</span>
                            </label>
                        </div>

                        <!-- Column Selection Actions -->
                        <div class="flex gap-2 mt-3">
                            <button type="button" onclick="selectAllColumns()" 
                                    class="px-3 py-1 text-xs bg-blue-100 hover:bg-blue-200 text-blue-700 rounded transition duration-200">
                                Select All
                            </button>
                            <button type="button" onclick="deselectAllColumns()" 
                                    class="px-3 py-1 text-xs bg-gray-100 hover:bg-gray-200 text-gray-700 rounded transition duration-200">
                                Deselect All
                            </button>
                            <button type="button" onclick="resetToDefault()" 
                                    class="px-3 py-1 text-xs bg-green-100 hover:bg-green-200 text-green-700 rounded transition duration-200">
                                Reset Default
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Generate Report Button -->
            <div class="mt-8 pt-6 border-t border-gray-200">
                <div class="flex flex-col sm:flex-row justify-between items-center space-y-4 sm:space-y-0">
                    <div class="flex items-center text-sm text-gray-600">
                        <i class="fas fa-info-circle text-blue-500 mr-2"></i>
                        <span>Report will be generated based on selected date range and columns</span>
                    </div>
                    <button type="submit" 
                            class="px-8 py-3 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white rounded-lg transition duration-200 font-medium shadow-lg flex items-center">
                        <i class="fas fa-chart-line mr-2"></i>
                        Generate Report
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
// Date range quick presets
function setDateRange(preset) {
    const dateFrom = document.querySelector('input[name="date_from"]');
    const dateTo = document.querySelector('input[name="date_to"]');
    const today = new Date();
    
    switch(preset) {
        case 'today':
            const todayStr = today.toISOString().split('T')[0];
            dateFrom.value = todayStr;
            dateTo.value = todayStr;
            break;
        case 'thisWeek':
            // Buat objek Date baru untuk menghindari mutasi
            const startOfWeek = new Date(today);
            startOfWeek.setDate(today.getDate() - today.getDay());
            
            const endOfWeek = new Date(today);
            endOfWeek.setDate(today.getDate() - today.getDay() + 6);
            
            dateFrom.value = startOfWeek.toISOString().split('T')[0];
            dateTo.value = endOfWeek.toISOString().split('T')[0];
            break;
        case 'thisMonth':
            const startOfMonth = new Date(today.getFullYear(), today.getMonth(), 1);
            const endOfMonth = new Date(today.getFullYear(), today.getMonth() + 1, 0);
            dateFrom.value = startOfMonth.toISOString().split('T')[0];
            dateTo.value = endOfMonth.toISOString().split('T')[0];
            break;
        case 'thisYear':
            const startOfYear = new Date(today.getFullYear(), 0, 1); // 1 Januari tahun ini
            const endOfYear = new Date(today.getFullYear(), 11, 31); // 31 Desember tahun ini
            dateFrom.value = startOfYear.toISOString().split('T')[0];
            dateTo.value = endOfYear.toISOString().split('T')[0];
            break;
    }
}

// Column selection functions
function selectAllColumns() {
    document.querySelectorAll('input[name="columns[]"]').forEach(checkbox => {
        checkbox.checked = true;
    });
}

function deselectAllColumns() {
    document.querySelectorAll('input[name="columns[]"]').forEach(checkbox => {
        checkbox.checked = false;
    });
}

function resetToDefault() {
    document.querySelectorAll('input[name="columns[]"]').forEach(checkbox => {
        checkbox.checked = ['date', 'number', 'to', 'status'].includes(checkbox.value);
    });
}

// Form validation
document.querySelector('form').addEventListener('submit', function(e) {
    const checkedColumns = document.querySelectorAll('input[name="columns[]"]:checked');
    if (checkedColumns.length === 0) {
        e.preventDefault();
        alert('Please select at least one column for the report.');
    }
});
</script>
@endsection