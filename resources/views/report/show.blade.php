@extends('layouts.app')

@section('title', 'Laporan Shipping Instruction')
@section('page-title', 'Laporan Shipping Instruction')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header Laporan -->
    <div class="bg-white rounded-xl shadow-sm mb-6">
        <div class="p-6 border-b border-gray-200 flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">PT KRAKATAU SAMUDERA SOLUSI</h2>
                <h3 class="text-xl font-semibold text-red-700 mt-2">Laporan Dokumen Shipping Instruction</h3>
                <p class="text-sm text-gray-600 mt-1">Dari {{ $periodText }}</p>
            </div>
            <div class="flex gap-3 items-center">
                <!-- Ikon Setting/Filter -->
                <button type="button" onclick="openColumnModal()" class="p-2 hover:bg-gray-100 rounded" title="Modify Columns">
                    <i class="fas fa-sliders-h text-xl text-gray-600"></i>
                </button>
                <!-- Tombol download -->
                <a href="{{ route('report.download', array_merge($filters, ['format' => 'pdf'])) }}" 
                   class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition duration-200 ml-3">
                    <i class="fas fa-file-pdf mr-2"></i>Download PDF
                </a>
                <a href="{{ route('report.download', array_merge($filters, ['format' => 'excel'])) }}" 
                   class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition duration-200">
                    <i class="fas fa-file-excel mr-2"></i>Download Excel
                </a>
            </div>
        </div>
    </div>

    <!-- PDF Preview Section -->
    <div class="bg-white rounded-xl shadow-sm mb-6">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                <i class="fas fa-file-pdf text-red-500 mr-2"></i>
                Preview PDF
            </h3>
            <p class="text-sm text-gray-600 mt-1">Preview laporan sebelum download</p>
        </div>
        <div class="p-6">
            <div class="border border-gray-300 rounded-lg overflow-hidden" style="height: 600px;">
                <iframe 
                    src="{{ route('report.preview-pdf', $filters) }}" 
                    class="w-full h-full" 
                    frameborder="0"
                    id="pdfPreview">
                    <p>Browser Anda tidak mendukung iframe. <a href="{{ route('report.preview-pdf', $filters) }}" target="_blank">Buka PDF di tab baru</a></p>
                </iframe>
            </div>
        </div>
    </div>
</div>

