@extends('layouts.app')

@section('title', 'SI Overview')
@section('page-title', 'Shipping Instruction Overview')

@section('content')
<div class="bg-white rounded-xl shadow-sm p-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-4 gap-4">
        <h3 class="text-lg font-bold text-gray-800">Shipping Instruction List</h3>
        <div class="flex gap-2">
            <input type="text" id="siSearchInput" placeholder="Search..." class="px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
            <!-- Filter Button -->
            <button id="filterBtn" class="px-4 py-2 bg-gray-100 border border-gray-300 rounded-lg hover:bg-gray-200 flex items-center gap-2">
                <i class="fas fa-filter"></i>
                Filter
            </button>
        </div>
    </div>
    <div class="overflow-x-auto">
        <table id="siTable" class="min-w-full bg-white border border-gray-200 rounded-lg">
            <thead>
                <tr class="bg-gray-50 text-gray-700 text-sm text-center">
                    <th class="px-3 py-3 border-b w-12">No</th>
                    <th class="px-4 py-3 border-b w-32">SI Number</th>
                    <th class="px-4 py-3 border-b w-40">Vendor</th>
                    <th class="px-4 py-3 border-b w-48">Tug/Barge</th>
                    <th class="px-4 py-3 border-b w-36">Shipper</th>
                    <th class="px-4 py-3 border-b w-36">Commodities</th>
                    <th class="px-4 py-3 border-b w-32">Quantity</th>
                    <th class="px-3 py-3 border-b w-20">Status</th>
                    <th class="px-4 py-3 border-b w-32">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($shippingInstructions as $si)
                <tr class="hover:bg-gray-50">
                    <td class="px-3 py-3 border-b text-center text-gray-600 text-sm">
                        {{ ($shippingInstructions->currentPage() - 1) * $shippingInstructions->perPage() + $loop->iteration }}
                    </td>
                    <td class="px-4 py-3 border-b text-gray-800 text-sm font-medium">{{ $si->number }}</td>
                    <td class="px-4 py-3 border-b text-gray-700 text-sm">{{ $si->to }}</td>
                    <td class="px-4 py-3 border-b text-gray-700 text-sm">{{ $si->tugbarge }}</td>
                    <td class="px-4 py-3 border-b text-gray-700 text-sm">{{ $si->shipper }}</td>
                    <td class="px-4 py-3 border-b text-gray-700 text-sm">{{ $si->commodities }}</td>
                    <td class="px-4 py-3 border-b text-gray-700 text-sm">{{ $si->quantity }}</td>
                    <td class="px-3 py-3 border-b text-center">
                        @if($si->completed_at)
                            <span class="inline-block px-2 py-1 rounded text-xs font-semibold bg-green-100 text-green-700">Completed</span>
                        @else
                            <span class="inline-block px-2 py-1 rounded text-xs font-semibold bg-yellow-100 text-yellow-700">Only SI</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 border-b text-center">
                        <a href="{{ url('/shipping-instruction-preview/'.$si->id) }}" class="inline-flex items-center justify-center px-2 py-1 text-blue-600 hover:text-blue-800 text-xs font-medium rounded hover:bg-blue-50 transition" title="View">
                            <i class="fas fa-eye mr-1"></i> View
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="10" class="px-4 py-6 text-center text-gray-400">No Shipping Instructions found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4 flex justify-end">
        {{ $shippingInstructions->links() }}
    </div>
</div>

