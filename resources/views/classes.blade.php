<x-app-layout>
    @section('title', 'Classes | TDS Attendance')

    @push('styles')
    <style>
        .class-stat-card,
        .class-table-card {
            border: 1px solid #e9eaf2;
            border-radius: 14px;
            box-shadow: 0 3px 14px rgba(31, 41, 80, .035);
            background: #fff
        }

        .class-stat-icon {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 11px;
            font-size: 19px
        }

        .class-icon-indigo {
            background: #eeeaff;
            color: #5b4acb
        }

        .class-icon-green {
            background: #e0f8eb;
            color: #139765
        }

        .class-icon-blue {
            background: #e1efff;
            color: #2471d8
        }

        .class-icon-orange {
            background: #fff0dc;
            color: #d97706
        }

        .class-page-title {
            font-family: "Momo Trust Display", sans-serif;
            font-size: 25px;
            font-weight: 400;
            letter-spacing: -.4px;
            color: #20243a
        }

        .class-primary-btn {
            background: #5141b8;
            color: #fff;
            border: 1px solid #5141b8;
            border-radius: 9px;
            padding: 9px 14px;
            font-size: 12px;
            font-weight: 600
        }

        .class-primary-btn:hover {
            background: #4233a0;
            color: #fff
        }

        .class-filter {
            min-height: 36px;
            border: 1px solid #e2e5ef;
            border-radius: 8px;
            font-size: 12px
        }

        .class-table-card .card-body {
            padding: 20px
        }

        #classesTable {
            font-size: 11.5px;
            width: 100% !important
        }

        #classesTable thead th {
            background: #f8f8fc;
            color: #777e95;
            padding: 12px 10px;
            border-bottom: 1px solid #e9eaf2;
            font-size: 9.5px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .6px;
            white-space: nowrap
        }

        #classesTable tbody td {
            padding: 12px 10px;
            border-color: #f0f1f6;
            vertical-align: middle;
            color: #30364d
        }

        #classesTable tbody tr:hover td {
            background: #faf9ff
        }

        .class-subject-icon {
            width: 35px;
            height: 35px;
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            flex-shrink: 0
        }

        .subject-indigo {
            background: #eeeaff;
            color: #5b4acb
        }

        .subject-green {
            background: #e0f8eb;
            color: #139765
        }

        .subject-blue {
            background: #e1efff;
            color: #2471d8
        }

        .subject-orange {
            background: #fff0dc;
            color: #d97706
        }

        .subject-pink {
            background: #ffe5f0;
            color: #db2777
        }

        .subject-teal {
            background: #dff8f5;
            color: #0f9688
        }

        .class-name {
            font-weight: 600;
            color: #252a42;
            font-size: 12px
        }

        .class-muted {
            color: #858ba0;
            font-size: 10.5px
        }

        .class-action {
            width: 29px;
            height: 29px;
            border: 1px solid #e8eaf2;
            border-radius: 8px;
            display: inline-flex;
            justify-content: center;
            align-items: center;
            background: #fff;
            color: #626a7e
        }

        .class-action:hover {
            color: #5141b8;
            background: #f0edff
        }

        .class-day {
            display: inline-block;
            background: #f1efff;
            color: #5b4acb;
            border-radius: 5px;
            padding: 4px 6px;
            margin: 2px 2px 2px 0;
            font-size: 9px;
            font-weight: 600
        }

        #classesTable_wrapper {
            font-size: 11px
        }

        #classesTable_wrapper .dt-search input,
        #classesTable_wrapper .dt-length select {
            border: 1px solid #e2e5ef;
            border-radius: 8px;
            padding: 5px 9px;
            font-size: 11px
        }

        .class-day-checks {
            display: flex;
            flex-wrap: wrap;
            gap: 10px 16px
        }

        @media(max-width:767.98px) {
            .class-page-title {
                font-size: 22px
            }

            .class-table-card .card-body {
                padding: 14px
            }

            #classesTable {
                min-width: 950px
            }
        }
    </style>
    @endpush

    @php
    $dayLabels = [
    1 => 'Mon',
    2 => 'Tue',
    3 => 'Wed',
    4 => 'Thu',
    5 => 'Fri',
    6 => 'Sat',
    7 => 'Sun',
    ];

    $dayFullLabels = [
    1 => 'Monday',
    2 => 'Tuesday',
    3 => 'Wednesday',
    4 => 'Thursday',
    5 => 'Friday',
    6 => 'Saturday',
    7 => 'Sunday',
    ];

    $allClasses = $classes;
    $activeClasses = $allClasses->where('status', true)->count();
    $inactiveClasses = $allClasses->where('status', false)->count();
    $totalEnrolments = $allClasses->sum(fn($class) => $class->registrations->where('status', true)->count());
    $avatarColors = ['indigo', 'green', 'blue', 'orange', 'pink', 'teal'];
    @endphp

    <div class="container-fluid px-0">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
            <div>
                <div class="text-secondary small mb-2"><i class="bi bi-house-door me-1"></i> Home <i
                        class="bi bi-chevron-right mx-1"></i> Classes</div>
                <h2 class="class-page-title mb-1">Classes</h2>
                <p class="text-secondary small mb-0">Manage your dance classes, schedules, locations, and fees.</p>
            </div>
            <button type="button" class="btn class-primary-btn" onclick="openCreateClassModal()"><i
                    class="bi bi-plus-lg me-2"></i>Create Class</button>
        </div>

        @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert"><i
                class="bi bi-check-circle me-2"></i>{{ session('success') }}<button type="button" class="btn-close"
                data-bs-dismiss="alert" aria-label="Close"></button></div>
        @endif
        @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">{{ session('error') }}<button
                type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>
        @endif

        <div class="row g-3 mb-4">
            <div class="col-6 col-xl-3">
                <div class="card class-stat-card h-100">
                    <div class="card-body p-3">
                        <div class="d-flex justify-content-between align-items-start gap-2">
                            <div>
                                <div class="text-secondary small mb-2">Total Classes</div>
                                <h3 class="fw-semibold mb-1">{{ $allClasses->count() }}</h3><span
                                    class="class-muted">All registered classes</span>
                            </div>
                            <div class="class-stat-icon class-icon-indigo"><i class="bi bi-collection"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-xl-3">
                <div class="card class-stat-card h-100">
                    <div class="card-body p-3">
                        <div class="d-flex justify-content-between align-items-start gap-2">
                            <div>
                                <div class="text-secondary small mb-2">Active Classes</div>
                                <h3 class="fw-semibold text-success mb-1">{{ $activeClasses }}</h3><span
                                    class="class-muted">Currently running</span>
                            </div>
                            <div class="class-stat-icon class-icon-green"><i class="bi bi-check-circle"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-xl-3">
                <div class="card class-stat-card h-100">
                    <div class="card-body p-3">
                        <div class="d-flex justify-content-between align-items-start gap-2">
                            <div>
                                <div class="text-secondary small mb-2">Total Enrolments</div>
                                <h3 class="fw-semibold text-primary mb-1">{{ $totalEnrolments }}</h3><span
                                    class="class-muted">Active class registrations</span>
                            </div>
                            <div class="class-stat-icon class-icon-blue"><i class="bi bi-people"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-xl-3">
                <div class="card class-stat-card h-100">
                    <div class="card-body p-3">
                        <div class="d-flex justify-content-between align-items-start gap-2">
                            <div>
                                <div class="text-secondary small mb-2">Inactive Classes</div>
                                <h3 class="fw-semibold text-warning mb-1">{{ $inactiveClasses }}</h3><span
                                    class="class-muted">Paused classes</span>
                            </div>
                            <div class="class-stat-icon class-icon-orange"><i class="bi bi-pause-circle"></i></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card class-table-card">
            <div class="card-body">
                <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
                    <div>
                        <h5 class="fw-semibold mb-1">All Classes</h5>
                        <p class="class-muted mb-0">Review class schedules, locations, enrolments, and monthly fees.</p>
                    </div><button type="button" class="btn btn-outline-secondary btn-sm rounded-3"
                        id="exportClasses"><i class="bi bi-download me-1"></i>Export CSV</button>
                </div>
                <div class="row g-3 mb-4">
                    <div class="col-12 col-md-4"><label for="classStatusFilter"
                            class="form-label small fw-semibold">Status</label><select id="classStatusFilter"
                            class="form-select class-filter">
                            <option value="">All statuses</option>
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select></div>
                    <div class="col-12 col-md-4"><label for="classLocationFilter"
                            class="form-label small fw-semibold">Location</label><select id="classLocationFilter"
                            class="form-select class-filter">
                            <option value="">All locations</option>
                            @foreach ($allClasses->pluck('location.name')->filter()->unique()->sort() as $locationName)
                            <option value="{{ $locationName }}">{{ $locationName }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-md-4"><label for="classDayFilter" class="form-label small fw-semibold">Class
                            day</label><select id="classDayFilter" class="form-select class-filter">
                            <option value="">All days</option>
                            @foreach (['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'] as $day)
                            <option value="{{ $day }}">{{ $day }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="table-responsive">
                    <table id="classesTable" class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Class</th>
                                <th>Class ID</th>
                                <th>Location</th>
                                <th>Schedule</th>
                                <th>Students</th>
                                <th>Monthly Fee</th>
                                <th>Status</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($allClasses as $class)
                            @php
                            $dayNumbers = $class->days
                            ->pluck('day_of_week')
                            ->map(fn($day) => (int) $day)
                            ->all();
                            $dayNames = collect($dayNumbers)
                            ->map(fn($day) => $dayLabels[$day] ?? (string) $day)
                            ->values();
                            $studentCount = $class->registrations->where('status', true)->count();
                            $color = $avatarColors[$class->id % count($avatarColors)];
                            @endphp
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="class-subject-icon subject-{{ $color }}"><i
                                                class="bi bi-music-note-beamed"></i></div>
                                        <div>
                                            <div class="class-name">{{ $class->name }}</div>
                                            <div class="class-muted">Dancing</div>
                                        </div>
                                    </div>
                                </td>
                                <td><span
                                        class="badge rounded-pill text-bg-light border">CLS-{{ str_pad($class->id, 3, '0', STR_PAD_LEFT) }}</span>
                                </td>
                                <td data-search="{{ $class->location?->name ?? 'No location' }}"><span
                                        class="d-inline-flex align-items-center gap-1"><i
                                            class="bi bi-geo-alt text-primary"></i>{{ $class->location?->name ?? 'No location assigned' }}</span>
                                </td>
                                <td data-search="{{ $dayNames->implode(' ') }}">
                                    <div class="text-nowrap mb-1"><i
                                            class="bi bi-clock text-secondary me-1"></i>{{ \Carbon\Carbon::parse($class->start_time)->format('g:i A') }}
                                        - {{ \Carbon\Carbon::parse($class->end_time)->format('g:i A') }}</div>
                                    <div>
                                        @forelse($dayNames as $day)
                                        <span class="class-day">{{ $day }}</span>@empty<span
                                            class="class-muted">No days set</span>
                                        @endforelse
                                    </div>
                                </td>
                                <td><span
                                        class="badge rounded-pill text-bg-primary bg-opacity-10 text-primary px-3 py-2"><i
                                            class="bi bi-people me-1"></i>{{ $studentCount }}</span></td>
                                <td class="text-nowrap fw-semibold">LKR
                                    {{ number_format((float) $class->monthly_fee, 2) }}
                                </td>
                                <td data-search="{{ $class->status ? 'Active' : 'Inactive' }}">
                                    @if ($class->status)
                                    <span
                                        class="badge rounded-pill text-bg-success bg-opacity-10 text-success px-3 py-2"><i
                                            class="bi bi-check-circle-fill me-1"></i>Active</span>@else<span
                                        class="badge rounded-pill text-bg-secondary bg-opacity-10 text-secondary px-3 py-2"><i
                                            class="bi bi-pause-circle-fill me-1"></i>Inactive</span>
                                    @endif
                                </td>
                                <td class="text-end text-nowrap">
                                    <button type="button" class="class-action me-1" title="View class"
                                        onclick="viewClass(this)" data-id="{{ $class->id }}"
                                        data-name="{{ $class->name }}"
                                        data-location="{{ $class->location?->name ?? 'No location assigned' }}"
                                        data-start="{{ \Carbon\Carbon::parse($class->start_time)->format('H:i') }}"
                                        data-end="{{ \Carbon\Carbon::parse($class->end_time)->format('H:i') }}"
                                        data-days="{{ $dayNames->implode(', ') }}"
                                        data-fee="{{ number_format((float) $class->monthly_fee, 2) }}"
                                        data-students="{{ $studentCount }}"
                                        data-status="{{ $class->status ? 'Active' : 'Inactive' }}"><i
                                            class="bi bi-eye"></i></button>
                                    <button type="button" class="class-action me-1"
                                        title="Edit class"
                                        onclick="editClass(this)"
                                        data-id="{{ $class->id }}"
                                        data-name="{{ $class->name }}"
                                        data-location-id="{{ $class->location_id }}"
                                        data-start="{{ \Carbon\Carbon::parse($class->start_time)->format('H:i') }}"
                                        data-end="{{ \Carbon\Carbon::parse($class->end_time)->format('H:i') }}"
                                        data-days="{{ implode(',', $dayNumbers) }}"
                                        data-fee="{{ $class->monthly_fee }}"
                                        data-status="{{ $class->status ? 1 : 0 }}">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <button type="button" class="class-action" title="Delete class"
                                        onclick="confirmDeleteClass(this)" data-id="{{ $class->id }}"
                                        data-name="{{ $class->name }}"><i class="bi bi-trash"></i></button>



                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="classModal" tabindex="-1" aria-labelledby="classModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 rounded-4 shadow">
                <div class="modal-header border-0 px-4 pt-4">
                    <div>
                        <h5 class="modal-title fw-semibold" id="classModalLabel">Create Class</h5>
                        <p class="class-muted mb-0">Set up a class and its weekly schedule.</p>
                    </div><button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form id="classForm" method="POST" action="{{ route('classes.store') }}">
                    @csrf
                    <input type="hidden" name="_method" id="classFormMethod" value="POST">

                    <div class="modal-body px-4">
                        <div id="classFormErrors" class="alert alert-danger d-none"></div>

                        <div class="row g-3">
                            {{-- Class name --}}
                            <div class="col-md-6">
                                <label for="className" class="form-label">
                                    Class name <span class="text-danger">*</span>
                                </label>
                                <input
                                    id="className"
                                    name="name"
                                    type="text"
                                    class="form-control"
                                    value="{{ old('name') }}"
                                    placeholder="e.g. Junior Dance"
                                    required
                                    maxlength="255">
                                <div class="invalid-feedback" data-error-for="name"></div>
                            </div>

                            {{-- Subject --}}
                            <div class="col-md-6">
                                <label class="form-label">Subject</label>
                                <input type="text" class="form-control" value="Dancing" readonly>
                            </div>

                            {{-- Location --}}
                            <div class="col-md-6">
                                <label for="classLocation" class="form-label">
                                    Location <span class="text-danger">*</span>
                                </label>
                                <select id="classLocation" name="location_id" class="form-select" required>
                                    <option value="">Select location</option>
                                    @foreach ($locations as $location)
                                    <option
                                        value="{{ $location->id }}"
                                        @selected(old('location_id')==$location->id)
                                        >
                                        {{ $location->name }}
                                    </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback" data-error-for="location_id"></div>

                                @if ($locations->isEmpty())
                                <div class="text-danger small mt-1">
                                    No active locations found. Create a location before creating a class.
                                </div>
                                @endif
                            </div>

                            {{-- Monthly fee --}}
                            <div class="col-md-6">
                                <label for="classFee" class="form-label">
                                    Monthly fee (LKR) <span class="text-danger">*</span>
                                </label>
                                <input
                                    id="classFee"
                                    name="monthly_fee"
                                    type="number"
                                    min="0"
                                    step="0.01"
                                    class="form-control"
                                    value="{{ old('monthly_fee') }}"
                                    placeholder="2500.00"
                                    required>
                                <div class="invalid-feedback" data-error-for="monthly_fee"></div>
                            </div>

                            {{-- Class days --}}
                            <div class="col-12">
                                <label class="form-label">
                                    Class days <span class="text-danger">*</span>
                                </label>

                                <div class="class-day-checks">
                                    @foreach ($dayLabels as $dayNumber => $dayName)
                                    <div class="form-check">
                                        <input
                                            class="form-check-input class-day-input"
                                            type="checkbox"
                                            name="days[]"
                                            value="{{ $dayNumber }}"
                                            id="classDay{{ $dayNumber }}"
                                            @checked(in_array($dayNumber, old('days', [])))>
                                        <label
                                            class="form-check-label small"
                                            for="classDay{{ $dayNumber }}">
                                            {{ $dayFullLabels[$dayNumber] }}
                                        </label>
                                    </div>
                                    @endforeach
                                </div>

                                <div id="daysValidationError" class="text-danger small mt-1"></div>
                            </div>

                            {{-- Start time --}}
                            <div class="col-md-6">
                                <label for="classStartTime" class="form-label">
                                    Start time <span class="text-danger">*</span>
                                </label>
                                <input
                                    id="classStartTime"
                                    name="start_time"
                                    type="time"
                                    class="form-control"
                                    value="{{ old('start_time') }}"
                                    required>
                                <div class="invalid-feedback" data-error-for="start_time"></div>
                            </div>

                            {{-- End time --}}
                            <div class="col-md-6">
                                <label for="classEndTime" class="form-label">
                                    End time <span class="text-danger">*</span>
                                </label>
                                <input
                                    id="classEndTime"
                                    name="end_time"
                                    type="time"
                                    class="form-control"
                                    value="{{ old('end_time') }}"
                                    required>
                                <div class="invalid-feedback" data-error-for="end_time"></div>
                            </div>

                            {{-- Status --}}
                            <div class="col-md-6">
                                <label for="classStatus" class="form-label">Status</label>
                                <select id="classStatus" name="status" class="form-select">
                                    <option value="1" @selected(old('status', '1' )=='1' )>
                                        Active
                                    </option>
                                    <option value="0" @selected(old('status')=='0' )>
                                        Inactive
                                    </option>
                                </select>
                                <div class="invalid-feedback" data-error-for="status"></div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer border-0 px-4 pb-4">
                        <button
                            type="button"
                            class="btn btn-light rounded-3"
                            data-bs-dismiss="modal">
                            Cancel
                        </button>

                        <button
                            type="submit"
                            class="btn class-primary-btn"
                            id="saveClassButton">
                            <i class="bi bi-check-lg me-1"></i>Save Class
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <div class="modal fade" id="viewClassModal" tabindex="-1" aria-labelledby="viewClassModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 rounded-4 shadow">
                <div class="modal-header">
                    <h5 class="modal-title fw-semibold" id="viewClassModalLabel">Class Details</h5><button
                        type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="classDetails"></div>
            </div>
        </div>
    </div>
    <form id="deleteClassForm" method="POST" class="d-none">@csrf @method('DELETE')</form>

    <div id="classesConfig" hidden
        data-store-url="{{ route('classes.store') }}"
        data-base-url="{{ url('/classes') }}"></div>

    @push('scripts')
    <script>
        const classesConfig = document.getElementById('classesConfig');
        const classesStoreUrl = classesConfig.dataset.storeUrl;
        const classesBaseUrl = classesConfig.dataset.baseUrl;

        $(function() {
            const table = $('#classesTable').DataTable({
                pageLength: 10,
                lengthMenu: [5, 10, 25, 50],
                order: [
                    [0, 'asc']
                ],
                autoWidth: false,
                columnDefs: [{
                    orderable: false,
                    targets: 7
                }],
                language: {
                    search: '',
                    searchPlaceholder: 'Search classes...',
                    lengthMenu: 'Show _MENU_ classes',
                    info: 'Showing _START_ to _END_ of _TOTAL_ classes',
                    infoEmpty: 'No classes found',
                    zeroRecords: 'No matching classes found',
                    emptyTable: 'No classes registered yet.',
                    paginate: {
                        previous: '<i class="bi bi-chevron-left"></i>',
                        next: '<i class="bi bi-chevron-right"></i>'
                    }
                }
            });
            $('#classStatusFilter').on('change', function() {
                table.column(6).search(this.value ? '^' + $.fn.dataTable.util.escapeRegex(this.value) +
                    '$' : '', true, false).draw();
            });
            $('#classLocationFilter').on('change', function() {
                table.column(2).search(this.value ? $.fn.dataTable.util.escapeRegex(this.value) : '', true,
                    false).draw();
            });
            $('#classDayFilter').on('change', function() {
                table.column(3).search(this.value ? $.fn.dataTable.util.escapeRegex(this.value) : '', true,
                    false).draw();
            });
            $('#exportClasses').on('click', function() {
                const rows = table.rows({
                    search: 'applied'
                }).nodes().toArray();
                const csvRows = [
                    ['Class', 'Class ID', 'Location', 'Schedule', 'Students', 'Monthly Fee', 'Status'],
                    ...rows.map(row => Array.from(row.cells).slice(0, 7).map(cell => cell.innerText
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
                link.download = 'classes.csv';
                document.body.appendChild(link);
                link.click();
                link.remove();
                URL.revokeObjectURL(url);
            });
            $('#classForm').on('submit', function(event) {
                event.preventDefault();

                const form = this;
                const formData = new FormData(form);
                const errorBox = document.getElementById('classFormErrors');

                errorBox.classList.add('d-none');
                errorBox.textContent = '';

                document.querySelectorAll('#classForm .is-invalid').forEach(input => {
                    input.classList.remove('is-invalid');
                });

                $.ajax({
                    url: form.action,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    headers: {
                        Accept: 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },

                    success: function(response) {
                        bootstrap.Modal.getOrCreateInstance(
                            document.getElementById('classModal')
                        ).hide();

                        window.location.reload();
                    },

                    error: function(xhr) {
                        if (xhr.status === 422 && xhr.responseJSON?.errors) {
                            const errors = xhr.responseJSON.errors;

                            document.querySelectorAll('[data-error-for]').forEach(element => {
                                element.textContent = '';
                            });

                            document.querySelectorAll('#classForm .is-invalid').forEach(input => {
                                input.classList.remove('is-invalid');
                            });

                            document.getElementById('daysValidationError').textContent = '';

                            Object.entries(errors).forEach(([field, messages]) => {
                                const message = messages[0];

                                if (field === 'days' || field.startsWith('days.')) {
                                    document.getElementById('daysValidationError').textContent = message;
                                    return;
                                }

                                const input = document.querySelector(
                                    `#classForm [name="${field}"]`
                                );

                                const errorElement = document.querySelector(
                                    `[data-error-for="${field}"]`
                                );

                                if (input) {
                                    input.classList.add('is-invalid');
                                }

                                if (errorElement) {
                                    errorElement.textContent = message;
                                }
                            });

                            return;
                        }

                        errorBox.textContent =
                            xhr.responseJSON?.message || 'An unexpected error occurred.';

                        errorBox.classList.remove('d-none');
                    }
                });
            });

            @if($errors->any())
            bootstrap.Modal.getOrCreateInstance(document.getElementById('classModal')).show();
            @endif
        });

        function openCreateClassModal() {
            const form = document.getElementById('classForm');
            form.action = classesStoreUrl;
            document.getElementById('classFormMethod').value = 'POST';
            document.getElementById('classModalLabel').textContent = 'Create Class';
            document.getElementById('saveClassButton').innerHTML = '<i class="bi bi-check-lg me-1"></i>Save Class';
            form.reset();
            document.getElementById('classStatus').value = '1';
            document.getElementById('classFormErrors').classList.add('d-none');
            document.querySelectorAll('.class-day-input').forEach(input => input.checked = false);
            bootstrap.Modal.getOrCreateInstance(document.getElementById('classModal')).show();
        }

        function editClass(button) {
            const form = document.getElementById('classForm');
            form.action = classesBaseUrl + '/' + button.dataset.id;
            document.getElementById('classFormMethod').value = 'PUT';
            document.getElementById('classModalLabel').textContent = 'Edit Class';
            document.getElementById('saveClassButton').innerHTML = '<i class="bi bi-check-lg me-1"></i>Update Class';
            document.getElementById('className').value = button.dataset.name || '';
            document.getElementById('classLocation').value = button.dataset.locationId || '';
            document.getElementById('classFee').value = button.dataset.fee || '0';
            document.getElementById('classStartTime').value = button.dataset.start || '';
            document.getElementById('classEndTime').value = button.dataset.end || '';
            document.getElementById('classStatus').value = button.dataset.status || '1';
            document.getElementById('classFormErrors').classList.add('d-none');
            const days = (button.dataset.days || '').split(',').filter(Boolean);
            document.querySelectorAll('.class-day-input').forEach(input => {
                input.checked = days.includes(String(input.value));
            });
            bootstrap.Modal.getOrCreateInstance(document.getElementById('classModal')).show();
        }

        function viewClass(button) {
            const details = document.getElementById('classDetails');
            details.replaceChildren();
            const heading = document.createElement('div');
            heading.className = 'd-flex align-items-center gap-3 mb-3';
            const icon = document.createElement('div');
            icon.className = 'class-subject-icon subject-indigo';
            icon.innerHTML = '<i class="bi bi-music-note-beamed"></i>';
            const info = document.createElement('div');
            const name = document.createElement('h6');
            name.className = 'fw-semibold mb-1';
            name.textContent = button.dataset.name || 'Class';
            const id = document.createElement('div');
            id.className = 'class-muted';
            id.textContent = 'CLS-' + String(button.dataset.id).padStart(3, '0');
            info.append(name, id);
            heading.append(icon, info);
            details.append(heading);
            const fields = [
                ['Location', button.dataset.location],
                ['Subject', 'Dancing'],
                ['Start time', button.dataset.start],
                ['End time', button.dataset.end],
                ['Class days', button.dataset.days || 'No days set'],
                ['Enrolled students', button.dataset.students],
                ['Monthly fee', 'LKR ' + button.dataset.fee],
                ['Status', button.dataset.status]
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
                val.textContent = value || '—';
                row.append(key, val);
                list.append(row);
            });
            details.append(list);
            bootstrap.Modal.getOrCreateInstance(document.getElementById('viewClassModal')).show();
        }

        function confirmDeleteClass(button) {
            const id = button.dataset.id;
            const name = button.dataset.name || 'this class';
            if (!confirm('Delete the class "' + name + '"?')) return;
            const form = document.getElementById('deleteClassForm');
            form.action = classesBaseUrl + '/' + id;
            form.submit();
        }
    </script>
    @endpush
</x-app-layout>