<!-- Modal Modifikasi Kolom -->
<div id="columnModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-4xl mx-4 max-h-[90vh] overflow-hidden">
        <!-- Modal Header -->
        <div class="flex items-center justify-between p-6 border-b border-gray-200 bg-blue-600 text-white">
            <h2 class="text-xl font-semibold">Modifikasi</h2>
            <button onclick="closeColumnModal()" class="text-white hover:text-gray-200 transition duration-200">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        <!-- Tab Navigation -->
        <div class="border-b border-gray-200">
            <nav class="flex">
                <button id="columnDataTab" class="px-6 py-3 text-sm font-medium text-red-600 border-b-2 border-red-600 bg-white">
                    Kolom Data
                </button>
                <button id="periodTab" class="px-6 py-3 text-sm font-medium text-gray-500 hover:text-gray-700 bg-gray-50">
                    Penyaringan
                </button>
                <button id="pageSettingsTab" class="px-6 py-3 text-sm font-medium text-gray-500 hover:text-gray-700 bg-gray-50">
                    Edit Halaman
                </button>
            </nav>
        </div>

        <!-- Tab Content -->
        <div class="p-6 max-h-[60vh] overflow-y-auto">
            <!-- Kolom Data Content -->
            <div id="columnDataContent">
                <div class="grid grid-cols-2 gap-6">
                    <!-- Available Columns -->
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Cari Kolom Data</h3>
                        <div class="mb-4">
                            <input type="text" id="columnSearch" placeholder="Cari Kolom Data" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div id="availableColumns" class="space-y-2 max-h-64 overflow-y-auto border border-gray-200 rounded p-3">
                            <!-- Available columns will be loaded here -->
                        </div>
                    </div>

                    <!-- Selected Columns -->
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Kolom Digunakan</h3>
                        <div id="selectedColumns" class="space-y-2 max-h-80 overflow-y-auto border border-gray-200 rounded p-3 min-h-64">
                            <!-- Selected columns will be shown here -->
                        </div>
                    </div>
                </div>
            </div>

            <!-- Period Content -->
            <div id="periodContent" class="hidden">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Dari Tanggal</label>
                        <input type="date" id="editDateFrom" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                               value="{{ request('date_from') }}">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Sampai Tanggal</label>
                        <input type="date" id="editDateTo" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                               value="{{ request('date_to') }}">
                    </div>
                </div>
            </div>

            <!-- Page Settings Content -->
            <div id="pageSettingsContent" class="hidden">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Paper Settings -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold mb-4">Pengaturan Kertas</h3>
                        
                        <!-- Paper Size -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Ukuran Kertas</label>
                            <select id="paperSize" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="A4">A4 (210 x 297 mm)</option>
                                <option value="A3">A3 (297 x 420 mm)</option>
                                <option value="Letter">Letter (8.5 x 11 inch)</option>
                                <option value="Legal">Legal (8.5 x 14 inch)</option>
                                <option value="Folio">Folio (8.27 x 13 inch)</option>
                            </select>
                        </div>

                        <!-- Paper Orientation -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Orientasi Kertas</label>
                            <div class="flex gap-4">
                                <label class="flex items-center">
                                    <input type="radio" name="orientation" value="portrait" checked class="mr-2 text-blue-600">
                                    <i class="fas fa-portrait mr-1"></i>
                                    Portrait
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="orientation" value="landscape" class="mr-2 text-blue-600">
                                    <i class="fas fa-landscape mr-1"></i>
                                    Landscape
                                </label>
                            </div>
                        </div>

                        <!-- Margins -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Margin (dalam cm)</label>
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs text-gray-600 mb-1">Atas</label>
                                    <input type="number" id="marginTop" value="2" min="0" max="5" step="0.5" 
                                           class="w-full px-2 py-1 border border-gray-300 rounded text-sm">
                                </div>
                                <div>
                                    <label class="block text-xs text-gray-600 mb-1">Bawah</label>
                                    <input type="number" id="marginBottom" value="2" min="0" max="5" step="0.5" 
                                           class="w-full px-2 py-1 border border-gray-300 rounded text-sm">
                                </div>
                                <div>
                                    <label class="block text-xs text-gray-600 mb-1">Kiri</label>
                                    <input type="number" id="marginLeft" value="1.5" min="0" max="5" step="0.5" 
                                           class="w-full px-2 py-1 border border-gray-300 rounded text-sm">
                                </div>
                                <div>
                                    <label class="block text-xs text-gray-600 mb-1">Kanan</label>
                                    <input type="number" id="marginRight" value="1.5" min="0" max="5" step="0.5" 
                                           class="w-full px-2 py-1 border border-gray-300 rounded text-sm">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Header & Footer Settings -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold mb-4">Header & Footer</h3>
                        
                        <!-- Header Settings -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Header</label>
                            <div class="space-y-2">
                                <label class="flex items-center">
                                    <input type="checkbox" id="showHeader" checked class="mr-2 text-blue-600">
                                    Tampilkan Header
                                </label>
                                <textarea id="headerText" rows="3" placeholder="Masukkan teks header..." 
                                          class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">PT KRAKATAU SAMUDERA SOLUSI
