
<x-app-layout>
    @section('title', 'Attendance | TDS Attendance')

    @push('styles')
        <style>
            .attendance-card {
                background: #fff;
                border: 1px solid #e9eaf2;
                border-radius: 14px;
                box-shadow: 0 3px 14px rgba(31, 41, 80, .035);
            }

            .attendance-title {
                font-family: "Momo Trust Display", sans-serif;
                font-size: 25px;
                font-weight: 400;
                color: #20243a;
                letter-spacing: -.4px;
            }

            .attendance-primary {
                background: #5141b8;
                color: #fff;
                border: 1px solid #5141b8;
                border-radius: 9px;
                padding: 9px 14px;
                font-size: 12px;
                font-weight: 600;
            }

            .attendance-primary:hover {
                background: #4233a0;
                border-color: #4233a0;
                color: #fff;
            }

            .attendance-stat-icon {
                width: 40px;
                height: 40px;
                display: flex;
                align-items: center;
                justify-content: center;
                border-radius: 11px;
                font-size: 19px;
            }

            .att-purple { background: #eeeaff; color: #5b4acb; }
            .att-green  { background: #e0f8eb; color: #139765; }
            .att-red    { background: #ffe8e8; color: #dc3545; }
            .att-orange { background: #fff0dc; color: #d97706; }
            .att-blue   { background: #e1efff; color: #2471d8; }

            .attendance-stat-number {
                font-family: "Momo Trust Display", sans-serif;
                font-size: 25px;
                font-weight: 400;
                color: #20243a;
            }

            .attendance-muted {
                font-size: 10.5px;
                color: #858ba0;
            }

            .attendance-filter {
                min-height: 37px;
                border: 1px solid #e2e5ef;
                border-radius: 8px;
                font-size: 12px;
            }

            .attendance-date {
                background: #f4f1ff;
                border: 1px solid #e5dfff;
                color: #5141b8;
                border-radius: 9px;
                padding: 9px 12px;
                font-size: 12px;
                font-weight: 600;
            }

            .attendance-progress {
                height: 6px;
                background: #efeff5;
                border-radius: 20px;
                overflow: hidden;
            }

            .attendance-progress .progress-bar {
                background: #5141b8;
                border-radius: 20px;
                transition: width .2s ease;
            }

            #attendanceTable {
                width: 100% !important;
                font-size: 11.5px;
            }

            #attendanceTable thead th {
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

            #attendanceTable tbody td {
                padding: 10px;
                border-color: #f0f1f6;
                vertical-align: middle;
                color: #30364d;
            }

            #attendanceTable tbody tr:hover td {
                background: #faf9ff;
            }

            .attendance-avatar {
                width: 35px;
                height: 35px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                flex-shrink: 0;
                border-radius: 10px;
                font-size: 11px;
                font-weight: 700;
            }

            .avatar-purple { background: #eeeaff; color: #5b4acb; }
            .avatar-blue   { background: #e1efff; color: #2471d8; }
            .avatar-pink   { background: #ffe5f0; color: #db2777; }
            .avatar-green  { background: #e0f8eb; color: #139765; }
            .avatar-orange { background: #fff0dc; color: #d97706; }

            .attendance-student-name {
                font-size: 11.5px;
                font-weight: 600;
                color: #252a42;
            }

            .attendance-student-email {
                font-size: 10px;
                color: #858ba0;
            }

            .attendance-choice {
                display: inline-flex;
                gap: 4px;
                padding: 3px;
                border: 1px solid #ececf3;
                background: #f8f8fc;
                border-radius: 9px;
            }

            .attendance-choice button {
                min-width: 34px;
                min-height: 32px;
                border: 0;
                border-radius: 6px;
                background: transparent;
                color: #858ba0;
                font-size: 10px;
                font-weight: 700;
                transition: .15s ease;
            }

            .attendance-choice button.selected-present {
                background: #dff7e9;
                color: #138653;
            }

            .attendance-choice button.selected-absent {
                background: #ffe5e5;
                color: #d42e3d;
            }

            .attendance-choice button.selected-late {
                background: #fff0d8;
                color: #b76b00;
            }

            .attendance-choice button.selected-unmarked {
                background: #e9eaf1;
                color: #50566b;
            }

            .attendance-action {
                width: 30px;
                height: 30px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                border: 1px solid #e8eaf2;
                border-radius: 8px;
                background: #fff;
                color: #626a7e;
            }

            .attendance-action:hover {
                color: #5141b8;
                background: #f0edff;
            }

            #attendanceTable_wrapper {
                font-size: 11px;
            }

            #attendanceTable_wrapper .dt-search input,
            #attendanceTable_wrapper .dt-length select {
                border: 1px solid #e2e5ef;
                border-radius: 8px;
                padding: 5px 9px;
                font-size: 11px;
            }

            .attendance-legend {
                display: inline-flex;
                align-items: center;
                gap: 5px;
                font-size: 10px;
                color: #737b90;
            }

            .attendance-dot {
                width: 7px;
                height: 7px;
                border-radius: 50%;
            }

            @media (max-width: 767.98px) {
                .attendance-title { font-size: 22px; }
                .attendance-card .card-body { padding: 14px !important; }
                #attendanceTable { min-width: 850px; }
            }
        </style>
    @endpush

    @php
        $students = [
            ['id'=>'STU-001','name'=>'Amaya Perera','email'=>'amaya@example.com','avatar'=>'AP','color'=>'purple','status'=>'Present'],
            ['id'=>'STU-002','name'=>'Kavindu Silva','email'=>'kavindu@example.com','avatar'=>'KS','color'=>'blue','status'=>'Present'],
            ['id'=>'STU-003','name'=>'Nethmi Fernando','email'=>'nethmi@example.com','avatar'=>'NF','color'=>'pink','status'=>'Late'],
            ['id'=>'STU-004','name'=>'Dinuka Jayasinghe','email'=>'dinuka@example.com','avatar'=>'DJ','color'=>'green','status'=>'Absent'],
            ['id'=>'STU-005','name'=>'Senuri Wijesinghe','email'=>'senuri@example.com','avatar'=>'SW','color'=>'orange','status'=>'Present'],
            ['id'=>'STU-006','name'=>'Tharushi Bandara','email'=>'tharushi@example.com','avatar'=>'TB','color'=>'purple','status'=>'Present'],
            ['id'=>'STU-007','name'=>'Pasindu Kumara','email'=>'pasindu@example.com','avatar'=>'PK','color'=>'blue','status'=>'Unmarked'],
            ['id'=>'STU-008','name'=>'Dinithi Rathnayake','email'=>'dinithi@example.com','avatar'=>'DR','color'=>'pink','status'=>'Present'],
            ['id'=>'STU-009','name'=>'Sathmi Gunawardena','email'=>'sathmi@example.com','avatar'=>'SG','color'=>'green','status'=>'Absent'],
            ['id'=>'STU-010','name'=>'Ravindu Peris','email'=>'ravindu@example.com','avatar'=>'RP','color'=>'orange','status'=>'Unmarked'],
        ];

        $presentCount = collect($students)->where('status', 'Present')->count();
        $absentCount = collect($students)->where('status', 'Absent')->count();
        $lateCount = collect($students)->where('status', 'Late')->count();
        $unmarkedCount = collect($students)->where('status', 'Unmarked')->count();
    @endphp

    <div class="container-fluid px-0">

        {{-- Page heading --}}
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
            <div>
                <div class="text-secondary small mb-2">
                    <i class="bi bi-house-door me-1"></i>
                    Home <i class="bi bi-chevron-right mx-1"></i> Attendance
                </div>

                <h2 class="attendance-title mb-1">Attendance</h2>
                <p class="text-secondary small mb-0">
                    Record and review student attendance for each class session.
                </p>
            </div>

            <div class="d-flex flex-wrap gap-2">
                <button type="button" class="btn btn-outline-secondary btn-sm rounded-3"
                        id="exportAttendance">
                    <i class="bi bi-download me-1"></i>Export CSV
                </button>

                <button type="button" class="btn attendance-primary"
                        data-bs-toggle="modal" data-bs-target="#reviewAttendanceModal">
                    <i class="bi bi-clipboard-check me-1"></i>Review Attendance
                </button>
            </div>
        </div>

        {{-- Session selection --}}
        <div class="card attendance-card mb-4">
            <div class="card-body p-3 p-md-4">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <div class="attendance-stat-icon att-purple">
                        <i class="bi bi-calendar2-check"></i>
                    </div>
                    <div>
                        <h6 class="fw-semibold mb-1">Class Session</h6>
                        <div class="attendance-muted">Choose a class and date to mark attendance.</div>
                    </div>
                </div>

                <div class="row g-3 align-items-end">
                    <div class="col-12 col-md-4">
                        <label for="classSelect" class="form-label small fw-semibold">Class</label>
                        <select id="classSelect" class="form-select attendance-filter">
                            <option value="Junior Dance" selected>Junior Dance</option>
                            <option value="Ballet Beginners">Ballet Beginners</option>
                            <option value="Hip Hop">Hip Hop</option>
                            <option value="Traditional Dance">Traditional Dance</option>
                        </select>
                    </div>

                    <div class="col-12 col-md-3">
                        <label for="sessionDate" class="form-label small fw-semibold">Session date</label>
                        <input type="date" id="sessionDate"
                               class="form-control attendance-filter"
                               value="{{ now()->format('Y-m-d') }}">
                    </div>

                    <div class="col-12 col-md-3">
                        <label for="sessionTime" class="form-label small fw-semibold">Session time</label>
                        <select id="sessionTime" class="form-select attendance-filter">
                            <option>4:00 PM - 5:30 PM</option>
                            <option>5:30 PM - 7:00 PM</option>
                            <option>7:00 PM - 8:30 PM</option>
                        </select>
                    </div>

                    <div class="col-12 col-md-2">
                        <button type="button" id="loadSession"
                                class="btn attendance-primary w-100">
                            <i class="bi bi-arrow-repeat me-1"></i>Load
                        </button>
                    </div>
                </div>

                <div class="d-flex flex-wrap align-items-center gap-3 mt-3">
                    <span class="attendance-date">
                        <i class="bi bi-geo-alt me-1"></i>
                        <span id="sessionLocation">Kiribathgoda</span>
                    </span>
                    <span class="attendance-muted">
                        <i class="bi bi-people me-1"></i>
                        <span id="sessionStudentCount">{{ count($students) }}</span> students in this demo register
                    </span>
                    <span class="attendance-muted">
                        <i class="bi bi-info-circle me-1"></i>Changes are temporary until connected to the backend.
                    </span>
                </div>
            </div>
        </div>

        {{-- Summary cards --}}
        <div class="row g-3 mb-4">
            <div class="col-6 col-xl-3">
                <div class="card attendance-card h-100">
                    <div class="card-body p-3">
                        <div class="d-flex justify-content-between align-items-start gap-2">
                            <div>
                                <div class="text-secondary small mb-2">Present</div>
                                <div class="attendance-stat-number text-success" id="presentCount">{{ $presentCount }}</div>
                                <div class="attendance-muted">Marked present</div>
                            </div>
                            <div class="attendance-stat-icon att-green">
                                <i class="bi bi-check-circle"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-xl-3">
                <div class="card attendance-card h-100">
                    <div class="card-body p-3">
                        <div class="d-flex justify-content-between align-items-start gap-2">
                            <div>
                                <div class="text-secondary small mb-2">Absent</div>
                                <div class="attendance-stat-number text-danger" id="absentCount">{{ $absentCount }}</div>
                                <div class="attendance-muted">Not attending</div>
                            </div>
                            <div class="attendance-stat-icon att-red">
                                <i class="bi bi-x-circle"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-xl-3">
                <div class="card attendance-card h-100">
                    <div class="card-body p-3">
                        <div class="d-flex justify-content-between align-items-start gap-2">
                            <div>
                                <div class="text-secondary small mb-2">Late</div>
                                <div class="attendance-stat-number" style="color:#d97706" id="lateCount">{{ $lateCount }}</div>
                                <div class="attendance-muted">Arrived late</div>
                            </div>
                            <div class="attendance-stat-icon att-orange">
                                <i class="bi bi-clock-history"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-xl-3">
                <div class="card attendance-card h-100">
                    <div class="card-body p-3">
                        <div class="d-flex justify-content-between align-items-start gap-2">
                            <div>
                                <div class="text-secondary small mb-2">Unmarked</div>
                                <div class="attendance-stat-number" style="color:#5141b8" id="unmarkedCount">{{ $unmarkedCount }}</div>
                                <div class="attendance-muted">Awaiting marking</div>
                            </div>
                            <div class="attendance-stat-icon att-purple">
                                <i class="bi bi-hourglass-split"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Attendance register --}}
        <div class="card attendance-card">
            <div class="card-body p-3 p-md-4">

                <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-3">
                    <div>
                        <h5 class="fw-semibold mb-1">Student Register</h5>
                        <p class="attendance-muted mb-0">
                            Mark each student as present, absent, or late.
                        </p>
                    </div>

                    <button type="button" class="btn btn-outline-primary btn-sm rounded-3"
                            id="markAllPresent">
                        <i class="bi bi-check2-all me-1"></i>Mark all present
                    </button>
                </div>

                <div class="d-flex flex-wrap gap-3 mb-3">
                    <span class="attendance-legend">
                        <span class="attendance-dot bg-success"></span>Present
                    </span>
                    <span class="attendance-legend">
                        <span class="attendance-dot bg-danger"></span>Absent
                    </span>
                    <span class="attendance-legend">
                        <span class="attendance-dot bg-warning"></span>Late
                    </span>
                    <span class="attendance-legend">
                        <span class="attendance-dot bg-secondary"></span>Unmarked
                    </span>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-12 col-md-5">
                        <label for="attendanceStatusFilter" class="form-label small fw-semibold">
                            Filter by status
                        </label>
                        <select id="attendanceStatusFilter" class="form-select attendance-filter">
                            <option value="">All students</option>
                            <option value="Present">Present</option>
                            <option value="Absent">Absent</option>
                            <option value="Late">Late</option>
                            <option value="Unmarked">Unmarked</option>
                        </select>
                    </div>
                </div>

                <div class="table-responsive">
                    <table id="attendanceTable" class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Student</th>
                                <th>Student ID</th>
                                <th>Attendance</th>
                                <th>Status</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($students as $student)
                                <tr data-student-id="{{ $student['id'] }}">
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="attendance-avatar avatar-{{ $student['color'] }}">
                                                {{ $student['avatar'] }}
                                            </div>
                                            <div>
                                                <div class="attendance-student-name">{{ $student['name'] }}</div>
                                                <div class="attendance-student-email">{{ $student['email'] }}</div>
                                            </div>
                                        </div>
                                    </td>

                                    <td>
                                        <span class="badge rounded-pill text-bg-light border">
                                            {{ $student['id'] }}
                                        </span>
                                    </td>

                                    <td>
                                        <div class="attendance-choice"
                                             role="group"
                                             aria-label="Mark attendance for {{ $student['name'] }}">
                                            <button type="button" data-status="Present"
                                                    aria-label="Present" title="Present"
                                                    class="{{ $student['status'] === 'Present' ? 'selected-present' : '' }}">P</button>
                                            <button type="button" data-status="Absent"
                                                    aria-label="Absent" title="Absent"
                                                    class="{{ $student['status'] === 'Absent' ? 'selected-absent' : '' }}">A</button>
                                            <button type="button" data-status="Late"
                                                    aria-label="Late" title="Late"
                                                    class="{{ $student['status'] === 'Late' ? 'selected-late' : '' }}">L</button>
                                            <button type="button" data-status="Unmarked"
                                                    aria-label="Unmarked" title="Clear status"
                                                    class="{{ $student['status'] === 'Unmarked' ? 'selected-unmarked' : '' }}">–</button>
                                        </div>
                                    </td>

                                    <td data-search="{{ $student['status'] }}">
                                        <span class="attendance-status"></span>
                                    </td>

                                    <td class="text-end">
                                        <button type="button" class="attendance-action"
                                                title="Add attendance note"
                                                onclick="openAttendanceNote(this)">
                                            <i class="bi bi-chat-left-text"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="border-top mt-3 pt-3">
                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                        <div class="flex-grow-1" style="max-width:320px">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="attendance-muted">Attendance completion</span>
                                <span class="small fw-semibold" id="completionText">60%</span>
                            </div>
                            <div class="progress attendance-progress">
                                <div class="progress-bar" id="completionBar"
                                     role="progressbar" style="width:60%"
                                     aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>

                        <button type="button" class="btn attendance-primary"
                                id="saveAttendance">
                            <i class="bi bi-check-lg me-1"></i>Save Attendance
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- Review modal --}}
    <div class="modal fade" id="reviewAttendanceModal" tabindex="-1"
         aria-labelledby="reviewAttendanceModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 rounded-4 shadow">
                <div class="modal-header border-0">
                    <div>
                        <h5 class="modal-title fw-semibold" id="reviewAttendanceModalLabel">
                            Review Attendance
                        </h5>
                        <div class="attendance-muted">Check the register before saving.</div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="d-flex justify-content-between py-2 border-bottom">
                        <span class="text-secondary">Class</span>
                        <strong id="reviewClass">Junior Dance</strong>
                    </div>
                    <div class="d-flex justify-content-between py-2 border-bottom">
                        <span class="text-secondary">Session date</span>
                        <strong id="reviewDate"></strong>
                    </div>
                    <div class="d-flex justify-content-between py-2 border-bottom">
                        <span class="text-secondary">Present</span>
                        <strong class="text-success" id="reviewPresent">0</strong>
                    </div>
                    <div class="d-flex justify-content-between py-2 border-bottom">
                        <span class="text-secondary">Absent</span>
                        <strong class="text-danger" id="reviewAbsent">0</strong>
                    </div>
                    <div class="d-flex justify-content-between py-2 border-bottom">
                        <span class="text-secondary">Late</span>
                        <strong class="text-warning" id="reviewLate">0</strong>
                    </div>
                    <div class="d-flex justify-content-between py-2">
                        <span class="text-secondary">Unmarked</span>
                        <strong id="reviewUnmarked">0</strong>
                    </div>

                    <div class="alert alert-info small mb-0 mt-3">
                        This is a UI demo. Saving will not update your database.
                    </div>
                </div>

                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light rounded-3"
                            data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn attendance-primary"
                            id="confirmSaveAttendance">
                        Confirm demo save
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Attendance note modal --}}
    <div class="modal fade" id="attendanceNoteModal" tabindex="-1"
         aria-labelledby="attendanceNoteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 rounded-4 shadow">
                <div class="modal-header">
                    <h5 class="modal-title fw-semibold" id="attendanceNoteModalLabel">
                        Attendance Note
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <label for="attendanceNote" class="form-label">Note</label>
                    <textarea id="attendanceNote" class="form-control" rows="3"
                              placeholder="Add a note for this student..."></textarea>
                    <div class="attendance-muted mt-2">
                        Notes are temporary in this demo.
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light rounded-3"
                            data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn attendance-primary"
                            id="saveAttendanceNote">Save note</button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(function () {
                const table = $('#attendanceTable').DataTable({
                    pageLength: 10,
                    lengthMenu: [5, 10, 25],
                    order: [[0, 'asc']],
                    autoWidth: false,
                    columnDefs: [
                        { orderable: false, targets: [2, 4] }
                    ],
                    language: {
                        search: '',
                        searchPlaceholder: 'Search students...',
                        lengthMenu: 'Show _MENU_ students',
                        info: 'Showing _START_ to _END_ of _TOTAL_ students',
                        infoEmpty: 'No students found',
                        zeroRecords: 'No matching students found'
                    }
                });

                function getStatuses() {
                    const statuses = { Present: 0, Absent: 0, Late: 0, Unmarked: 0 };

                    $('#attendanceTable tbody tr').each(function () {
                        const status = $(this).attr('data-status') || 'Unmarked';
                        statuses[status] = (statuses[status] || 0) + 1;
                    });

                    return statuses;
                }

                function updateSummary() {
                    const counts = getStatuses();
                    const total = Object.values(counts).reduce((a, b) => a + b, 0);
                    const marked = total - counts.Unmarked;
                    const percentage = total ? Math.round((marked / total) * 100) : 0;

                    $('#presentCount').text(counts.Present);
                    $('#absentCount').text(counts.Absent);
                    $('#lateCount').text(counts.Late);
                    $('#unmarkedCount').text(counts.Unmarked);
                    $('#completionText').text(percentage + '%');
                    $('#completionBar')
                        .css('width', percentage + '%')
                        .attr('aria-valuenow', percentage);

                    return counts;
                }

                function statusBadge(status) {
                    const badges = {
                        Present: '<span class="badge rounded-pill text-bg-success bg-opacity-10 text-success px-3 py-2"><i class="bi bi-check-circle-fill me-1"></i>Present</span>',
                        Absent: '<span class="badge rounded-pill text-bg-danger bg-opacity-10 text-danger px-3 py-2"><i class="bi bi-x-circle-fill me-1"></i>Absent</span>',
                        Late: '<span class="badge rounded-pill text-bg-warning bg-opacity-10 text-warning-emphasis px-3 py-2"><i class="bi bi-clock-fill me-1"></i>Late</span>',
                        Unmarked: '<span class="badge rounded-pill text-bg-secondary bg-opacity-10 text-secondary px-3 py-2">Unmarked</span>'
                    };

                    return badges[status] || badges.Unmarked;
                }

                function setStatus(row, status) {
                    row.attr('data-status', status);

                    row.find('.attendance-choice button')
                        .removeClass('selected-present selected-absent selected-late selected-unmarked');

                    const classNames = {
                        Present: 'selected-present',
                        Absent: 'selected-absent',
                        Late: 'selected-late',
                        Unmarked: 'selected-unmarked'
                    };

                    row.find('[data-status="' + status + '"]').addClass(classNames[status]);

                    row.find('.attendance-status').html(statusBadge(status));
                    row.children('td').eq(3).attr('data-search', status);

                    updateSummary();
                }

                // Initialize status badges and searchable status values.
                $('#attendanceTable tbody tr').each(function () {
                    const row = $(this);
                    const status = row.find('.attendance-choice button.selected-present').length
                        ? 'Present'
                        : row.find('.attendance-choice button.selected-absent').length
                            ? 'Absent'
                            : row.find('.attendance-choice button.selected-late').length
                                ? 'Late'
                                : 'Unmarked';

                    row.attr('data-status', status);
                    row.find('.attendance-status').html(statusBadge(status));
                });

                updateSummary();

                // Update a student's attendance status.
                $('#attendanceTable tbody').on('click', '.attendance-choice button', function () {
                    const row = $(this).closest('tr');
                    const status = $(this).data('status');
                    setStatus(row, status);
                    table.row(row).invalidate('dom').draw(false);
                });

                // Filter attendance status.
                $('#attendanceStatusFilter').on('change', function () {
                    table.column(3).search(this.value).draw();
                });

                // Mark all students present.
                $('#markAllPresent').on('click', function () {
                    $('#attendanceTable tbody tr').each(function () {
                        setStatus($(this), 'Present');
                    });

                    table.rows().invalidate('dom').draw(false);
                });

                // CSV export of currently filtered rows.
                $('#exportAttendance').on('click', function () {
                    const rows = table.rows({ search: 'applied' }).nodes().toArray();

                    const csvRows = [
                        ['Student', 'Student ID', 'Attendance'],
                        ...rows.map(row => [
                            row.querySelector('.attendance-student-name').textContent.trim(),
                            row.cells[1].textContent.trim(),
                            row.getAttribute('data-status') || 'Unmarked'
                        ])
                    ];

                    const csv = csvRows.map(row =>
                        row.map(value => '"' + String(value).replace(/"/g, '""') + '"').join(',')
                    ).join('\r\n');

                    const blob = new Blob(['\uFEFF' + csv], {
                        type: 'text/csv;charset=utf-8;'
                    });

                    const url = URL.createObjectURL(blob);
                    const link = document.createElement('a');
                    link.href = url;
                    link.download = 'attendance.csv';
                    link.click();
                    URL.revokeObjectURL(url);
                });

                function fillReview() {
                    const counts = updateSummary();

                    $('#reviewClass').text($('#classSelect').val());
                    $('#reviewDate').text($('#sessionDate').val());
                    $('#reviewPresent').text(counts.Present);
                    $('#reviewAbsent').text(counts.Absent);
                    $('#reviewLate').text(counts.Late);
                    $('#reviewUnmarked').text(counts.Unmarked);
                }

                $('#reviewAttendanceModal').on('show.bs.modal', fillReview);

                $('#saveAttendance').on('click', function () {
                    fillReview();

                    bootstrap.Modal.getOrCreateInstance(
                        document.getElementById('reviewAttendanceModal')
                    ).show();
                });

                $('#confirmSaveAttendance').on('click', function () {
                    if (typeof toastr !== 'undefined') {
                        toastr.success('Demo attendance reviewed. No database changes were made.');
                    } else {
                        alert('Demo attendance reviewed. No database changes were made.');
                    }

                    bootstrap.Modal.getOrCreateInstance(
                        document.getElementById('reviewAttendanceModal')
                    ).hide();
                });

                // Demo session changes only update the session heading.
                $('#loadSession').on('click', function () {
                    const locations = {
                        'Junior Dance': 'Kiribathgoda',
                        'Ballet Beginners': 'Nugegoda',
                        'Hip Hop': 'Colombo 03',
                        'Traditional Dance': 'Maharagama'
                    };

                    $('#sessionLocation').text(locations[$('#classSelect').val()] || 'Demo location');

                    if (typeof toastr !== 'undefined') {
                        toastr.info('Demo session selected. Student records have not been reloaded.');
                    }
                });

                // Temporary note entry.
                let currentNoteRow = null;

                window.openAttendanceNote = function (button) {
                    currentNoteRow = $(button).closest('tr');

                    $('#attendanceNote').val(currentNoteRow.data('note') || '');

                    bootstrap.Modal.getOrCreateInstance(
                        document.getElementById('attendanceNoteModal')
                    ).show();
                };

                $('#saveAttendanceNote').on('click', function () {
                    if (currentNoteRow) {
                        currentNoteRow.data('note', $('#attendanceNote').val());
                    }

                    bootstrap.Modal.getOrCreateInstance(
                        document.getElementById('attendanceNoteModal')
                    ).hide();

                    if (typeof toastr !== 'undefined') {
                        toastr.success('Demo note saved temporarily.');
                    }
                });
            });
        </script>
    @endpush
</x-app-layout>