<!-- Filter Modal -->
<div id="filterModal" class="fixed inset-0 z-50 bg-black bg-opacity-30 flex items-center justify-center hidden">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6 relative">
        <button id="closeFilterModal" class="absolute top-3 right-3 text-gray-400 hover:text-gray-700">
            <i class="fas fa-times"></i>
        </button>
        <h4 class="text-lg font-semibold mb-4">Filter Shipping Instructions</h4>
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Dokumen</label>
                <input type="date" id="filterDate" class="w-full px-3 py-2 border rounded focus:ring-blue-500 focus:border-blue-500" />
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Vendor</label>
                <select id="filterVendor" class="w-full px-3 py-2 border rounded focus:ring-blue-500 focus:border-blue-500">
                    <option value="">-- Semua Vendor --</option>
                    @foreach(\App\Models\Vendor::orderBy('company')->get() as $vendor)
                        <option value="{{ $vendor->company }}">{{ $vendor->company }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Laycan</label>
                <div class="flex gap-2">
                    <input type="date" id="filterLaycanStart" class="w-1/2 px-3 py-2 border rounded focus:ring-blue-500 focus:border-blue-500" placeholder="From" />
                    <span class="flex items-center px-2">to</span>
                    <input type="date" id="filterLaycanEnd" class="w-1/2 px-3 py-2 border rounded focus:ring-blue-500 focus:border-blue-500" placeholder="To" />
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Signatory</label>
                <select id="filterSignatory" class="w-full px-3 py-2 border rounded focus:ring-blue-500 focus:border-blue-500">
                    <option value="">-- Semua Signatory --</option>
                    @foreach(\App\Models\Signatory::orderBy('name')->get() as $signatory)
                        <option value="{{ $signatory->name }}">{{ $signatory->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="mt-6 flex justify-end gap-2">
            <button id="resetFilter" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300 text-gray-700">Reset</button>
            <button id="applyFilter" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Apply</button>
        </div>
    </div>
</div>

<script>
document.getElementById('siSearchInput').addEventListener('input', filterTable);

function filterTable() {
    const search = document.getElementById('siSearchInput').value.toLowerCase();
    const filterDate = document.getElementById('filterDate')?.value;
    const filterVendor = document.getElementById('filterVendor')?.value.toLowerCase();
    const filterLaycanStart = document.getElementById('filterLaycanStart')?.value;
    const filterLaycanEnd = document.getElementById('filterLaycanEnd')?.value;
    const filterSignatory = document.getElementById('filterSignatory')?.value.toLowerCase();
    const rows = document.querySelectorAll('#siTable tbody tr');
    let visibleCount = 0;
    rows.forEach(row => {
        // Lewati baris "No Shipping Instructions found."
        if (row.querySelector('td') && row.querySelector('td').colSpan === 7) return;
        const text = row.textContent.toLowerCase();
        let show = text.includes(search);

        // Filter by Vendor
        if (filterVendor && !row.children[2].textContent.toLowerCase().includes(filterVendor)) show = false;

        // Filter by Laycan (tanggal dari dan sampai)
        if ((filterLaycanStart || filterLaycanEnd)) {
            let laycanText = '';
            for (let i = 0; i < row.children.length; i++) {
                if (row.children[i].textContent.toLowerCase().includes('laycan')) {
                    laycanText = row.children[i].textContent;
                    break;
                }
            }
            if (!laycanText) laycanText = row.textContent;
            const dateMatches = laycanText.match(/\d{4}-\d{2}-\d{2}/g);
            let laycanStart = dateMatches && dateMatches[0] ? dateMatches[0] : null;
            let laycanEnd = dateMatches && dateMatches[1] ? dateMatches[1] : null;
            if (filterLaycanStart && (!laycanStart || laycanStart < filterLaycanStart)) show = false;
            if (filterLaycanEnd && (!laycanEnd || laycanEnd > filterLaycanEnd)) show = false;
        }

        // Filter by Date
        if (filterDate) {
            const dateMatch = row.textContent.match(/\d{4}-\d{2}-\d{2}/);
            if (!dateMatch || dateMatch[0] !== filterDate) show = false;
        }

        // Filter by Signatory
        if (filterSignatory && !text.includes(filterSignatory)) show = false;

        if (show) {
            row.style.display = '';
            visibleCount++;
        } else {
            row.style.display = 'none';
        }
    });

    // Cek apakah perlu menampilkan pesan "Data tidak ditemukan"
    let notFoundRow = document.getElementById('notFoundRow');
    if (visibleCount === 0) {
        if (!notFoundRow) {
            notFoundRow = document.createElement('tr');
            notFoundRow.id = 'notFoundRow';
            notFoundRow.innerHTML = `<td colspan="7" class="px-4 py-6 text-center text-gray-400">Data tidak ditemukan.</td>`;
            document.querySelector('#siTable tbody').appendChild(notFoundRow);
        }
    } else {
        if (notFoundRow) notFoundRow.remove();
    }
}

// Filter modal logic
const filterBtn = document.getElementById('filterBtn');
const filterModal = document.getElementById('filterModal');
const closeFilterModal = document.getElementById('closeFilterModal');
const applyFilter = document.getElementById('applyFilter');
const resetFilter = document.getElementById('resetFilter');

filterBtn.addEventListener('click', () => filterModal.classList.remove('hidden'));
closeFilterModal.addEventListener('click', () => filterModal.classList.add('hidden'));
applyFilter.addEventListener('click', () => {
    filterModal.classList.add('hidden');
    filterTable();
});
resetFilter.addEventListener('click', () => {
    document.getElementById('filterDate').value = '';
    document.getElementById('filterVendor').value = '';
    document.getElementById('filterLaycanStart').value = '';
    document.getElementById('filterLaycanEnd').value = '';
    document.getElementById('filterSignatory').value = '';
    filterTable();
});
</script>
@endsection