Laporan Dokumen Shipping Instruction</textarea>
                                <div class="flex gap-2">
                                    <select id="headerAlign" class="px-2 py-1 border border-gray-300 rounded text-sm">
                                        <option value="left">Kiri</option>
                                        <option value="center" selected>Tengah</option>
                                        <option value="right">Kanan</option>
                                    </select>
                                    <select id="headerSize" class="px-2 py-1 border border-gray-300 rounded text-sm">
                                        <option value="12">12px</option>
                                        <option value="14">14px</option>
                                        <option value="16" selected>16px</option>
                                        <option value="18">18px</option>
                                        <option value="20">20px</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Footer Settings -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Footer</label>
                            <div class="space-y-2">
                                <label class="flex items-center">
                                    <input type="checkbox" id="showFooter" checked class="mr-2 text-blue-600">
                                    Tampilkan Footer
                                </label>
                                <textarea id="footerText" rows="2" placeholder="Masukkan teks footer..." 
                                          class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">SISKA System Report</textarea>
                                <div class="flex gap-2">
                                    <select id="footerAlign" class="px-2 py-1 border border-gray-300 rounded text-sm">
                                        <option value="left">Kiri</option>
                                        <option value="center" selected>Tengah</option>
                                        <option value="right">Kanan</option>
                                    </select>
                                    <select id="footerSize" class="px-2 py-1 border border-gray-300 rounded text-sm">
                                        <option value="10">10px</option>
                                        <option value="11" selected>11px</option>
                                        <option value="12">12px</option>
                                        <option value="14">14px</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Additional Options -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Opsi Tambahan</label>
                            <div class="space-y-2">
                                <label class="flex items-center">
                                    <input type="checkbox" id="showPageNumber" checked class="mr-2 text-blue-600">
                                    Tampilkan Nomor Halaman
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" id="showPrintDate" checked class="mr-2 text-blue-600">
                                    Tampilkan Tanggal Cetak
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" id="showTotalRows" checked class="mr-2 text-blue-600">
                                    Tampilkan Total Data
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Preview Settings -->
                <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                    <h4 class="text-sm font-medium text-gray-700 mb-2">Preview Pengaturan</h4>
                    <div class="text-xs text-gray-600 space-y-1">
                        <div>Ukuran: <span id="previewSize">A4</span> - <span id="previewOrientation">Portrait</span></div>
                        <div>Margin: <span id="previewMargin">T:2cm B:2cm L:1.5cm R:1.5cm</span></div>
                        <div>Header: <span id="previewHeader">Aktif</span> | Footer: <span id="previewFooter">Aktif</span></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Footer -->
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end gap-3">
            <button onclick="closeColumnModal()" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition duration-200">
                Batal
            </button>
            <button onclick="applyChanges()" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200">
                Simpan
            </button>
        </div>
    </div>
</div>

<script>
let availableColumnsData = [];
let selectedColumnsData = @json($selectedColumns);

// Load available columns
async function loadAvailableColumns() {
    try {
        const response = await fetch('{{ route("report.columns") }}');
        const data = await response.json();
        availableColumnsData = data.columns;
        renderColumns();
    } catch (error) {
        console.error('Error loading columns:', error);
    }
}

function renderColumns() {
    const availableContainer = document.getElementById('availableColumns');
    const selectedContainer = document.getElementById('selectedColumns');
    
    // Clear containers
    availableContainer.innerHTML = '';
    selectedContainer.innerHTML = '';
    
    // Render available columns
    availableColumnsData.forEach(column => {
        if (!selectedColumnsData.includes(column.key)) {
            const div = document.createElement('div');
            div.className = 'flex items-center justify-between p-2 hover:bg-gray-50 rounded';
            div.innerHTML = `
                <span class="text-sm">${column.name}</span>
                <button onclick="addColumn('${column.key}')" class="text-blue-600 hover:text-blue-800">
                    <i class="fas fa-plus"></i>
                </button>
            `;
            availableContainer.appendChild(div);
        }
    });
    
    // Render selected columns
    selectedColumnsData.forEach((columnKey, index) => {
        const column = availableColumnsData.find(c => c.key === columnKey);
        if (column) {
            const div = document.createElement('div');
            div.className = 'flex items-center justify-between p-2 bg-blue-50 rounded border-l-4 border-blue-500';
            div.innerHTML = `
                <span class="text-sm font-medium">${column.name}</span>
                <div class="flex items-center gap-2">
                    <button onclick="moveUp(${index})" class="text-gray-600 hover:text-gray-800" ${index === 0 ? 'disabled' : ''}>
                        <i class="fas fa-chevron-up"></i>
                    </button>
                    <button onclick="moveDown(${index})" class="text-gray-600 hover:text-gray-800" ${index === selectedColumnsData.length - 1 ? 'disabled' : ''}>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <button onclick="removeColumn('${column.key}')" class="text-red-600 hover:text-red-800">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            `;
            selectedContainer.appendChild(div);
        }
    });
}

