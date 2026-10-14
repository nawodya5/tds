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

            .avatar-purple {
                background: #eee8ff;
                color: #6941c6;
            }

            .avatar-blue {
                background: #e0f2fe;
                color: #0369a1;
            }

            .avatar-pink {
                background: #fce7f3;
                color: #be185d;
            }

            .avatar-green {
                background: #dcfce7;
                color: #15803d;
            }

            .avatar-orange {
                background: #ffedd5;
                color: #c2410c;
            }

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

            .stat-purple {
                background: #eee8ff;
                color: #6941c6;
            }

            .stat-green {
                background: #dcfce7;
                color: #15803d;
            }

            .stat-orange {
                background: #ffedd5;
                color: #c2410c;
            }

            .stat-blue {
                background: #dbeafe;
                color: #1d4ed8;
            }

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
                .student-page-title {
                    font-size: 23px;
                }

                .student-toolbar {
                    align-items: stretch !important;
                }

                .student-toolbar .btn {
                    width: 100%;
                }
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

            <button type="button" class="btn student-primary-btn" data-bs-toggle="modal" data-bs-target="#studentModal">
                <i class="bi bi-plus-lg me-2"></i>Add Student
            </button>
        </div>

        {{-- Summary cards --}}

        {{-- Summary cards --}}
        <div class="row g-3 mb-4">

            <div class="col-6 col-xl-3">
                <div class="card student-card h-100">
                    <div class="card-body p-3 p-md-4">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <div class="text-secondary small mb-2">Total Students</div>
                                <h3 class="fw-bold mb-2" id="totalStudents">
                                    {{ $students->total() }}
                                </h3>
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
                                <h3 class="fw-bold mb-2 text-success" id="activeStudents">
                                    {{ $activeStudents }}
                                </h3>
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
                                <h3 class="fw-bold mb-2 text-primary">
                                    {{ $newStudentsThisMonth }}
                                </h3>
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
                                <h3 class="fw-bold mb-2 text-warning" id="inactiveStudents">
                                    {{ $inactiveStudents }}
                                </h3>
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

                    <button type="button" class="btn btn-outline-secondary rounded-3" id="exportStudents">
                        <i class="bi bi-download me-2"></i>Export CSV
                    </button>
                </div>

                {{-- Filters --}}

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
                            <option value="Other">Other</option>
                        </select>
                    </div>

                    <div class="col-12 col-lg-4">
                        <label for="classFilter" class="form-label small fw-semibold">
                            Class
                        </label>

                        <select id="classFilter" class="form-select filter-select w-100">
                            <option value="">All classes</option>

                            @foreach ($classes as $class)
                                <option value="{{ $class->name }}">
                                    {{ $class->name }}
                                </option>
                            @endforeach
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
                            @forelse ($students as $student)
                                @php
                                    $primaryRegistration = $student->registrations->first(
                                        fn($registration) => $registration->is_primary_class,
                                    );

                                    $primaryClass = $primaryRegistration?->classroom;

                                    $initials = collect(explode(' ', trim($student->name)))
                                        ->filter()
                                        ->map(fn($part) => strtoupper(substr($part, 0, 1)))
                                        ->take(2)
                                        ->implode('');

                                    $avatarColors = ['purple', 'blue', 'pink', 'green', 'orange'];
                                    $avatarColor = $avatarColors[$student->id % count($avatarColors)];
                                @endphp

                                <tr>
                                    <td data-order="{{ $student->name }}">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="student-avatar avatar-{{ $avatarColor }}">
                                                {{ $initials }}
                                            </div>

                                            <div>
                                                <div class="student-name">
                                                    {{ $student->name }}
                                                </div>
                                                <div class="student-subtitle">
                                                    {{ $student->student_contact_number }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <td>
                                        <span class="badge rounded-pill text-bg-light border">
                                            {{ $student->registration_number }}
                                        </span>
                                    </td>

                                    <td data-search="{{ $primaryClass?->name ?? 'No class' }}">
                                        @if ($primaryClass)
                                            <span
                                                class="badge rounded-pill text-bg-primary bg-opacity-10 text-primary px-3 py-2">
                                                {{ $primaryClass->name }}
                                            </span>

                                            @if ($student->registrations->where('status', true)->count() > 1)
                                                <div class="student-subtitle mt-1">
                                                    +{{ $student->registrations->where('status', true)->count() - 1 }}
                                                    more class(es)
                                                </div>
                                            @endif
                                        @else
                                            <span class="text-secondary">No class assigned</span>
                                        @endif
                                    </td>

                                    <td data-search="{{ $student->gender ?? '' }}">
                                        <span class="text-secondary">
                                            {{ $student->gender ?? '—' }}
                                        </span>
                                    </td>

                                    <td class="text-nowrap">
                                        {{ $student->student_contact_number }}
                                    </td>

                                    <td data-order="{{ $student->created_at?->format('Y-m-d') }}">
                                        {{ $student->created_at?->format('d M Y') ?? '—' }}
                                    </td>

                                    <td data-search="{{ $student->status ? 'Active' : 'Inactive' }}">
                                        @if ($student->status)
                                            <span
                                                class="badge rounded-pill text-bg-success bg-opacity-10 text-success px-3 py-2">
                                                <i class="bi bi-check-circle-fill me-1"></i>Active
                                            </span>
                                        @else
                                            <span
                                                class="badge rounded-pill text-bg-warning bg-opacity-10 text-warning-emphasis px-3 py-2">
                                                <i class="bi bi-pause-circle-fill me-1"></i>Inactive
                                            </span>
                                        @endif
                                    </td>

                                    <td class="text-end text-nowrap">

                                        <button type="button" class="student-action me-1" title="View student"
                                            onclick="viewStudent(this)" data-name="{{ $student->name }}"
                                            data-registration="{{ $student->registration_number }}"
                                            data-phone="{{ $student->student_contact_number }}"
                                            data-dob="{{ $student->date_of_birth?->format('d M Y') ?? '' }}"
                                            data-gender="{{ $student->gender ?? '' }}"
                                            data-class="{{ $primaryClass?->name ?? 'No class assigned' }}"
                                            data-address="{{ $student->address ?? '' }}"
                                            data-notes="{{ $student->notes ?? '' }}"
                                            data-joined="{{ $student->created_at?->format('d M Y') ?? '' }}"
                                            data-status="{{ $student->status ? 'Active' : 'Inactive' }}">
                                            <i class="bi bi-eye"></i>
                                        </button>


                                        <button type="button" class="student-action me-1" title="Edit student"
                                            onclick="editStudent({{ $student->id }})">
                                            <i class="bi bi-pencil"></i>
                                        </button>

                                        <button type="button" class="student-action" title="Delete student"
                                            onclick="deleteStudent({{ $student->id }}, @js($student->name))">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-secondary py-5">
                                        <i class="bi bi-people fs-3 d-block mb-2"></i>
                                        No students registered yet.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>

                    </table>
                </div>

            </div>
        </div>
    </div>


    {{-- Add student modal --}}
    <div class="modal fade" id="studentModal" tabindex="-1" aria-labelledby="studentModalLabel"
        aria-hidden="true">

        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 rounded-4 shadow">

                <div class="modal-header border-0 px-4 pt-4">
                    <div>
                        <h5 class="modal-title fw-bold" id="studentModalLabel">
                            Add Student
                        </h5>
                        <p class="small text-secondary mb-0">
                            Enter the student's details and select their primary class.
                        </p>
                    </div>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form id="addStudentForm" action="{{ route('students.store') }}" method="POST">
                    @csrf

                    <div class="modal-body px-4">

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="row g-3">

                            <div class="col-12">
                                <label for="studentName" class="form-label fw-semibold">
                                    Full Name <span class="text-danger">*</span>
                                </label>

                                <input type="text" class="form-control" id="studentName" name="name"
                                    value="{{ old('name') }}" placeholder="Enter student name" maxlength="255"
                                    required>
                            </div>

                            <div class="col-md-6">
                                <label for="studentDob" class="form-label fw-semibold">
                                    Date of Birth
                                </label>

                                <input type="date" class="form-control" id="studentDob" name="date_of_birth"
                                    value="{{ old('date_of_birth') }}" max="{{ now()->toDateString() }}">
                            </div>

                            <div class="col-md-6">
                                <label for="studentGender" class="form-label fw-semibold">
                                    Gender
                                </label>

                                <select class="form-select" id="studentGender" name="gender">

                                    <option value="">Select gender</option>
                                    <option value="Female" @selected(old('gender') === 'Female')>Female</option>
                                    <option value="Male" @selected(old('gender') === 'Male')>Male</option>
                                    <option value="Other" @selected(old('gender') === 'Other')>Other</option>
                                </select>
                            </div>

                            <div class="col-12">
                                <label for="studentPhone" class="form-label fw-semibold">
                                    Contact Number <span class="text-danger">*</span>
                                </label>

                                <input type="tel" class="form-control" id="studentPhone"
                                    name="student_contact_number" value="{{ old('student_contact_number') }}"
                                    placeholder="07X XXX XXXX" maxlength="20" required>
                            </div>

                            <div class="col-12">
                                <label for="studentAddress" class="form-label fw-semibold">
                                    Address
                                </label>

                                <textarea class="form-control" id="studentAddress" name="address" rows="2" maxlength="1000"
                                    placeholder="Enter student's address">{{ old('address') }}</textarea>
                            </div>

                            <div class="col-12">
                                <label for="studentClass" class="form-label fw-semibold">
                                    Primary Class <span class="text-danger">*</span>
                                </label>

                                <select class="form-select" id="studentClass" name="class_id" required>

                                    <option value="">Select class</option>

                                    @foreach ($classes as $class)
                                        <option value="{{ $class->id }}" @selected((string) old('class_id') === (string) $class->id)>
                                            {{ $class->name }}
                                            @if ($class->location)
                                                — {{ $class->location->name }}
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-12">
                                <label for="studentNotes" class="form-label fw-semibold">
                                    Notes
                                </label>

                                <textarea class="form-control" id="studentNotes" name="notes" rows="2" maxlength="2000"
                                    placeholder="Optional notes">{{ old('notes') }}</textarea>
                            </div>

                        </div>
                    </div>

                    <div class="modal-footer border-0 px-4 pb-4">
                        <button type="button" class="btn btn-light rounded-3" data-bs-dismiss="modal">
                            Cancel
                        </button>

                        <button type="submit" class="btn student-primary-btn">
                            <i class="bi bi-check-lg me-1"></i>
                            Save Student
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>



    {{-- View student modal --}}
    <div class="modal fade" id="viewStudentModal" tabindex="-1" aria-labelledby="viewStudentModalLabel"
        aria-hidden="true">

        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 rounded-4 shadow">

                <div class="modal-header border-0 px-4 pt-4">
                    <div>
                        <h5 class="modal-title fw-bold" id="viewStudentModalLabel">
                            Student Details
                        </h5>
                        <p class="small text-secondary mb-0">
                            View the student's registration information.
                        </p>
                    </div>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body px-4 pb-4">

                    <div class="d-flex align-items-center gap-3 mb-4">
                        <div id="viewStudentAvatar" class="student-avatar avatar-purple"
                            style="width: 56px; height: 56px; font-size: 18px;">
                            --
                        </div>

                        <div>
                            <h5 class="student-name mb-1" id="viewStudentName">—</h5>
                            <span class="badge rounded-pill text-bg-light border"
                                id="viewStudentRegistrationNumber">—</span>
                        </div>

                        <div class="ms-auto" id="viewStudentStatus"></div>
                    </div>

                    <div class="row g-3">

                        <div class="col-md-6">
                            <div class="border rounded-3 p-3 h-100">
                                <div class="text-secondary small mb-1">Contact Number</div>
                                <div class="fw-semibold" id="viewStudentPhone">—</div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="border rounded-3 p-3 h-100">
                                <div class="text-secondary small mb-1">Date of Birth</div>
                                <div class="fw-semibold" id="viewStudentDob">—</div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="border rounded-3 p-3 h-100">
                                <div class="text-secondary small mb-1">Gender</div>
                                <div class="fw-semibold" id="viewStudentGender">—</div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="border rounded-3 p-3 h-100">
                                <div class="text-secondary small mb-1">Primary Class</div>
                                <div class="fw-semibold" id="viewStudentClass">—</div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="border rounded-3 p-3">
                                <div class="text-secondary small mb-1">Address</div>
                                <div class="fw-semibold" id="viewStudentAddress">—</div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="border rounded-3 p-3">
                                <div class="text-secondary small mb-1">Notes</div>
                                <div class="fw-semibold" id="viewStudentNotes">—</div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="border rounded-3 p-3 h-100">
                                <div class="text-secondary small mb-1">Registration Date</div>
                                <div class="fw-semibold" id="viewStudentJoinedDate">—</div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="modal-footer border-0 px-4 pb-4">
                    <button type="button" class="btn btn-light rounded-3" data-bs-dismiss="modal">
                        Close
                    </button>
                </div>

            </div>
        </div>
    </div>



    @push('scripts')
        <script>
            $(document).ready(function() {
                const table = $('#studentsTable').DataTable({
                    pageLength: 10,
                    lengthMenu: [5, 10, 25, 50],
                    order: [
                        [0, 'asc']
                    ],
                    autoWidth: false,
                    scrollX: false,
                    language: {
                        search: '',
                        searchPlaceholder: 'Search students...',
                        lengthMenu: 'Show _MENU_ students',
                        info: 'Showing _START_ to _END_ of _TOTAL_ students',
                        infoEmpty: 'No students found',
                        zeroRecords: 'No matching students found',
                        emptyTable: 'No students registered yet.',
                        paginate: {
                            previous: '<i class="bi bi-chevron-left"></i>',
                            next: '<i class="bi bi-chevron-right"></i>'
                        }
                    },
                    columnDefs: [{
                        orderable: false,
                        targets: 7
                    }]
                });

                // Filter by student status.
                $('#statusFilter').on('change', function() {
                    table.column(6).search(
                        this.value ? '^' + $.fn.dataTable.util.escapeRegex(this.value) + '$' : '',
                        true,
                        false
                    ).draw();
                });

                // Filter by gender.
                $('#genderFilter').on('change', function() {
                    table.column(3).search(
                        this.value ? '^' + $.fn.dataTable.util.escapeRegex(this.value) + '$' : '',
                        true,
                        false
                    ).draw();
                });

                // Filter by class.
                $('#classFilter').on('change', function() {
                    table.column(2).search(
                        this.value ? '^' + $.fn.dataTable.util.escapeRegex(this.value) + '$' : '',
                        true,
                        false
                    ).draw();
                });

                // Export the currently filtered rows to CSV.
                $('#exportStudents').on('click', function() {
                    const headers = [
                        'Student',
                        'Registration Number',
                        'Class',
                        'Gender',
                        'Phone',
                        'Joined Date',
                        'Status'
                    ];

                    const rows = table.rows({
                        search: 'applied'
                    }).nodes().toArray();

                    const csvRows = [
                        headers,
                        ...rows.map(function(row) {
                            return Array.from(row.cells)
                                .slice(0, 7)
                                .map(function(cell) {
                                    return cell.innerText.trim().replace(/\s+/g, ' ');
                                });
                        })
                    ];

                    const csvContent = csvRows.map(function(row) {
                        return row.map(function(value) {
                            return '"' + String(value).replace(/"/g, '""') + '"';
                        }).join(',');
                    }).join('\r\n');

                    const blob = new Blob(['\uFEFF' + csvContent], {
                        type: 'text/csv;charset=utf-8;'
                    });

                    const url = URL.createObjectURL(blob);
                    const link = document.createElement('a');

                    link.href = url;
                    link.download = 'students.csv';
                    document.body.appendChild(link);
                    link.click();
                    link.remove();

                    URL.revokeObjectURL(url);
                });
            });

            // Display the selected student's details.
            function viewStudent(button) {
                const data = button.dataset;

                const setText = function(id, value) {
                    document.getElementById(id).textContent = value || '—';
                };

                const name = data.name || 'Unknown Student';

                const initials = name
                    .trim()
                    .split(/\s+/)
                    .filter(Boolean)
                    .map(function(part) {
                        return part.charAt(0).toUpperCase();
                    })
                    .slice(0, 2)
                    .join('');

                setText('viewStudentName', name);
                setText('viewStudentRegistrationNumber', data.registration);
                setText('viewStudentPhone', data.phone);
                setText('viewStudentDob', data.dob);
                setText('viewStudentGender', data.gender);
                setText('viewStudentClass', data.class);
                setText('viewStudentAddress', data.address);
                setText('viewStudentNotes', data.notes);
                setText('viewStudentJoinedDate', data.joined);

                const avatar = document.getElementById('viewStudentAvatar');
                avatar.textContent = initials || '--';

                const statusContainer = document.getElementById('viewStudentStatus');
                statusContainer.replaceChildren();

                const statusBadge = document.createElement('span');

                statusBadge.className = data.status === 'Active' ?
                    'badge rounded-pill text-bg-success bg-opacity-10 text-success px-3 py-2' :
                    'badge rounded-pill text-bg-warning bg-opacity-10 text-warning-emphasis px-3 py-2';

                statusBadge.textContent = data.status || 'Unknown';
                statusContainer.appendChild(statusBadge);

                bootstrap.Modal.getOrCreateInstance(
                    document.getElementById('viewStudentModal')
                ).show();
            }

            // Temporary placeholder until the Edit modal is added.
            function editStudent(id) {
                alert('Edit functionality will be connected in the next step.');
            }

            // Temporary placeholder until the Delete confirmation is added.
            function deleteStudent(id, name) {
                alert('Delete functionality will be connected in the next step.');
            }

            // Reopen the Add Student modal if Laravel returns validation errors.
            @if ($errors->any())
                document.addEventListener('DOMContentLoaded', function() {
                    const modalElement = document.getElementById('studentModal');

                    if (modalElement) {
                        bootstrap.Modal.getOrCreateInstance(modalElement).show();
                    }
                });
            @endif
        </script>
    @endpush

</x-app-layout>
