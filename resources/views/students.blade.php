
<x-app-layout>
    @section('title', 'Students | TDS Attendance')

    @push('styles')
        
        <style>
            .student-avatar {
                width: 42px;
                height: 42px;
                border-radius: 12px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                font-weight: 700;
                font-size: 14px;
                flex-shrink: 0;
            }

            .avatar-purple { background: #eee8ff; color: #6941c6; }
            .avatar-blue   { background: #e0f2fe; color: #0369a1; }
            .avatar-pink   { background: #fce7f3; color: #be185d; }
            .avatar-green  { background: #dcfce7; color: #15803d; }
            .avatar-orange { background: #ffedd5; color: #c2410c; }

            .student-card {
                border: 1px solid #eef0f6;
                border-radius: 16px;
                box-shadow: 0 4px 20px rgba(30, 41, 59, .04);
            }

            .student-stat-icon {
                width: 46px;
                height: 46px;
                border-radius: 13px;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 22px;
            }

            .stat-purple { background: #eee8ff; color: #6941c6; }
            .stat-green  { background: #dcfce7; color: #15803d; }
            .stat-orange { background: #ffedd5; color: #c2410c; }
            .stat-blue   { background: #dbeafe; color: #1d4ed8; }

            .student-name {
                color: #202437;
                font-weight: 600;
            }

            .student-subtitle {
                color: #9299ab;
                font-size: 12px;
            }

            .student-action {
                width: 34px;
                height: 34px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                border-radius: 9px;
                border: 1px solid #e9eaf0;
                background: white;
                color: #626a7e;
            }

            .student-action:hover {
                background: #f0efff;
                color: #6941c6;
            }

            #studentsTable thead th {
                background: #f8f9fc;
                color: #737b90;
                font-size: 11px;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: .5px;
                white-space: nowrap;
                border-bottom: 1px solid #e9eaf0;
                padding: 16px 14px;
            }

            #studentsTable tbody td {
                padding: 14px;
                border-color: #f0f1f6;
            }

            #studentsTable_wrapper .dt-search input,
            #studentsTable_wrapper .dt-length select {
                border: 1px solid #e1e4ed;
                border-radius: 8px;
                padding: 7px 10px;
            }

            #studentsTable_wrapper .dt-search input:focus {
                border-color: #8b7cf6;
                outline: 3px solid #eeeaff;
            }

            .student-table-wrap {
                overflow-x: auto;
            }

            .filter-select {
                min-width: 150px;
                border-radius: 9px;
                border-color: #e1e4ed;
                padding: 10px 12px;
            }

            .student-primary-btn {
                background: #6750d8;
                border-color: #6750d8;
                color: white;
                border-radius: 10px;
                padding: 10px 16px;
                font-weight: 600;
            }

            .student-primary-btn:hover {
                background: #5540c4;
                border-color: #5540c4;
                color: white;
            }

            @media (max-width: 575.98px) {
                .student-page-title { font-size: 23px; }
                .student-toolbar { align-items: stretch !important; }
                .student-toolbar .btn { width: 100%; }
            }
        </style>
    @endpush

    <div class="container-fluid px-0">

        {{-- Page heading --}}
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
            <div>
                <div class="text-secondary small mb-2">
                    <i class="bi bi-house-door me-1"></i>
                    Home <i class="bi bi-chevron-right mx-1"></i> Students
                </div>

                <h2 class="student-page-title fw-bold mb-1">Students</h2>

                <p class="text-secondary mb-0">
                    Manage your dance students and their class registrations.
                </p>
            </div>

            <button type="button"
                    class="btn student-primary-btn"
                    data-bs-toggle="modal"
                    data-bs-target="#studentModal">
                <i class="bi bi-plus-lg me-2"></i>Add Student
            </button>
        </div>

        {{-- Summary cards --}}
        <div class="row g-3 mb-4">

            <div class="col-6 col-xl-3">
                <div class="card student-card h-100">
                    <div class="card-body p-3 p-md-4">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <div class="text-secondary small mb-2">Total Students</div>
                                <h3 class="fw-bold mb-2" id="totalStudents">8</h3>
                                <span class="small text-success">
                                    <i class="bi bi-people me-1"></i>All registered
                                </span>
                            </div>
                            <div class="student-stat-icon stat-purple">
                                <i class="bi bi-people"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-xl-3">
                <div class="card student-card h-100">
                    <div class="card-body p-3 p-md-4">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <div class="text-secondary small mb-2">Active Students</div>
                                <h3 class="fw-bold mb-2 text-success" id="activeStudents">6</h3>
                                <span class="small text-secondary">Currently learning</span>
                            </div>
                            <div class="student-stat-icon stat-green">
                                <i class="bi bi-person-check"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-xl-3">
                <div class="card student-card h-100">
                    <div class="card-body p-3 p-md-4">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <div class="text-secondary small mb-2">New This Month</div>
                                <h3 class="fw-bold mb-2 text-primary">2</h3>
                                <span class="small text-secondary">Recently registered</span>
                            </div>
                            <div class="student-stat-icon stat-blue">
                                <i class="bi bi-person-plus"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-xl-3">
                <div class="card student-card h-100">
                    <div class="card-body p-3 p-md-4">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <div class="text-secondary small mb-2">Inactive Students</div>
                                <h3 class="fw-bold mb-2 text-warning" id="inactiveStudents">2</h3>
                                <span class="small text-secondary">Not currently active</span>
                            </div>
                            <div class="student-stat-icon stat-orange">
                                <i class="bi bi-person-dash"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        {{-- Students table --}}
        <div class="card student-card">
            <div class="card-body p-3 p-md-4">

                <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
                    <div>
                        <h5 class="fw-bold mb-1">All Students</h5>
                        <p class="text-secondary small mb-0">
                            View and manage registered students.
                        </p>
                    </div>

                    <button type="button" class="btn btn-outline-secondary rounded-3"
                            id="exportStudents">
                        <i class="bi bi-download me-2"></i>Export CSV
                    </button>
                </div>

                {{-- Filters --}}
                <div class="row g-3 mb-4">
                    <div class="col-12 col-md-6 col-lg-4">
                        <label for="statusFilter" class="form-label small fw-semibold">
                            Student Status
                        </label>
                        <select id="statusFilter" class="form-select filter-select">
                            <option value="">All statuses</option>
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                    </div>

                    <div class="col-12 col-md-6 col-lg-4">
                        <label for="genderFilter" class="form-label small fw-semibold">
                            Gender
                        </label>
                        <select id="genderFilter" class="form-select filter-select">
                            <option value="">All genders</option>
                            <option value="Female">Female</option>
                            <option value="Male">Male</option>
                        </select>
                    </div>

                    <div class="col-12 col-lg-4">
                        <label for="classFilter" class="form-label small fw-semibold">
                            Class
                        </label>
                        <select id="classFilter" class="form-select filter-select w-100">
                            <option value="">All classes</option>
                            <option value="Junior Dance">Junior Dance</option>
                            <option value="Ballet">Ballet</option>
                            <option value="Hip Hop">Hip Hop</option>
                            <option value="Traditional Dance">Traditional Dance</option>
                        </select>
                    </div>
                </div>

                <div class="student-table-wrap">
                    <table id="studentsTable" class="table table-hover align-middle w-100">
                        <thead>
                            <tr>
                                <th>Student</th>
                                <th>Student ID</th>
                                <th>Class</th>
                                <th>Gender</th>
                                <th>Phone</th>
                                <th>Joined Date</th>
                                <th>Status</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @php
                                $students = [
                                    ['id'=>'STU-001','name'=>'Amaya Perera','email'=>'amaya@example.com','class'=>'Junior Dance','gender'=>'Female','phone'=>'077 123 4567','joined'=>'2026-01-12','status'=>'Active','color'=>'purple'],
                                    ['id'=>'STU-002','name'=>'Kavindu Silva','email'=>'kavindu@example.com','class'=>'Hip Hop','gender'=>'Male','phone'=>'071 234 5678','joined'=>'2026-02-05','status'=>'Active','color'=>'blue'],
                                    ['id'=>'STU-003','name'=>'Nethmi Fernando','email'=>'nethmi@example.com','class'=>'Ballet','gender'=>'Female','phone'=>'076 345 6789','joined'=>'2026-02-18','status'=>'Active','color'=>'pink'],
                                    ['id'=>'STU-004','name'=>'Dinuka Jayasinghe','email'=>'dinuka@example.com','class'=>'Traditional Dance','gender'=>'Male','phone'=>'075 456 7890','joined'=>'2026-03-01','status'=>'Inactive','color'=>'green'],
                                    ['id'=>'STU-005','name'=>'Senuri Wijesinghe','email'=>'senuri@example.com','class'=>'Junior Dance','gender'=>'Female','phone'=>'072 567 8901','joined'=>'2026-03-10','status'=>'Active','color'=>'orange'],
                                    ['id'=>'STU-006','name'=>'Tharushi Bandara','email'=>'tharushi@example.com','class'=>'Ballet','gender'=>'Female','phone'=>'078 678 9012','joined'=>'2026-04-02','status'=>'Active','color'=>'purple'],
                                    ['id'=>'STU-007','name'=>'Pasindu Kumara','email'=>'pasindu@example.com','class'=>'Hip Hop','gender'=>'Male','phone'=>'070 789 0123','joined'=>'2026-04-15','status'=>'Inactive','color'=>'blue'],
                                    ['id'=>'STU-008','name'=>'Dinithi Rathnayake','email'=>'dinithi@example.com','class'=>'Junior Dance','gender'=>'Female','phone'=>'074 890 1234','joined'=>'2026-05-04','status'=>'Active','color'=>'pink'],
                                ];
                            @endphp

                            @foreach ($students as $student)
                                <tr>
                                    <td data-order="{{ $student['name'] }}">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="student-avatar avatar-{{ $student['color'] }}">
                                                {{ collect(explode(' ', $student['name']))->map(fn($part) => strtoupper(substr($part, 0, 1)))->take(2)->implode('') }}
                                            </div>
                                            <div>
                                                <div class="student-name">
                                                    {{ $student['name'] }}
                                                </div>
                                                <div class="student-subtitle">
                                                    {{ $student['email'] }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <td>
                                        <span class="badge rounded-pill text-bg-light border">
                                            {{ $student['id'] }}
                                        </span>
                                    </td>

                                    <td>
                                        <span class="badge rounded-pill text-bg-primary bg-opacity-10 text-primary px-3 py-2">
                                            {{ $student['class'] }}
                                        </span>
                                    </td>

                                    <td>
                                        <span class="text-secondary">{{ $student['gender'] }}</span>
                                    </td>

                                    <td class="text-nowrap">{{ $student['phone'] }}</td>

                                    <td data-order="{{ $student['joined'] }}">
                                        {{ \Carbon\Carbon::parse($student['joined'])->format('d M Y') }}
                                    </td>

                                    <td data-search="{{ $student['status'] }}">
                                        @if ($student['status'] === 'Active')
                                            <span class="badge rounded-pill text-bg-success bg-opacity-10 text-success px-3 py-2">
                                                <i class="bi bi-check-circle-fill me-1"></i>Active
                                            </span>
                                        @else
                                            <span class="badge rounded-pill text-bg-warning bg-opacity-10 text-warning-emphasis px-3 py-2">
                                                <i class="bi bi-pause-circle-fill me-1"></i>Inactive
                                            </span>
                                        @endif
                                    </td>

                                    <td class="text-end text-nowrap">
                                        <button type="button"
                                                class="student-action me-1"
                                                title="View student"
                                                data-student="{{ $student['id'] }}"
                                                onclick="viewStudent(this)">
                                            <i class="bi bi-eye"></i>
                                        </button>

                                        <button type="button"
                                                class="student-action me-1"
                                                title="Edit student"
                                                onclick="alert('Dummy UI: Edit {{ $student['name'] }}')">
                                            <i class="bi bi-pencil"></i>
                                        </button>

                                        <button type="button"
                                                class="student-action"
                                                title="More options"
                                                onclick="alert('Dummy UI: More options for {{ $student['name'] }}')">
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

    {{-- Add student modal: UI demo only --}}
    <div class="modal fade" id="studentModal" tabindex="-1"
         aria-labelledby="studentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 rounded-4 shadow">
                <div class="modal-header border-0 px-4 pt-4">
                    <div>
                        <h5 class="modal-title fw-bold" id="studentModalLabel">Add Student</h5>
                        <p class="small text-secondary mb-0">Enter the student's basic details.</p>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                </div>

                <form id="addStudentForm">
                    <div class="modal-body px-4">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Full name</label>
                            <input type="text" class="form-control" name="name"
                                   placeholder="Enter student name" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Email address</label>
                            <input type="email" class="form-control" name="email"
                                   placeholder="student@example.com">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Phone number</label>
                            <input type="tel" class="form-control" name="phone"
                                   placeholder="07X XXX XXXX" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Class</label>
                            <select class="form-select" name="class" required>
                                <option value="">Select class</option>
                                <option>Junior Dance</option>
                                <option>Ballet</option>
                                <option>Hip Hop</option>
                                <option>Traditional Dance</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Gender</label>
                            <select class="form-select" name="gender" required>
                                <option value="">Select gender</option>
                                <option>Female</option>
                                <option>Male</option>
                            </select>
                        </div>
                    </div>

                    <div class="modal-footer border-0 px-4 pb-4">
                        <button type="button" class="btn btn-light rounded-3"
                                data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn student-primary-btn">
                            <i class="bi bi-check-lg me-1"></i>Save Student
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- View student modal --}}
    <div class="modal fade" id="viewStudentModal" tabindex="-1"
         aria-labelledby="viewStudentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 rounded-4 shadow">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="viewStudentModalLabel">
                        Student Details
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                </div>
                <div class="modal-body" id="studentDetails">
                    Select a student to view details.
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
       

        <script>
            $(function () {
                const table = $('#studentsTable').DataTable({
                    pageLength: 5,
                    lengthMenu: [5, 10, 25],
                    order: [[0, 'asc']],
                    autoWidth: false,
                    scrollX: false,
                    language: {
                        search: '',
                        searchPlaceholder: 'Search students...',
                        lengthMenu: 'Show _MENU_ students',
                        info: 'Showing _START_ to _END_ of _TOTAL_ students',
                        infoEmpty: 'No students found',
                        zeroRecords: 'No matching students found',
                        paginate: {
                            previous: '<i class="bi bi-chevron-left"></i>',
                            next: '<i class="bi bi-chevron-right"></i>'
                        }
                    },
                    columnDefs: [
                        { orderable: false, targets: 7 }
                    ]
                });

                // Filter by status
                $('#statusFilter').on('change', function () {
                    table.column(6).search(this.value).draw();
                });

                // Filter by gender
                $('#genderFilter').on('change', function () {
                    table.column(3).search(this.value).draw();
                });

                // Filter by class
                $('#classFilter').on('change', function () {
                    table.column(2).search(this.value).draw();
                });

                // Export currently filtered table rows to CSV
                $('#exportStudents').on('click', function () {
                    const rows = table.rows({ search: 'applied' }).data().toArray();
                    const csv = [
                        ['Student', 'Student ID', 'Class', 'Gender', 'Phone', 'Joined Date', 'Status'],
                        ...rows.map(row => row.slice(0, 7).map(cell =>
                            $('<div>').html(cell).text().trim()
                        ))
                    ];

                    const content = csv.map(row =>
                        row.map(value => '"' + String(value).replace(/"/g, '""') + '"').join(',')
                    ).join('\r\n');

                    const blob = new Blob(['\uFEFF' + content], {
                        type: 'text/csv;charset=utf-8;'
                    });

                    const url = URL.createObjectURL(blob);
                    const link = document.createElement('a');
                    link.href = url;
                    link.download = 'students.csv';
                    link.click();
                    URL.revokeObjectURL(url);
                });

                // Demo-only add action; no database changes
                $('#addStudentForm').on('submit', function (event) {
                    event.preventDefault();
                    alert('Demo only: this form is not connected to the database yet.');
                });
            });

            // Demo-only view modal
            function viewStudent(button) {
                const id = button.dataset.student;
                const row = button.closest('tr');

                document.getElementById('studentDetails').innerHTML =
                    '<div class="text-center mb-3">' +
                    '<div class="student-avatar avatar-purple mx-auto mb-2">' +
                    '<i class="bi bi-person-fill fs-4"></i></div>' +
                    '<h5 class="fw-bold">' +
                    row.cells[0].querySelector('.student-name').textContent.trim() +
                    '</h5><span class="badge text-bg-light border">' + id + '</span></div>' +
                    '<div class="list-group list-group-flush">' +
                    '<div class="list-group-item d-flex justify-content-between gap-3">' +
                    '<span class="text-secondary">Class</span><strong>' +
                    row.cells[2].textContent.trim() + '</strong></div>' +
                    '<div class="list-group-item d-flex justify-content-between gap-3">' +
                    '<span class="text-secondary">Gender</span><strong>' +
                    row.cells[3].textContent.trim() + '</strong></div>' +
                    '<div class="list-group-item d-flex justify-content-between gap-3">' +
                    '<span class="text-secondary">Phone</span><strong>' +
                    row.cells[4].textContent.trim() + '</strong></div>' +
                    '<div class="list-group-item d-flex justify-content-between gap-3">' +
                    '<span class="text-secondary">Joined</span><strong>' +
                    row.cells[5].textContent.trim() + '</strong></div></div>';

                bootstrap.Modal.getOrCreateInstance(
                    document.getElementById('viewStudentModal')
                ).show();
            }
        </script>
    @endpush
</x-app-layout>