function addColumn(columnKey) {
    if (!selectedColumnsData.includes(columnKey)) {
        selectedColumnsData.push(columnKey);
        renderColumns();
    }
}

function removeColumn(columnKey) {
    selectedColumnsData = selectedColumnsData.filter(key => key !== columnKey);
    renderColumns();
}

function moveUp(index) {
    if (index > 0) {
        [selectedColumnsData[index], selectedColumnsData[index - 1]] = [selectedColumnsData[index - 1], selectedColumnsData[index]];
        renderColumns();
    }
}

function moveDown(index) {
    if (index < selectedColumnsData.length - 1) {
        [selectedColumnsData[index], selectedColumnsData[index + 1]] = [selectedColumnsData[index + 1], selectedColumnsData[index]];
        renderColumns();
    }
}

function openColumnModal() {
    document.getElementById('columnModal').classList.remove('hidden');
    loadAvailableColumns();
}

function closeColumnModal() {
    document.getElementById('columnModal').classList.add('hidden');
}

function openPeriodModal() {
    document.getElementById('columnModal').classList.remove('hidden');
    // Switch to period tab
    switchTab('period');
}

function switchTab(tab) {
    const columnDataTab = document.getElementById('columnDataTab');
    const periodTab = document.getElementById('periodTab');
    const pageSettingsTab = document.getElementById('pageSettingsTab');
    const columnDataContent = document.getElementById('columnDataContent');
    const periodContent = document.getElementById('periodContent');
    const pageSettingsContent = document.getElementById('pageSettingsContent');
    
    // Reset all tabs
    columnDataTab.className = 'px-6 py-3 text-sm font-medium text-gray-500 hover:text-gray-700 bg-gray-50';
    periodTab.className = 'px-6 py-3 text-sm font-medium text-gray-500 hover:text-gray-700 bg-gray-50';
    pageSettingsTab.className = 'px-6 py-3 text-sm font-medium text-gray-500 hover:text-gray-700 bg-gray-50';
    columnDataContent.classList.add('hidden');
    periodContent.classList.add('hidden');
    pageSettingsContent.classList.add('hidden');
    
    // Activate selected tab
    if (tab === 'period') {
        periodTab.className = 'px-6 py-3 text-sm font-medium text-red-600 border-b-2 border-red-600 bg-white';
        periodContent.classList.remove('hidden');
    } else if (tab === 'pageSettings') {
        pageSettingsTab.className = 'px-6 py-3 text-sm font-medium text-red-600 border-b-2 border-red-600 bg-white';
        pageSettingsContent.classList.remove('hidden');
    } else {
        columnDataTab.className = 'px-6 py-3 text-sm font-medium text-red-600 border-b-2 border-red-600 bg-white';
        columnDataContent.classList.remove('hidden');
    }
}

function applyChanges() {
    // Update preview dulu
    updatePdfPreview();
    
    // Kemudian lakukan submit form seperti biasa
    setTimeout(() => {
        // Create form and submit with new parameters
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("report.show") }}';
        
        // Add CSRF token
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = '{{ csrf_token() }}';
        form.appendChild(csrfInput);
        
        // Add date inputs
        const dateFromInput = document.createElement('input');
        dateFromInput.type = 'hidden';
        dateFromInput.name = 'date_from';
        dateFromInput.value = document.getElementById('editDateFrom').value;
        form.appendChild(dateFromInput);
        
        const dateToInput = document.createElement('input');
        dateToInput.type = 'hidden';
        dateToInput.name = 'date_to';
        dateToInput.value = document.getElementById('editDateTo').value;
        form.appendChild(dateToInput);
        
        // Add selected columns
        selectedColumnsData.forEach(column => {
            const columnInput = document.createElement('input');
            columnInput.type = 'hidden';
            columnInput.name = 'columns[]';
            columnInput.value = column;
            form.appendChild(columnInput);
        });
        
        // Add page settings
        const pageSettings = {
            paper_size: document.getElementById('paperSize').value,
            orientation: document.querySelector('input[name="orientation"]:checked').value,
            margin_top: document.getElementById('marginTop').value,
            margin_bottom: document.getElementById('marginBottom').value,
            margin_left: document.getElementById('marginLeft').value,
            margin_right: document.getElementById('marginRight').value,
            show_header: document.getElementById('showHeader').checked,
            header_text: document.getElementById('headerText').value,
            header_align: document.getElementById('headerAlign').value,
            header_size: document.getElementById('headerSize').value,
            show_footer: document.getElementById('showFooter').checked,
            footer_text: document.getElementById('footerText').value,
            footer_align: document.getElementById('footerAlign').value,
            footer_size: document.getElementById('footerSize').value,
            show_page_number: document.getElementById('showPageNumber').checked,
            show_print_date: document.getElementById('showPrintDate').checked,
            show_total_rows: document.getElementById('showTotalRows').checked
        };
        
        Object.keys(pageSettings).forEach(key => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = `page_settings[${key}]`;
            input.value = pageSettings[key];
            form.appendChild(input);
        });
        
        document.body.appendChild(form);
        form.submit();
    }, 500); // Delay sedikit agar preview ter-update dulu
}

