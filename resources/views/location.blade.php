<x-app-layout>
    @section('title', 'Locations | TDS Attendance')

    @push('styles')
        <style>
            .location-stat-card,
            .location-table-card {
                border: 1px solid #e9eaf2;
                border-radius: 14px;
                box-shadow: 0 3px 14px rgba(31, 41, 80, .035);
                background: #fff;
            }

            .location-stat-icon {
                width: 40px;
                height: 40px;
                display: flex;
                align-items: center;
                justify-content: center;
                border-radius: 11px;
                font-size: 19px;
            }

            .location-icon-indigo {
                background: #eeeaff;
                color: #5b4acb;
            }

            .location-icon-green {
                background: #e0f8eb;
                color: #139765;
            }

            .location-icon-blue {
                background: #e1efff;
                color: #2471d8;
            }

            .location-icon-orange {
                background: #fff0dc;
                color: #d97706;
            }

            .location-page-title {
                font-family: "Momo Trust Display", sans-serif;
                font-size: 25px;
                font-weight: 400;
                color: #20243a;
            }

            .location-primary-btn {
                background: #5141b8;
                color: #fff;
                border: 1px solid #5141b8;
                border-radius: 9px;
                padding: 9px 14px;
                font-size: 12px;
                font-weight: 600;
            }

            .location-primary-btn:hover {
                background: #4233a0;
                color: #fff;
            }

            .location-filter {
                min-height: 36px;
                border: 1px solid #e2e5ef;
                border-radius: 8px;
                font-size: 12px;
            }

            .location-table-card .card-body {
                padding: 20px;
            }

            #locationsTable {
                font-size: 11.5px;
                width: 100% !important;
            }

            #locationsTable thead th {
                background: #f8f8fc;
                color: #777e95;
                padding: 12px 10px;
                border-bottom: 1px solid #e9eaf2;
                font-size: 9.5px;
                font-weight: 600;
                text-transform: uppercase;
                letter-spacing: .6px;
                white-space: nowrap;
            }

            #locationsTable tbody td {
                padding: 12px 10px;
                border-color: #f0f1f6;
                vertical-align: middle;
                color: #30364d;
            }

            #locationsTable tbody tr:hover td {
                background: #faf9ff;
            }

            .location-avatar {
                width: 37px;
                height: 37px;
                border-radius: 10px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                flex-shrink: 0;
                font-size: 16px;
            }

            .location-avatar-indigo {
                background: #eeeaff;
                color: #5b4acb;
            }

            .location-avatar-green {
                background: #e0f8eb;
                color: #139765;
            }

            .location-avatar-blue {
                background: #e1efff;
                color: #2471d8;
            }

            .location-avatar-orange {
                background: #fff0dc;
                color: #d97706;
            }

            .location-avatar-pink {
                background: #ffe5f0;
                color: #db2777;
            }

            .location-avatar-teal {
                background: #dff8f5;
                color: #0f9688;
            }

            .location-name {
                font-weight: 600;
                color: #252a42;
                font-size: 12px;
            }

            .location-muted {
                color: #858ba0;
                font-size: 10.5px;
            }

            .location-action {
                width: 29px;
                height: 29px;
                border: 1px solid #e8eaf2;
                border-radius: 8px;
                display: inline-flex;
                justify-content: center;
                align-items: center;
                background: #fff;
                color: #626a7e;
            }

            .location-action:hover {
                color: #5141b8;
                background: #f0edff;
            }

            #locationsTable_wrapper {
                font-size: 11px;
            }

            #locationsTable_wrapper .dt-search input,
            #locationsTable_wrapper .dt-length select {
                border: 1px solid #e2e5ef;
                border-radius: 8px;
                padding: 5px 9px;
                font-size: 11px;
            }

            .location-address {
                max-width: 300px;
                white-space: normal;
                overflow-wrap: anywhere;
            }

            @media (max-width: 767.98px) {
                .location-page-title {
                    font-size: 22px;
                }

                .location-table-card .card-body {
                    padding: 14px;
                }

                #locationsTable {
                    min-width: 850px;
                }
            }
        </style>
    @endpush

    @php
        $allLocations = $locations;
        $activeLocations = $allLocations->where('status', true)->count();
        $inactiveLocations = $allLocations->where('status', false)->count();
        $totalClasses = $allLocations->sum(fn($location) => $location->classes->count());
        $locationColors = ['indigo', 'green', 'blue', 'orange', 'pink', 'teal'];
    @endphp

    <div class="container-fluid px-0">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
            <div>
                <div class="text-secondary small mb-2">
                    <i class="bi bi-house-door me-1"></i> Home
                    <i class="bi bi-chevron-right mx-1"></i> Locations
                </div>
                {{-- <h2 class="location-page-title mb-1">Locations</h2>
                <p class="text-secondary small mb-0">Manage your class locations and the classes assigned to each place.
                </p> --}}

                <h2 class="page-heading fw-bold mb-1">Locations</h2>
                <p class="text-secondary mb-0">Manage your class locations and the classes assigned to each place.
                </p>
            </div>
            <button type="button" class="btn location-primary-btn" onclick="openCreateLocationModal()">
                <i class="bi bi-plus-lg me-2"></i>Add Location
            </button>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row g-3 mb-4">
            <div class="col-6 col-xl-3">
                <div class="card location-stat-card h-100">
                    <div class="card-body p-3">
                        <div class="d-flex justify-content-between align-items-start gap-2">
                            <div>
                                <div class="text-secondary small mb-2">Total Locations</div>
                                <h3 class="fw-semibold mb-1">{{ $allLocations->count() }}</h3>
                                <span class="location-muted">All registered locations</span>
                            </div>
                            <div class="location-stat-icon location-icon-indigo"><i class="bi bi-geo-alt"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-xl-3">
                <div class="card location-stat-card h-100">
                    <div class="card-body p-3">
                        <div class="d-flex justify-content-between align-items-start gap-2">
                            <div>
                                <div class="text-secondary small mb-2">Active Locations</div>
                                <h3 class="fw-semibold text-success mb-1">{{ $activeLocations }}</h3>
                                <span class="location-muted">Available for classes</span>
                            </div>
                            <div class="location-stat-icon location-icon-green"><i class="bi bi-check-circle"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-xl-3">
                <div class="card location-stat-card h-100">
                    <div class="card-body p-3">
                        <div class="d-flex justify-content-between align-items-start gap-2">
                            <div>
                                <div class="text-secondary small mb-2">Classes at Locations</div>
                                <h3 class="fw-semibold text-primary mb-1">{{ $totalClasses }}</h3>
                                <span class="location-muted">Across all locations</span>
                            </div>
                            <div class="location-stat-icon location-icon-blue"><i class="bi bi-music-note-list"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-xl-3">
                <div class="card location-stat-card h-100">
                    <div class="card-body p-3">
                        <div class="d-flex justify-content-between align-items-start gap-2">
                            <div>
                                <div class="text-secondary small mb-2">Inactive Locations</div>
                                <h3 class="fw-semibold text-warning mb-1">{{ $inactiveLocations }}</h3>
                                <span class="location-muted">Currently unavailable</span>
                            </div>
                            <div class="location-stat-icon location-icon-orange"><i class="bi bi-pause-circle"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card location-table-card">
            <div class="card-body">
                <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
                    <div>
                        <h5 class="fw-semibold mb-1">All Locations</h5>
                        <p class="location-muted mb-0">Review addresses, class counts, and location status.</p>
                    </div>
                    <button type="button" class="btn btn-outline-secondary btn-sm rounded-3" id="exportLocations">
                        <i class="bi bi-download me-1"></i>Export CSV
                    </button>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-12 col-md-6">
                        <label for="locationStatusFilter" class="form-label small fw-semibold">Status</label>
                        <select id="locationStatusFilter" class="form-select location-filter">
                            <option value="">All statuses</option>
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                    </div>
                    <div class="col-12 col-md-6">
                        <label for="locationClassFilter" class="form-label small fw-semibold">Classes</label>
                        <select id="locationClassFilter" class="form-select location-filter">
                            <option value="">All locations</option>
                            <option value="Has classes">Locations with classes</option>
                            <option value="No classes">Locations without classes</option>
                        </select>
                    </div>
                </div>

                <div class="table-responsive">
                    <table id="locationsTable" class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Location</th>
                                <th>Address</th>
                                <th>Classes</th>
                                <th>Created Date</th>
                                <th>Status</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($allLocations as $location)
                                @php
                                    $classCount = $location->classes->count();
                                    $color = $locationColors[$location->id % count($locationColors)];
                                    $initial = strtoupper(substr($location->name, 0, 1));
                                @endphp
                                <tr>
                                    <td data-search="{{ $location->name }}">
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="location-avatar location-avatar-{{ $color }}"><i
                                                    class="bi bi-geo-alt"></i></div>
                                            <div>
                                                <div class="location-name">{{ $location->name }}</div>
                                                <div class="location-muted">Location
                                                    #{{ str_pad($location->id, 3, '0', STR_PAD_LEFT) }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="location-address">{{ $location->address }}</div>
                                        @if ($location->notes)
                                            <div class="location-muted mt-1">
                                                {{ \Illuminate\Support\Str::limit($location->notes, 65) }}</div>
                                        @endif
                                    </td>
                                    <td data-search="{{ $classCount > 0 ? 'Has classes' : 'No classes' }}">
                                        <span
                                            class="badge rounded-pill {{ $classCount > 0 ? 'text-bg-primary bg-opacity-10 text-primary' : 'text-bg-light text-secondary border' }} px-3 py-2">
                                            <i class="bi bi-music-note-list me-1"></i>{{ $classCount }}
                                        </span>
                                    </td>
                                    <td data-order="{{ $location->created_at?->format('Y-m-d') }}">
                                        {{ $location->created_at?->format('d M Y') ?? '—' }}
                                    </td>
                                    <td data-search="{{ $location->status ? 'Active' : 'Inactive' }}">
                                        @if ($location->status)
                                            <span
                                                class="badge rounded-pill text-bg-success bg-opacity-10 text-success px-3 py-2"><i
                                                    class="bi bi-check-circle-fill me-1"></i>Active</span>
                                        @else
                                            <span
                                                class="badge rounded-pill text-bg-secondary bg-opacity-10 text-secondary px-3 py-2"><i
                                                    class="bi bi-pause-circle-fill me-1"></i>Inactive</span>
                                        @endif
                                    </td>
                                    <td class="text-end text-nowrap">
                                        <button type="button" class="location-action me-1" title="View location"
                                            onclick="viewLocation(this)" data-id="{{ $location->id }}"
                                            data-name="{{ $location->name }}"
                                            data-address="{{ $location->address }}"
                                            data-notes="{{ $location->notes ?? '' }}"
                                            data-classes="{{ $classCount }}"
                                            data-class-names="{{ $location->classes->pluck('name')->implode(', ') }}"
                                            data-created="{{ $location->created_at?->format('d M Y') ?? '—' }}"
                                            data-status="{{ $location->status ? 'Active' : 'Inactive' }}">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        <button type="button" class="location-action me-1" title="Edit location"
                                            onclick="editLocation(this)" data-id="{{ $location->id }}"
                                            data-name="{{ $location->name }}"
                                            data-address="{{ $location->address }}"
                                            data-notes="{{ $location->notes ?? '' }}"
                                            data-status="{{ $location->status ? 1 : 0 }}">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button type="button" class="location-action" title="Delete location"
                                            onclick="confirmDeleteLocation({{ $location->id }}, @js($location->name), {{ $classCount }})">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-secondary py-5">
                                        <i class="bi bi-geo-alt fs-3 d-block mb-2"></i>
                                        No locations registered yet. Add your first location.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Create and edit location modal --}}
    <div class="modal fade" id="locationModal" tabindex="-1" aria-labelledby="locationModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 rounded-4 shadow">
                <div class="modal-header border-0 px-4 pt-4">
                    <div>
                        <h5 class="modal-title fw-semibold" id="locationModalLabel">Add Location</h5>
                        <p class="location-muted mb-0">Enter the location details below.</p>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form id="locationForm" method="POST" action="{{ route('locations.store') }}">
                    @csrf
                    <input type="hidden" name="_method" id="locationFormMethod" value="POST">
                    <div class="modal-body px-4">
                        <div id="locationFormErrors" class="alert alert-danger d-none"></div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="locationName" class="form-label">Location name <span
                                        class="text-danger">*</span></label>
                                <input id="locationName" name="name" type="text" class="form-control"
                                    value="{{ old('name') }}" placeholder="e.g. Kiribathgoda" maxlength="255"
                                    required>
                                @error('name')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="locationStatus" class="form-label">Status</label>
                                <select id="locationStatus" name="status" class="form-select">
                                    <option value="1" @selected(old('status', '1') == '1')>Active</option>
                                    <option value="0" @selected(old('status') === '0')>Inactive</option>
                                </select>
                                @error('status')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12">
                                <label for="locationAddress" class="form-label">Address <span
                                        class="text-danger">*</span></label>
                                <textarea id="locationAddress" name="address" class="form-control" rows="2"
                                    placeholder="Enter the full location address" maxlength="1000" required>{{ old('address') }}</textarea>
                                @error('address')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12">
                                <label for="locationNotes" class="form-label">Notes <span
                                        class="text-secondary">(optional)</span></label>
                                <textarea id="locationNotes" name="notes" class="form-control" rows="3"
                                    placeholder="Additional information about this location" maxlength="2000">{{ old('notes') }}</textarea>
                                @error('notes')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0 px-4 pb-4">
                        <button type="button" class="btn btn-light rounded-3"
                            data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn location-primary-btn" id="saveLocationButton"><i
                                class="bi bi-check-lg me-1"></i>Save Location</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- View location modal --}}
    <div class="modal fade" id="viewLocationModal" tabindex="-1" aria-labelledby="viewLocationModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 rounded-4 shadow">
                <div class="modal-header">
                    <h5 class="modal-title fw-semibold" id="viewLocationModalLabel">Location Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="locationDetails"></div>
            </div>
        </div>
    </div>

    {{-- Delete location form --}}
    <form id="deleteLocationForm" method="POST" class="d-none">
        @csrf
        @method('DELETE')
    </form>

    @push('scripts')
        <script>
            $(function() {
                const table = $('#locationsTable').DataTable({
                    pageLength: 10,
                    lengthMenu: [5, 10, 25, 50],
                    order: [
                        [0, 'asc']
                    ],
                    autoWidth: false,
                    columnDefs: [{
                        orderable: false,
                        targets: 5
                    }],
                    language: {
                        search: '',
                        searchPlaceholder: 'Search locations...',
                        lengthMenu: 'Show _MENU_ locations',
                        info: 'Showing _START_ to _END_ of _TOTAL_ locations',
                        infoEmpty: 'No locations found',
                        zeroRecords: 'No matching locations found',
                        emptyTable: 'No locations registered yet.',
                        paginate: {
                            previous: '<i class="bi bi-chevron-left"></i>',
                            next: '<i class="bi bi-chevron-right"></i>'
                        }
                    }
                });

                $('#locationStatusFilter').on('change', function() {
                    table.column(4).search(
                        this.value ? '^' + $.fn.dataTable.util.escapeRegex(this.value) + '$' : '',
                        true,
                        false
                    ).draw();
                });

                $('#locationClassFilter').on('change', function() {
                    table.column(2).search(
                        this.value ? '^' + $.fn.dataTable.util.escapeRegex(this.value) + '$' : '',
                        true,
                        false
                    ).draw();
                });

                $('#exportLocations').on('click', function() {
                    const rows = table.rows({
                        search: 'applied'
                    }).nodes().toArray();
                    const csvRows = [
                        ['Location', 'Address', 'Classes', 'Created Date', 'Status'],
                        ...rows.map(row => Array.from(row.cells).slice(0, 5).map(cell => cell.innerText
                            .trim().replace(/\s+/g, ' ')))
                    ];
                    const csv = csvRows.map(row => row.map(value => '"' + String(value).replace(/"/g, '""') +
                        '"').join(',')).join('\r\n');
                    const blob = new Blob(['\uFEFF' + csv], {
                        type: 'text/csv;charset=utf-8;'
                    });
                    const url = URL.createObjectURL(blob);
                    const link = document.createElement('a');
                    link.href = url;
                    link.download = 'locations.csv';
                    document.body.appendChild(link);
                    link.click();
                    link.remove();
                    URL.revokeObjectURL(url);
                });

                @if ($errors->any())
                    bootstrap.Modal.getOrCreateInstance(document.getElementById('locationModal')).show();
                @endif
            });

            function openCreateLocationModal() {
                const form = document.getElementById('locationForm');
                form.action = @json(route('locations.store'));
                document.getElementById('locationFormMethod').value = 'POST';
                document.getElementById('locationModalLabel').textContent = 'Add Location';
                document.getElementById('saveLocationButton').innerHTML = '<i class="bi bi-check-lg me-1"></i>Save Location';
                form.reset();
                document.getElementById('locationStatus').value = '1';
                document.getElementById('locationFormErrors').classList.add('d-none');
                bootstrap.Modal.getOrCreateInstance(document.getElementById('locationModal')).show();
            }

            function editLocation(button) {
                const form = document.getElementById('locationForm');
                form.action = @json(url('/locations')) + '/' + button.dataset.id;
                document.getElementById('locationFormMethod').value = 'PUT';
                document.getElementById('locationModalLabel').textContent = 'Edit Location';
                document.getElementById('saveLocationButton').innerHTML = '<i class="bi bi-check-lg me-1"></i>Update Location';
                document.getElementById('locationName').value = button.dataset.name || '';
                document.getElementById('locationAddress').value = button.dataset.address || '';
                document.getElementById('locationNotes').value = button.dataset.notes || '';
                document.getElementById('locationStatus').value = button.dataset.status || '1';
                document.getElementById('locationFormErrors').classList.add('d-none');
                bootstrap.Modal.getOrCreateInstance(document.getElementById('locationModal')).show();
            }

            function viewLocation(button) {
                const details = document.getElementById('locationDetails');
                details.replaceChildren();

                const heading = document.createElement('div');
                heading.className = 'd-flex align-items-center gap-3 mb-3';
                const icon = document.createElement('div');
                icon.className = 'location-avatar location-avatar-indigo';
                icon.innerHTML = '<i class="bi bi-geo-alt"></i>';

                const info = document.createElement('div');
                const name = document.createElement('h6');
                name.className = 'fw-semibold mb-1';
                name.textContent = button.dataset.name || 'Location';
                const id = document.createElement('div');
                id.className = 'location-muted';
                id.textContent = 'Location #' + String(button.dataset.id).padStart(3, '0');
                info.append(name, id);
                heading.append(icon, info);
                details.append(heading);

                const fields = [
                    ['Address', button.dataset.address],
                    ['Classes', button.dataset.classes],
                    ['Class names', button.dataset.classNames || 'No classes assigned'],
                    ['Created date', button.dataset.created],
                    ['Status', button.dataset.status],
                    ['Notes', button.dataset.notes || 'No notes']
                ];

                const list = document.createElement('div');
                list.className = 'list-group list-group-flush';
                fields.forEach(([label, value]) => {
                    const row = document.createElement('div');
                    row.className = 'list-group-item d-flex justify-content-between gap-3 px-0';
                    const key = document.createElement('span');
                    key.className = 'text-secondary';
                    key.textContent = label;
                    const val = document.createElement('strong');
                    val.className = 'text-end';
                    val.style.maxWidth = '65%';
                    val.style.overflowWrap = 'anywhere';
                    val.textContent = value || '—';
                    row.append(key, val);
                    list.append(row);
                });
                details.append(list);
                bootstrap.Modal.getOrCreateInstance(document.getElementById('viewLocationModal')).show();
            }

            function confirmDeleteLocation(id, name, classCount) {
                if (classCount > 0) {
                    alert('This location has ' + classCount +
                        ' class(es). Move or remove those classes before deleting the location.');
                    return;
                }

                if (!confirm('Delete the location "' + name + '"?')) return;

                const form = document.getElementById('deleteLocationForm');
                form.action = @json(url('/locations')) + '/' + id;
                form.submit();
            }
        </script>
    @endpush
</x-app-layout>
