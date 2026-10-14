
<x-app-layout>
    @section('title', 'Classes | TDS Attendance')

    @push('styles')
        <style>
            .class-stat-card,
            .class-table-card {
                border: 1px solid #e9eaf2;
                border-radius: 14px;
                box-shadow: 0 3px 14px rgba(31, 41, 80, .035);
                background: #fff;
            }

            .class-stat-icon {
                width: 40px;
                height: 40px;
                display: flex;
                align-items: center;
                justify-content: center;
                border-radius: 11px;
                font-size: 19px;
            }

            .class-icon-indigo { background: #eeeaff; color: #5b4acb; }
            .class-icon-green  { background: #e0f8eb; color: #139765; }
            .class-icon-blue   { background: #e1efff; color: #2471d8; }
            .class-icon-orange { background: #fff0dc; color: #d97706; }

            .class-page-title {
                font-family: "Momo Trust Display", sans-serif;
                font-size: 25px;
                font-weight: 400;
                letter-spacing: -.4px;
                color: #20243a;
            }

            .class-primary-btn {
                background: #5141b8;
                color: #fff;
                border: 1px solid #5141b8;
                border-radius: 9px;
                padding: 9px 14px;
                font-size: 12px;
                font-weight: 600;
            }

            .class-primary-btn:hover {
                background: #4233a0;
                color: #fff;
            }

            .class-filter {
                min-height: 36px;
                border: 1px solid #e2e5ef;
                border-radius: 8px;
                font-size: 12px;
            }

            .class-table-card .card-body {
                padding: 20px;
            }

            #classesTable {
                font-size: 11.5px;
                width: 100% !important;
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
                white-space: nowrap;
            }

            #classesTable tbody td {
                padding: 12px 10px;
                border-color: #f0f1f6;
                vertical-align: middle;
                color: #30364d;
            }

            #classesTable tbody tr:hover td {
                background: #faf9ff;
            }

            .class-subject-icon {
                width: 35px;
                height: 35px;
                border-radius: 10px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                font-size: 16px;
                flex-shrink: 0;
            }

            .subject-indigo { background: #eeeaff; color: #5b4acb; }
            .subject-green  { background: #e0f8eb; color: #139765; }
            .subject-blue   { background: #e1efff; color: #2471d8; }
            .subject-orange { background: #fff0dc; color: #d97706; }
            .subject-pink   { background: #ffe5f0; color: #db2777; }
            .subject-teal   { background: #dff8f5; color: #0f9688; }

            .class-name {
                font-weight: 600;
                color: #252a42;
                font-size: 12px;
            }

            .class-muted {
                color: #858ba0;
                font-size: 10.5px;
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
                color: #626a7e;
            }

            .class-action:hover {
                color: #5141b8;
                background: #f0edff;
            }

            .class-day {
                display: inline-block;
                background: #f1efff;
                color: #5b4acb;
                border-radius: 5px;
                padding: 4px 6px;
                margin: 2px 2px 2px 0;
                font-size: 9px;
                font-weight: 600;
            }

            #classesTable_wrapper {
                font-size: 11px;
            }

            #classesTable_wrapper .dt-search input,
            #classesTable_wrapper .dt-length select {
                border: 1px solid #e2e5ef;
                border-radius: 8px;
                padding: 5px 9px;
                font-size: 11px;
            }

            @media (max-width: 767.98px) {
                .class-page-title { font-size: 22px; }
                .class-table-card .card-body { padding: 14px; }
                #classesTable { min-width: 950px; }
            }
        </style>
    @endpush

    @php
        $classes = [
            [
                'id' => 'CLS-001',
                'name' => 'Junior Dance',
                'subject' => 'Dancing',
                'location' => 'Kiribathgoda',
                'time' => '4:00 PM - 5:30 PM',
                'days' => ['Mon', 'Wed', 'Fri'],
                'students' => 28,
                'fee' => 2500,
                'status' => 'Active',
                'color' => 'indigo',
                'icon' => 'bi-music-note-beamed',
                'joined' => '2026-01-05',
            ],
            [
                'id' => 'CLS-002',
                'name' => 'Ballet Beginners',
                'subject' => 'Dancing',
                'location' => 'Nugegoda',
                'time' => '5:30 PM - 7:00 PM',
                'days' => ['Tue', 'Thu'],
                'students' => 24,
                'fee' => 3000,
                'status' => 'Active',
                'color' => 'green',
                'icon' => 'bi-stars',
                'joined' => '2026-01-12',
            ],
            [
                'id' => 'CLS-003',
                'name' => 'Hip Hop',
                'subject' => 'Dancing',
                'location' => 'Colombo 03',
                'time' => '7:00 PM - 8:30 PM',
                'days' => ['Mon', 'Wed', 'Fri'],
                'students' => 20,
                'fee' => 3500,
                'status' => 'Active',
                'color' => 'blue',
                'icon' => 'bi-lightning-charge',
                'joined' => '2026-02-01',
            ],
            [
                'id' => 'CLS-004',
                'name' => 'Traditional Dance',
                'subject' => 'Dancing',
                'location' => 'Maharagama',
                'time' => '3:30 PM - 5:00 PM',
                'days' => ['Mon', 'Wed'],
                'students' => 22,
                'fee' => 2500,
                'status' => 'Active',
                'color' => 'orange',
                'icon' => 'bi-flower1',
                'joined' => '2026-02-15',
            ],
            [
                'id' => 'CLS-005',
                'name' => 'Contemporary Dance',
                'subject' => 'Dancing',
                'location' => 'Battaramulla',
                'time' => '5:15 PM - 6:45 PM',
                'days' => ['Tue', 'Thu'],
                'students' => 18,
                'fee' => 3000,
                'status' => 'Active',
                'color' => 'teal',
                'icon' => 'bi-person-arms-up',
                'joined' => '2026-03-01',
            ],
            [
                'id' => 'CLS-006',
                'name' => 'Kids Dance',
                'subject' => 'Dancing',
                'location' => 'Dehiwala',
                'time' => '8:00 AM - 9:30 AM',
                'days' => ['Sat'],
                'students' => 12,
                'fee' => 2000,
                'status' => 'Inactive',
                'color' => 'pink',
                'icon' => 'bi-balloon',
                'joined' => '2026-03-20',
            ],
            [
                'id' => 'CLS-007',
                'name' => 'Advanced Dance',
                'subject' => 'Dancing',
                'location' => 'Kiribathgoda',
                'time' => '6:00 PM - 7:30 PM',
                'days' => ['Tue', 'Fri'],
                'students' => 16,
                'fee' => 4000,
                'status' => 'Active',
                'color' => 'indigo',
                'icon' => 'bi-award',
                'joined' => '2026-04-10',
            ],
            [
                'id' => 'CLS-008',
                'name' => 'Weekend Dance',
                'subject' => 'Dancing',
                'location' => 'Nugegoda',
                'time' => '9:00 AM - 10:30 AM',
                'days' => ['Sat'],
                'students' => 14,
                'fee' => 2200,
                'status' => 'Inactive',
                'color' => 'green',
                'icon' => 'bi-calendar-week',
                'joined' => '2026-05-01',
            ],
        ];

        $totalStudents = collect($classes)->sum('students');
        $activeClasses = collect($classes)->where('status', 'Active')->count();
        $inactiveClasses = collect($classes)->where('status', 'Inactive')->count();
    @endphp

    <div class="container-fluid px-0">

        {{-- Page heading --}}
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
            <div>
                <div class="text-secondary small mb-2">
                    <i class="bi bi-house-door me-1"></i>
                    Home <i class="bi bi-chevron-right mx-1"></i> Classes
                </div>

                <h2 class="class-page-title mb-1">Classes</h2>
                <p class="text-secondary small mb-0">
                    Manage your dance classes, schedules, locations, and fees.
                </p>
            </div>

            <button type="button"
                    class="btn class-primary-btn"
                    data-bs-toggle="modal"
                    data-bs-target="#classModal">
                <i class="bi bi-plus-lg me-2"></i>Create Class
            </button>
        </div>

        {{-- Statistics --}}
        <div class="row g-3 mb-4">

            <div class="col-6 col-xl-3">
                <div class="card class-stat-card h-100">
                    <div class="card-body p-3">
                        <div class="d-flex justify-content-between align-items-start gap-2">
                            <div>
                                <div class="text-secondary small mb-2">Total Classes</div>
                                <h3 class="fw-semibold mb-1">{{ count($classes) }}</h3>
                                <span class="class-muted">All registered classes</span>
                            </div>
                            <div class="class-stat-icon class-icon-indigo">
                                <i class="bi bi-collection"></i>
                            </div>
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
                                <h3 class="fw-semibold text-success mb-1">{{ $activeClasses }}</h3>
                                <span class="class-muted">Currently running</span>
                            </div>
                            <div class="class-stat-icon class-icon-green">
                                <i class="bi bi-check-circle"></i>
                            </div>
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
                                <h3 class="fw-semibold text-primary mb-1">{{ $totalStudents }}</h3>
                                <span class="class-muted">Across all classes</span>
                            </div>
                            <div class="class-stat-icon class-icon-blue">
                                <i class="bi bi-people"></i>
                            </div>
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
                                <h3 class="fw-semibold text-warning mb-1">{{ $inactiveClasses }}</h3>
                                <span class="class-muted">Paused classes</span>
                            </div>
                            <div class="class-stat-icon class-icon-orange">
                                <i class="bi bi-pause-circle"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        {{-- Classes table --}}
        <div class="card class-table-card">
            <div class="card-body">

                <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
                    <div>
                        <h5 class="fw-semibold mb-1">All Classes</h5>
                        <p class="class-muted mb-0">
                            Review class schedules, locations, enrolments, and monthly fees.
                        </p>
                    </div>

                    <button type="button" class="btn btn-outline-secondary btn-sm rounded-3"
                            id="exportClasses">
                        <i class="bi bi-download me-1"></i>Export CSV
                    </button>
                </div>

                {{-- Filters --}}
                <div class="row g-3 mb-4">
                    <div class="col-12 col-md-4">
                        <label for="classStatusFilter" class="form-label small fw-semibold">
                            Status
                        </label>
                        <select id="classStatusFilter" class="form-select class-filter">
                            <option value="">All statuses</option>
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                    </div>

                    <div class="col-12 col-md-4">
                        <label for="classLocationFilter" class="form-label small fw-semibold">
                            Location
                        </label>
                        <select id="classLocationFilter" class="form-select class-filter">
                            <option value="">All locations</option>
                            @foreach (collect($classes)->pluck('location')->unique() as $location)
                                <option value="{{ $location }}">{{ $location }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12 col-md-4">
                        <label for="classDayFilter" class="form-label small fw-semibold">
                            Class day
                        </label>
                        <select id="classDayFilter" class="form-select class-filter">
                            <option value="">All days</option>
                            @foreach (['Mon','Tue','Wed','Thu','Fri','Sat','Sun'] as $day)
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
                            @foreach ($classes as $class)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="class-subject-icon subject-{{ $class['color'] }}">
                                                <i class="bi {{ $class['icon'] }}"></i>
                                            </div>
                                            <div>
                                                <div class="class-name">{{ $class['name'] }}</div>
                                                <div class="class-muted">{{ $class['subject'] }}</div>
                                            </div>
                                        </div>
                                    </td>

                                    <td>
                                        <span class="badge rounded-pill text-bg-light border">
                                            {{ $class['id'] }}
                                        </span>
                                    </td>

                                    <td>
                                        <span class="d-inline-flex align-items-center gap-1">
                                            <i class="bi bi-geo-alt text-primary"></i>
                                            {{ $class['location'] }}
                                        </span>
                                    </td>

                                    <td data-search="{{ implode(' ', $class['days']) }}">
                                        <div class="text-nowrap mb-1">
                                            <i class="bi bi-clock text-secondary me-1"></i>
                                            {{ $class['time'] }}
                                        </div>
                                        <div>
                                            @foreach ($class['days'] as $day)
                                                <span class="class-day">{{ $day }}</span>
                                            @endforeach
                                        </div>
                                    </td>

                                    <td>
                                        <span class="badge rounded-pill text-bg-primary bg-opacity-10 text-primary px-3 py-2">
                                            <i class="bi bi-people me-1"></i>
                                            {{ $class['students'] }}
                                        </span>
                                    </td>

                                    <td class="text-nowrap fw-semibold">
                                        LKR {{ number_format($class['fee'], 2) }}
                                    </td>

                                    <td data-search="{{ $class['status'] }}">
                                        @if ($class['status'] === 'Active')
                                            <span class="badge rounded-pill text-bg-success bg-opacity-10 text-success px-3 py-2">
                                                <i class="bi bi-check-circle-fill me-1"></i>Active
                                            </span>
                                        @else
                                            <span class="badge rounded-pill text-bg-secondary bg-opacity-10 text-secondary px-3 py-2">
                                                <i class="bi bi-pause-circle-fill me-1"></i>Inactive
                                            </span>
                                        @endif
                                    </td>

                                    <td class="text-end text-nowrap">
                                        <button type="button"
                                                class="class-action me-1"
                                                title="View class"
                                                onclick="viewClass(this)"
                                                data-class-id="{{ $class['id'] }}">
                                            <i class="bi bi-eye"></i>
                                        </button>

                                        <button type="button"
                                                class="class-action me-1"
                                                title="Edit class"
                                                onclick="alert('Demo only: Edit {{ $class['name'] }}')">
                                            <i class="bi bi-pencil"></i>
                                        </button>

                                        <button type="button"
                                                class="class-action"
                                                title="More options"
                                                onclick="alert('Demo only: More options for {{ $class['name'] }}')">
                                            <i class="bi bi-three-dots"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

    {{-- Create Class Modal (demo only) --}}
    <div class="modal fade" id="classModal" tabindex="-1"
         aria-labelledby="classModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 rounded-4 shadow">
                <div class="modal-header border-0 px-4 pt-4">
                    <div>
                        <h5 class="modal-title fw-semibold" id="classModalLabel">Create Class</h5>
                        <p class="class-muted mb-0">Set up a class and its weekly schedule.</p>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                </div>

                <form id="createClassForm">
                    <div class="modal-body px-4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Class name</label>
                                <input name="name" type="text" class="form-control"
                                       placeholder="e.g. Junior Dance" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Subject</label>
                                <input type="text" class="form-control"
                                       value="Dancing" readonly>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Location</label>
                                <select name="location" class="form-select" required>
                                    <option value="">Select location</option>
                                    <option>Kiribathgoda</option>
                                    <option>Nugegoda</option>
                                    <option>Colombo 03</option>
                                    <option>Maharagama</option>
                                    <option>Battaramulla</option>
                                    <option>Dehiwala</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Monthly fee (LKR)</label>
                                <input name="fee" type="number" min="0" step="0.01"
                                       class="form-control" placeholder="2500.00" required>
                            </div>

                            <div class="col-12">
                                <label class="form-label">Class days</label>
                                <div class="d-flex flex-wrap gap-3">
                                    @foreach (['Mon','Tue','Wed','Thu','Fri','Sat','Sun'] as $day)
                                        <div class="form-check">
                                            <input class="form-check-input"
                                                   type="checkbox"
                                                   name="days[]"
                                                   value="{{ $day }}"
                                                   id="day{{ $day }}">
                                            <label class="form-check-label small"
                                                   for="day{{ $day }}">{{ $day }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Start time</label>
                                <input name="start_time" type="time" class="form-control" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">End time</label>
                                <input name="end_time" type="time" class="form-control" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select">
                                    <option>Active</option>
                                    <option>Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer border-0 px-4 pb-4">
                        <button type="button" class="btn btn-light rounded-3"
                                data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn class-primary-btn">
                            <i class="bi bi-check-lg me-1"></i>Save Class
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- View Class Modal --}}
    <div class="modal fade" id="viewClassModal" tabindex="-1"
         aria-labelledby="viewClassModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 rounded-4 shadow">
                <div class="modal-header">
                    <h5 class="modal-title fw-semibold" id="viewClassModalLabel">
                        Class Details
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                </div>
                <div class="modal-body" id="classDetails"></div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(function () {
                const table = $('#classesTable').DataTable({
                    pageLength: 5,
                    lengthMenu: [5, 10, 25],
                    order: [[0, 'asc']],
                    autoWidth: false,
                    columnDefs: [
                        { orderable: false, targets: 7 }
                    ],
                    language: {
                        search: '',
                        searchPlaceholder: 'Search classes...',
                        lengthMenu: 'Show _MENU_ classes',
                        info: 'Showing _START_ to _END_ of _TOTAL_ classes',
                        infoEmpty: 'No classes found',
                        zeroRecords: 'No matching classes found'
                    }
                });

                $('#classStatusFilter').on('change', function () {
                    table.column(6).search(this.value).draw();
                });

                $('#classLocationFilter').on('change', function () {
                    table.column(2).search(this.value).draw();
                });

                $('#classDayFilter').on('change', function () {
                    table.column(3).search(this.value).draw();
                });

                $('#exportClasses').on('click', function () {
                    const rows = table.rows({ search: 'applied' }).data().toArray();

                    const csvRows = [
                        ['Class', 'Class ID', 'Location', 'Schedule', 'Students', 'Monthly Fee', 'Status'],
                        ...rows.map(row =>
                            row.slice(0, 7).map(cell =>
                                $('<div>').html(cell).text().trim()
                            )
                        )
                    ];

                    const csv = csvRows.map(row =>
                        row.map(value =>
                            '"' + String(value).replace(/"/g, '""') + '"'
                        ).join(',')
                    ).join('\r\n');

                    const blob = new Blob(['\uFEFF' + csv], {
                        type: 'text/csv;charset=utf-8;'
                    });

                    const url = URL.createObjectURL(blob);
                    const link = document.createElement('a');
                    link.href = url;
                    link.download = 'classes.csv';
                    link.click();
                    URL.revokeObjectURL(url);
                });

                $('#createClassForm').on('submit', function (event) {
                    event.preventDefault();
                    alert('Demo only: this form is not connected to the database yet.');
                });
            });

            const demoClasses = @json($classes);

            function viewClass(button) {
                const classItem = demoClasses.find(
                    item => item.id === button.dataset.classId
                );

                if (!classItem) return;

                const details = document.getElementById('classDetails');

                details.replaceChildren();

                const heading = document.createElement('div');
                heading.className = 'd-flex align-items-center gap-3 mb-3';

                const icon = document.createElement('div');
                icon.className = 'class-subject-icon subject-' + classItem.color;
                icon.innerHTML = '<i class="bi ' + classItem.icon + '"></i>';

                const info = document.createElement('div');

                const name = document.createElement('h6');
                name.className = 'fw-semibold mb-1';
                name.textContent = classItem.name;

                const id = document.createElement('div');
                id.className = 'class-muted';
                id.textContent = classItem.id;

                info.append(name, id);
                heading.append(icon, info);
                details.append(heading);

                const fields = [
                    ['Location', classItem.location],
                    ['Subject', classItem.subject],
                    ['Time', classItem.time],
                    ['Days', classItem.days.join(', ')],
                    ['Students', classItem.students],
                    ['Monthly fee', 'LKR ' + Number(classItem.fee).toLocaleString('en-LK', {
                        minimumFractionDigits: 2
                    })],
                    ['Status', classItem.status]
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
                    val.textContent = value;

                    row.append(key, val);
                    list.append(row);
                });

                details.append(list);

                bootstrap.Modal.getOrCreateInstance(
                    document.getElementById('viewClassModal')
                ).show();
            }
        </script>
    @endpush
</x-app-layout>