// Tab event listeners - update untuk 3 tabs
document.getElementById('columnDataTab').addEventListener('click', () => switchTab('columnData'));
document.getElementById('periodTab').addEventListener('click', () => switchTab('period'));
document.getElementById('pageSettingsTab').addEventListener('click', () => switchTab('pageSettings'));

// Search functionality
document.getElementById('columnSearch').addEventListener('input', function() {
    const searchTerm = this.value.toLowerCase();
    const availableContainer = document.getElementById('availableColumns');
    const items = availableContainer.querySelectorAll('div');
    
    items.forEach(item => {
        const text = item.textContent.toLowerCase();
        if (text.includes(searchTerm)) {
            item.style.display = 'flex';
        } else {
            item.style.display = 'none';
        }
    });
});

// Preview update functions
function updatePreview() {
    const size = document.getElementById('paperSize').value;
    const orientation = document.querySelector('input[name="orientation"]:checked').value;
    const marginTop = document.getElementById('marginTop').value;
    const marginBottom = document.getElementById('marginBottom').value;
    const marginLeft = document.getElementById('marginLeft').value;
    const marginRight = document.getElementById('marginRight').value;
    const showHeader = document.getElementById('showHeader').checked;
    const showFooter = document.getElementById('showFooter').checked;
    
    document.getElementById('previewSize').textContent = size;
    document.getElementById('previewOrientation').textContent = orientation === 'portrait' ? 'Portrait' : 'Landscape';
    document.getElementById('previewMargin').textContent = `T:${marginTop}cm B:${marginBottom}cm L:${marginLeft}cm R:${marginRight}cm`;
    document.getElementById('previewHeader').textContent = showHeader ? 'Aktif' : 'Nonaktif';
    document.getElementById('previewFooter').textContent = showFooter ? 'Aktif' : 'Nonaktif';
}

// Add event listeners untuk preview update
document.addEventListener('DOMContentLoaded', function() {
    const pageSettingsInputs = document.querySelectorAll('#pageSettingsContent input, #pageSettingsContent select, #pageSettingsContent textarea');
    pageSettingsInputs.forEach(input => {
        input.addEventListener('change', updatePreview);
    });
    
    // Initial preview
    updatePreview();
});

// Function untuk reload preview saat ada perubahan
function updatePdfPreview() {
    const iframe = document.getElementById('pdfPreview');
    const currentUrl = new URL(iframe.src);
    
    // Update URL dengan parameter terbaru
    currentUrl.searchParams.set('date_from', document.getElementById('editDateFrom')?.value || '{{ request("date_from") }}');
    currentUrl.searchParams.set('date_to', document.getElementById('editDateTo')?.value || '{{ request("date_to") }}');
    
    // Add selected columns
    selectedColumnsData.forEach((column, index) => {
        currentUrl.searchParams.set(`columns[${index}]`, column);
    });
    
    // Add page settings
    if (typeof getPageSettings === 'function') {
        const pageSettings = getPageSettings();
        Object.keys(pageSettings).forEach(key => {
            currentUrl.searchParams.set(`page_settings[${key}]`, pageSettings[key]);
        });
    }
    
    iframe.src = currentUrl.toString();
}
</script>
@endsection