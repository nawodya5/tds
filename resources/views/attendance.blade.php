<x-app-layout>
    @section('title', 'Attendance | TDS Attendance')

    @push('styles')
    <style>
        .attendance-page .attendance-card {
            border: 1px solid #e9ebf2;
            border-radius: 15px;
            box-shadow: 0 4px 18px rgba(28, 39, 60, .04);
        }

        .attendance-page .attendance-primary {
            background: #6750d8;
            border-color: #6750d8;
            color: #fff;
            border-radius: 9px;
            font-weight: 600;
        }

        .attendance-page .attendance-primary:hover {
            background: #5540c4;
            border-color: #5540c4;
            color: #fff;
        }

        .attendance-page .attendance-icon {
            width: 44px;
            height: 44px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            font-size: 20px;
            flex-shrink: 0;
        }

        .attendance-page .icon-purple {
            background: #eee8ff;
            color: #6941c6;
        }

        .attendance-page .icon-red {
            background: #fee2e2;
            color: #b91c1c;
        }

        .attendance-page .icon-green {
            background: #dcfce7;
            color: #15803d;
        }

        .attendance-page .icon-orange {
            background: #ffedd5;
            color: #c2410c;
        }

        .attendance-page .form-select,
        .attendance-page .form-control {
            border-color: #dfe3ed;
            border-radius: 9px;
        }

        .attendance-page .form-select:focus,
        .attendance-page .form-control:focus {
            border-color: #8b7cf6;
            box-shadow: 0 0 0 .2rem rgba(103, 80, 216, .12);
        }

        .attendance-page .class-summary {
            background: linear-gradient(120deg, #fff 0%, #faf9ff 100%);
        }

        .attendance-page .student-avatar {
            width: 43px;
            height: 43px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: #eee8ff;
            color: #6045c5;
            font-weight: 700;
            flex-shrink: 0;
        }

        .attendance-page #attendanceTable thead th {
            background: #f8f9fc;
            color: #737b90;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: .45px;
            text-transform: uppercase;
            white-space: nowrap;
            border-bottom: 1px solid #e9eaf0;
            padding: 14px;
        }

        .attendance-page #attendanceTable tbody td {
            padding: 13px 14px;
            border-color: #f0f1f6;
        }

        .attendance-page .payment-paid {
            background: #e9f8ef;
            color: #137647;
        }

        .attendance-page .payment-unpaid {
            background: #fff0f0;
            color: #b42318;
        }

        .attendance-page .session-choice {
            border: 1px solid #e1e5ef;
            border-radius: 13px;
            padding: 14px 10px;
            min-height: 150px;
            background: linear-gradient(180deg, #ffffff 0%, #fafbff 100%);
            box-shadow: 0 3px 10px rgba(29, 36, 59, .035);
            transition: border-color .18s ease, box-shadow .18s ease, transform .18s ease;
        }

        .attendance-page .session-choice.today {
            border-color: #6750d8;
            background: linear-gradient(180deg, #f4f0ff 0%, #ebe5ff 100%);
            box-shadow: 0 0 0 2px rgba(103, 80, 216, .12);
        }

        .attendance-page .session-choice.locked {
            background: linear-gradient(180deg, #f8f9fc 0%, #f0f2f7 100%);
            color: #656d80;
        }

        .attendance-page .attendance-modal .modal-content {
            border: 0;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 24px 80px rgba(24, 26, 46, .22);
        }

        .attendance-page .attendance-modal .modal-header {
            color: #fff;
            background: linear-gradient(120deg, #5b43c5 0%, #7965e8 100%);
            border-bottom: 0;
        }

        .attendance-page .attendance-modal .modal-header .btn-close {
            filter: brightness(0) invert(1);
            opacity: .9;
        }

        .attendance-page .attendance-modal .modal-body {
            background: #f7f8fc;
        }

        .attendance-page .modal-section-card {
            background: #fff;
            border: 1px solid #e6e9f2;
            border-radius: 15px;
            padding: 16px;
            box-shadow: 0 4px 14px rgba(27, 36, 59, .035);
        }

        .attendance-page .modal-section-heading {
            display: flex;
            align-items: center;
            gap: 9px;
            color: #282b3a;
            font-weight: 700;
            margin-bottom: 14px;
        }

        .attendance-page .modal-section-heading .heading-icon {
            width: 32px;
            height: 32px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 9px;
            color: #6045c5;
            background: #eee9ff;
        }

        .attendance-page .modal-student-summary {
            background: linear-gradient(135deg, #fff 0%, #f6f3ff 100%);
            border: 1px solid #e3dcff;
            border-radius: 15px;
            box-shadow: 0 4px 14px rgba(75, 57, 153, .06);
        }

        .attendance-page .fee-panel {
            background: linear-gradient(120deg, #eafaf1 0%, #f5fff8 100%);
            border: 1px solid #bde8ce;
            border-radius: 13px;
        }

        .attendance-page .fee-panel.unpaid {
            background: linear-gradient(120deg, #fff0ef 0%, #fff8f7 100%);
            border-color: #f2c5c1;
        }

        .attendance-page .fee-panel .fee-icon {
            background: #d4f5e0;
            color: #167548;
        }

        .attendance-page .fee-panel.unpaid .fee-icon {
            background: #ffe0dd;
            color: #b42318;
        }

        .attendance-page .attendance-modal .modal-footer {
            background: #fff;
            border-top: 1px solid #eceef5;
        }

        .attendance-page .btn-attendance-cancel {
            color: #4c5365;
            background: #f0f2f7;
            border: 1px solid #dce1eb;
            border-radius: 10px;
            font-weight: 600;
        }

        .attendance-page .btn-attendance-cancel:hover {
            color: #34394a;
            background: #e3e7f0;
            border-color: #cbd2e1;
        }

        .attendance-page .fee-status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-weight: 700;
            font-size: 12px;
            border: 1px solid transparent;
        }

        .attendance-page .fee-status-badge.payment-paid {
            background: #d9f7e5 !important;
            color: #126b3a !important;
            border-color: #a9e9c1;
        }

        .attendance-page .fee-status-badge.payment-unpaid {
            background: #ffe2df !important;
            color: #a61b1b !important;
            border-color: #ffc5bf;
        }

        .attendance-page .attendance-modal .form-check-input {
            border-color: #aab1c2;
            cursor: pointer;
        }

        .attendance-page .attendance-modal .form-check-input:checked {
            background-color: #6750d8;
            border-color: #6750d8;
        }

        .attendance-page .attendance-modal .form-check-input:disabled {
            opacity: .45;
            cursor: not-allowed;
        }

        .attendance-page .session-choice.today {
            border-color: #6750d8;
            background: #f5f2ff;
            box-shadow: 0 0 0 1px #6750d8;
        }

        .attendance-page .session-choice.locked {
            background: #f8f9fc;
            color: #7b8192;
        }

        .attendance-page .fee-panel {
            background: #effaf4;
            border: 1px solid #d5f0df;
            border-radius: 11px;
        }

        .attendance-page .fee-panel.unpaid {
            background: #fff3f2;
            border-color: #f8d6d3;
        }

        .attendance-page .modal-student-summary {
            border: 1px solid #e8ebf3;
            border-radius: 12px;
        }

        .attendance-page .table-responsive {
            min-height: 120px;
        }

        @media (max-width: 575.98px) {
            .attendance-page .page-heading {
                font-size: 23px;
            }

            .attendance-page .session-choice {
                min-height: 130px;
            }
        }

        /* ===== Corrected modern Attendance Mark popup styling ===== */
        .attendance-page #attendanceStudentModal .modal-dialog {
            max-width: 760px;
        }

        .attendance-page #attendanceStudentModal .modal-content {
            border: 0;
            border-radius: 22px;
            overflow: hidden;
            background: #f5f6fc;
            box-shadow: 0 20px 60px rgba(37, 27, 83, .22);
        }

        .attendance-page #attendanceStudentModal .modal-header {
            padding: 22px 26px;
            color: #fff;
            background: linear-gradient(135deg, #5138b8, #8065ed);
            border: 0;
        }

        .attendance-page #attendanceStudentModal .modal-title {
            color: #fff;
            font-size: 21px;
            font-weight: 700;
        }

        .attendance-page #attendanceStudentModal .btn-close {
            filter: brightness(0) invert(1);
            opacity: .9;
        }

        .attendance-page #attendanceStudentModal .modal-body {
            padding: 24px;
            background: #f5f6fc;
        }

        .attendance-page #attendanceStudentModal .modal-section-card {
            margin-bottom: 18px;
            padding: 20px;
            background: #fff;
            border: 1px solid #e8e5f5;
            border-radius: 16px;
            box-shadow: 0 4px 14px rgba(49, 35, 100, .05);
        }

        .attendance-page #attendanceStudentModal .modal-section-heading {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 16px;
            color: #35246f;
            font-size: 16px;
            font-weight: 700;
        }

        .attendance-page #attendanceStudentModal .modal-section-heading .heading-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            flex-shrink: 0;
            color: #6748d5;
            background: #eee9ff;
            border-radius: 11px;
        }

        .attendance-page #attendanceStudentModal .modal-student-summary {
            padding: 18px;
            margin-bottom: 18px;
            background: linear-gradient(135deg, #f0ecff, #faf9ff);
            border: 1px solid #ded5ff;
            border-radius: 15px;
            box-shadow: 0 4px 14px rgba(75, 57, 153, .06);
        }

        .attendance-page #attendanceStudentModal .modal-student-summary h5,
        .attendance-page #attendanceStudentModal .modal-student-summary h6,
        .attendance-page #attendanceStudentModal .modal-student-summary strong {
            color: #35246f;
        }

        .attendance-page #attendanceStudentModal .modal-student-summary p,
        .attendance-page #attendanceStudentModal .modal-student-summary span {
            overflow-wrap: anywhere;
        }

        .attendance-page #attendanceStudentModal .session-choice {
            padding: 15px;
            background: linear-gradient(180deg, #fff, #faf9ff);
            border: 1px solid #e4e0f1;
            border-radius: 13px;
            box-shadow: 0 3px 10px rgba(29, 36, 59, .04);
            transition: border-color .2s ease, box-shadow .2s ease;
        }

        .attendance-page #attendanceStudentModal .session-choice:hover {
            border-color: #9b86ef;
            box-shadow: 0 4px 12px rgba(91, 67, 197, .09);
        }

        .attendance-page #attendanceStudentModal .session-choice strong,
        .attendance-page #attendanceStudentModal .session-choice label {
            color: #302852;
            font-weight: 600;
        }

        .attendance-page #attendanceStudentModal .session-choice small {
            color: #77718b;
        }

        .attendance-page #attendanceStudentModal .session-choice.today {
            background: linear-gradient(135deg, #f3efff, #eae3ff);
            border-color: #8065ed;
            box-shadow: 0 0 0 1px rgba(103, 80, 216, .45);
        }

        .attendance-page #attendanceStudentModal .session-choice.locked {
            color: #777d8e;
            background: #f0f1f5;
            border-color: #e0e2e9;
            box-shadow: none;
        }

        .attendance-page #attendanceStudentModal .session-choice.locked strong,
        .attendance-page #attendanceStudentModal .session-choice.locked label {
            color: #777d8e;
        }

        .attendance-page #attendanceStudentModal .form-check-input {
            width: 19px;
            height: 19px;
            border: 1.5px solid #b8b0d2;
            cursor: pointer;
        }

        .attendance-page #attendanceStudentModal .form-check-input:checked {
            background-color: #6748d5;
            border-color: #6748d5;
        }

        .attendance-page #attendanceStudentModal .form-check-input:focus {
            border-color: #8b73eb;
            box-shadow: 0 0 0 .2rem rgba(103, 72, 213, .16);
        }

        .attendance-page #attendanceStudentModal .form-check-input:disabled {
            opacity: .5;
            cursor: not-allowed;
        }

        .attendance-page #attendanceStudentModal .fee-panel {
            padding: 18px;
            background: linear-gradient(135deg, #edfaf3, #f7fdf9);
            border: 1px solid #bce8cf;
            border-radius: 15px;
        }

        .attendance-page #attendanceStudentModal .fee-panel label,
        .attendance-page #attendanceStudentModal .fee-panel strong {
            color: #17643d;
        }

        .attendance-page #attendanceStudentModal .fee-panel.unpaid {
            background: linear-gradient(135deg, #fff0ef, #fff8f7);
            border-color: #f2c5c1;
        }

        .attendance-page #attendanceStudentModal .fee-panel.unpaid label,
        .attendance-page #attendanceStudentModal .fee-panel.unpaid strong {
            color: #a61b29;
        }

        .attendance-page #attendanceStudentModal .fee-panel .fee-icon {
            color: #167548;
            background: #d4f5e0;
        }

        .attendance-page #attendanceStudentModal .fee-panel.unpaid .fee-icon {
            color: #b42318;
            background: #ffe0dd;
        }

        .attendance-page #attendanceStudentModal .fee-status-badge,
        .attendance-page #attendanceStudentModal .payment-paid,
        .attendance-page #attendanceStudentModal .payment-unpaid {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 6px 12px;
            border: 1px solid transparent;
            border-radius: 50rem;
            font-size: 12px;
            font-weight: 700;
            line-height: 1.3;
            white-space: nowrap;
        }

        .attendance-page #attendanceStudentModal .fee-status-badge.payment-paid,
        .attendance-page #attendanceStudentModal .payment-paid {
            color: #126638 !important;
            background: #d1f7df !important;
            border-color: #8ce0ae !important;
        }

        .attendance-page #attendanceStudentModal .fee-status-badge.payment-unpaid,
        .attendance-page #attendanceStudentModal .payment-unpaid {
            color: #a61b29 !important;
            background: #ffe0e0 !important;
            border-color: #ffb4b4 !important;
        }

        .attendance-page #attendanceStudentModal .form-switch .form-check-input {
            width: 44px;
            height: 24px;
            cursor: pointer;
        }

        .attendance-page #attendanceStudentModal .form-switch .form-check-input:checked {
            background-color: #198754;
            border-color: #198754;
        }

        .attendance-page #attendanceStudentModal .modal-footer {
            gap: 10px;
            padding: 18px 24px;
            background: #fff;
            border-top: 1px solid #e9e5f4;
        }

        .attendance-page #attendanceStudentModal .btn-attendance-cancel {
            padding: 10px 20px;
            color: #49445c !important;
            background: #ececf2 !important;
            border: 1px solid #d9d7e3 !important;
            border-radius: 10px;
            font-weight: 600;
        }

        .attendance-page #attendanceStudentModal .btn-attendance-cancel:hover {
            color: #302852 !important;
            background: #dedde8 !important;
            border-color: #cbc7d9 !important;
        }

        .attendance-page #attendanceStudentModal .attendance-primary,
        .attendance-page #attendanceStudentModal #saveAttendance {
            padding: 10px 22px;
            color: #fff !important;
            background: linear-gradient(135deg, #5b43c5, #8065ed) !important;
            border: 0 !important;
            border-radius: 10px;
            font-weight: 700;
            box-shadow: 0 4px 10px rgba(91, 67, 197, .2);
            transition: transform .2s ease, box-shadow .2s ease;
        }

        .attendance-page #attendanceStudentModal .attendance-primary:hover,
        .attendance-page #attendanceStudentModal #saveAttendance:hover {
            color: #fff !important;
            background: linear-gradient(135deg, #4932a8, #6c50dc) !important;
            transform: translateY(-1px);
            box-shadow: 0 6px 14px rgba(91, 67, 197, .28);
        }

        .attendance-page #attendanceStudentModal .attendance-primary:disabled,
        .attendance-page #attendanceStudentModal #saveAttendance:disabled {
            opacity: .6;
            transform: none;
            cursor: not-allowed;
        }

        @media (max-width: 576px) {
            .attendance-page #attendanceStudentModal .modal-dialog {
                margin: 10px;
            }

            .attendance-page #attendanceStudentModal .modal-header {
                padding: 17px;
            }

            .attendance-page #attendanceStudentModal .modal-title {
                font-size: 18px;
            }

            .attendance-page #attendanceStudentModal .modal-body {
                padding: 14px;
            }

            .attendance-page #attendanceStudentModal .modal-section-card {
                padding: 14px;
            }

            .attendance-page #attendanceStudentModal .modal-footer {
                padding: 14px;
            }

            .attendance-page #attendanceStudentModal .modal-footer .btn {
                flex: 1;
            }
        }
    </style>

    @endpush

    <div class="container-fluid attendance-page px-0">
        <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
            <div>
                <div class="text-secondary small mb-2">
                    <i class="bi bi-house-door me-1"></i> Home
                    <i class="bi bi-chevron-right mx-1"></i> Attendance
                </div>
                <h2 class="page-heading fw-bold mb-1">Attendance</h2>
                <p class="text-secondary mb-0">Search for a student and mark today's attendance.</p>
            </div>
        </div>

        <div class="card attendance-card class-summary mb-4">
            <div class="card-body p-3 p-md-4">
                <div class="row g-3 align-items-end">
                    <div class="col-12 col-xl-4">
                        <label for="attendanceClass" class="form-label small fw-semibold">Select Class</label>
                        <select id="attendanceClass" class="form-select">
                            <option value="">Choose a class...</option>
                            @foreach ($classes as $class)
                            <option value="{{ $class->id }}"
                                data-location="{{ $class->location->name ?? '—' }}"
                                data-start="{{ $class->start_time }}"
                                data-end="{{ $class->end_time }}">
                                {{ $class->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-md-6 col-xl-3">
                        <label for="attendanceSession" class="form-label small fw-semibold">Class Session</label>
                        <select id="attendanceSession" class="form-select" disabled>
                            <option value="">Select a class first</option>
                        </select>
                    </div>
                    <div class="col-12 col-md-6 col-xl-3">
                        <label class="form-label small fw-semibold">Session Time</label>
                        <div id="attendanceSessionTime" class="form-control bg-light">—</div>
                    </div>
                    <div class="col-12 col-xl-2">
                        <button type="button" id="loadAttendance" class="btn attendance-primary w-100" disabled>
                            <i class="bi bi-arrow-clockwise me-1"></i> Load
                        </button>
                    </div>
                </div>

                <hr class="my-4">

                <div class="d-flex flex-column flex-xl-row justify-content-between gap-4">
                    <div class="d-flex gap-3 align-items-start">
                        <div class="attendance-icon icon-purple"><i class="bi bi-geo-alt"></i></div>
                        <div>
                            <h5 class="fw-bold mb-2" id="summaryClassName">Choose a class</h5>
                            <div class="row g-3">
                                <div class="col-auto">
                                    <div class="small text-secondary">Location</div>
                                    <div class="fw-semibold" id="summaryLocation">—</div>
                                </div>
                                <div class="col-auto">
                                    <div class="small text-secondary">Time</div>
                                    <div class="fw-semibold" id="summaryTime">—</div>
                                </div>
                                <div class="col-auto">
                                    <div class="small text-secondary">Session Date</div>
                                    <div class="fw-semibold" id="summaryDate">—</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex flex-wrap gap-3">
                        <div class="d-flex align-items-center gap-2">
                            <div class="attendance-icon icon-purple"><i class="bi bi-people"></i></div>
                            <div>
                                <div class="fw-bold fs-5" id="summaryTotal">—</div>
                                <div class="small text-secondary">Students</div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <div class="attendance-icon icon-red"><i class="bi bi-wallet2"></i></div>
                            <div>
                                <div class="fw-bold fs-5 text-danger" id="summaryUnpaid">—</div>
                                <div class="small text-secondary">Unpaid This Month</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-6 col-xl-3">
                <div class="card attendance-card h-100">
                    <div class="card-body p-3 d-flex align-items-center gap-3">
                        <div class="attendance-icon icon-purple"><i class="bi bi-people"></i></div>
                        <div>
                            <div class="small text-secondary">Total Students</div>
                            <div class="fs-4 fw-bold" id="totalStudents">—</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-xl-3">
                <div class="card attendance-card h-100">
                    <div class="card-body p-3 d-flex align-items-center gap-3">
                        <div class="attendance-icon icon-red"><i class="bi bi-wallet2"></i></div>
                        <div>
                            <div class="small text-secondary">Unpaid This Month</div>
                            <div class="fs-4 fw-bold text-danger" id="unpaidStudents">—</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-xl-3">
                <div class="card attendance-card h-100">
                    <div class="card-body p-3 d-flex align-items-center gap-3">
                        <div class="attendance-icon icon-orange"><i class="bi bi-person-x"></i></div>
                        <div>
                            <div class="small text-secondary">Absent</div>
                            <div class="fs-4 fw-bold text-warning" id="absentStudents">—</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-xl-3">
                <div class="card attendance-card h-100">
                    <div class="card-body p-3 d-flex align-items-center gap-3">
                        <div class="attendance-icon icon-green"><i class="bi bi-person-check"></i></div>
                        <div>
                            <div class="small text-secondary">Unmarked</div>
                            <div class="fs-4 fw-bold text-success" id="unmarkedStudents">—</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="attendanceAlert" class="alert d-none" role="alert"></div>

        <div class="card attendance-card">
            <div class="card-body p-3 p-md-4">
                <div class="d-flex flex-column flex-md-row justify-content-between gap-3 mb-3">
                    <div>
                        <h5 class="fw-bold mb-1">Students</h5>
                        <p class="text-secondary small mb-0" id="studentListDescription">Select a class and session, then click Load.</p>
                    </div>
                    <div class="position-relative" style="max-width: 390px; width: 100%;">
                        <i class="bi bi-search position-absolute top-50 translate-middle-y text-secondary" style="left: 13px;"></i>
                        <input type="search" id="studentSearch" class="form-control ps-5" placeholder="Search name or registration number..." disabled>
                    </div>
                </div>

                <div class="table-responsive">
                    <table id="attendanceTable" class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Student</th>
                                <th>Registration No.</th>
                                <th>Attendance</th>
                                <th>Fee Status (This Month)</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="attendanceStudentsBody">
                            <tr>
                                <td colspan="5" class="text-center text-secondary py-5">Select a class and load a session to view students.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div id="attendanceEmpty" class="text-center py-5 d-none">
                    <i class="bi bi-people fs-1 text-secondary"></i>
                    <h6 class="fw-bold mt-3">No students found</h6>
                    <p class="text-secondary small mb-0">Try another search or check the selected class.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="attendanceStudentModal" tabindex="-1" aria-labelledby="attendanceStudentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable attendance-modal">
            <form id="attendanceStudentForm" class="modal-content">
                <div class="modal-header px-4 py-3">
                    <div>
                        <h5 class="modal-title fw-bold" id="attendanceStudentModalLabel">Mark Attendance</h5>
                        <p class="small text-secondary mb-0">Review this month's sessions and update the fee status.</p>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-3 p-md-4">
                    <section class="modal-section-card mb-3">
                        <div class="modal-student-summary p-3">
                            <div class="row align-items-center g-3">
                                <div class="col-12 col-lg-5">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="student-avatar" id="modalStudentInitials">—</div>
                                        <div class="min-w-0">
                                            <h5 class="fw-bold mb-1" id="modalStudentName">—</h5>
                                            <div class="small text-secondary" id="modalStudentReg">—</div>
                                            <div class="small mt-1" id="modalStudentClass">—</div>
                                            <div class="small text-secondary" id="modalStudentLocation">—</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-lg-3 border-start-lg">
                                    <div class="small text-secondary mb-1">Attendance (This Month)</div>
                                    <div class="fs-4 fw-bold text-success" id="modalAttendancePercent">—</div>
                                    <div class="small text-secondary" id="modalAttendanceCounts">—</div>
                                </div>
                                <div class="col-6 col-lg-4">
                                    <div class="small text-secondary mb-1">Fee Status (This Month)</div>
                                    <span class="badge rounded-pill px-3 py-2" id="modalFeeBadge">—</span>
                                    <div class="small text-secondary mt-2" id="modalFeeDate"></div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <section class="modal-section-card mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="modal-section-heading mb-0"><span class="heading-icon"><i class="bi bi-calendar2-check"></i></span> Class Sessions</h6>
                            <span class="badge rounded-pill text-bg-light border px-3 py-2" id="modalMonthLabel">—</span>
                        </div>
                        <div id="monthlySessions" class="row row-cols-2 row-cols-sm-3 row-cols-lg-5 g-2"></div>
                    </section>

                    <div class="alert alert-info py-2 small mt-3 mb-4">
                        <i class="bi bi-info-circle me-1"></i>
                        Only today's eligible session can be changed. Past sessions are locked and future sessions are disabled.
                    </div>

                    <div id="modalAttendanceError" class="alert alert-danger d-none" role="alert"></div>

                    <section class="modal-section-card mb-1">
                        <div class="modal-section-heading"><span class="heading-icon"><i class="bi bi-wallet2"></i></span> Monthly Fee Payment</div>
                        <div class="fee-panel p-3" id="feePanel">
                            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="attendance-icon fee-icon"><i class="bi bi-wallet2"></i></div>
                                    <div>
                                        <div class="fw-bold">Update Fee Payment Status</div>
                                        <div class="small text-secondary">Mark this student's monthly fee as paid.</div>
                                    </div>
                                </div>
                                <div class="form-check form-switch fs-5 mb-0">
                                    <input class="form-check-input" type="checkbox" role="switch" id="feePaidSwitch">
                                    <label class="form-check-label fs-6 fw-semibold" for="feePaidSwitch" id="feePaidLabel">Mark as Paid</label>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
                <div class="modal-footer px-4 py-3">
                    <button type="button" class="btn btn-attendance-cancel px-4" data-bs-dismiss="modal"><i class="bi bi-x-lg me-1"></i> Cancel</button>
                    <button type="submit" class="btn attendance-primary px-4 py-2" id="saveAttendanceButton">
                        <i class="bi bi-check2-circle me-1"></i> Save Attendance
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        $(function() {
            const urls = {
                sessions: @json(route('attendance.sessions')),
                students: @json(route('attendance.students')),
                details: @json(route('attendance.student-monthly-details')),
                save: @json(route('attendance.save'))
            };
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || @json(csrf_token());

            let currentClass = null;
            let currentSession = null;
            let currentStudents = [];
            let modalStudent = null;
            let modalDetails = null;
            let todayString = new Date().getFullYear() + '-' +
                String(new Date().getMonth() + 1).padStart(2, '0') + '-' +
                String(new Date().getDate()).padStart(2, '0');

            function escapeHtml(value) {
                return String(value ?? '').replace(/[&<>"']/g, char => ({
                    '&': '&amp;',
                    '<': '&lt;',
                    '>': '&gt;',
                    '"': '&quot;',
                    "'": '&#039;'
                } [char]));
            }

            function formatDate(value, options = {
                day: '2-digit',
                month: 'short',
                year: 'numeric'
            }) {
                if (!value) return '—';
                const date = new Date(String(value).slice(0, 10) + 'T00:00:00');
                return Number.isNaN(date.getTime()) ? '—' : date.toLocaleDateString('en-GB', options);
            }

            function formatTime(value) {
                if (!value) return '—';
                const parts = String(value).split(':').map(Number);
                const date = new Date();
                date.setHours(parts[0] || 0, parts[1] || 0, 0, 0);
                return date.toLocaleTimeString([], {
                    hour: 'numeric',
                    minute: '2-digit'
                });
            }

            function timeRange(start, end) {
                return `${formatTime(start)} – ${formatTime(end)}`;
            }

            function alertMessage(message, type = 'danger') {
                $('#attendanceAlert').removeClass('d-none alert-danger alert-success alert-warning')
                    .addClass('alert-' + type).text(message);
            }

            function clearAlert() {
                $('#attendanceAlert').addClass('d-none').text('');
            }

            function resetSummary() {
                $('#summaryTotal, #summaryUnpaid, #totalStudents, #unpaidStudents, #absentStudents, #unmarkedStudents').text('—');
            }

            function resetLoadedData() {
                currentClass = null;
                currentSession = null;
                currentStudents = [];
                resetSummary();
                $('#summaryClassName').text('Choose a class');
                $('#summaryLocation, #summaryTime, #summaryDate').text('—');
                $('#attendanceSessionTime').text('—');
                $('#studentListDescription').text('Select a class and session, then click Load.');
                $('#studentSearch').val('').prop('disabled', true);
                $('#loadAttendance').prop('disabled', !$('#attendanceClass').val());
                $('#attendanceStudentsBody').html('<tr><td colspan="5" class="text-center text-secondary py-5">Select a class and load a session to view students.</td></tr>');
                $('#attendanceEmpty').addClass('d-none');
            }

            function selectedDate(session) {
                return String(session?.session_date || '').slice(0, 10);
            }

            function renderSessionOptions(sessions, preferredSession) {
                const select = $('#attendanceSession');
                select.empty().append('<option value="">Choose a session...</option>');

                sessions.forEach(session => {
                    const date = selectedDate(session);
                    const label = `${formatDate(date)} · ${timeRange(session.start_time, session.end_time)}${session.status === 'Cancelled' ? ' · Cancelled' : ''}`;
                    select.append(new Option(label, session.id));
                });

                if (preferredSession && sessions.some(item => Number(item.id) === Number(preferredSession.id))) {
                    select.val(String(preferredSession.id));
                } else if (sessions.length) {
                    select.val(String(sessions[0].id));
                }

                select.prop('disabled', sessions.length === 0);
                updateSelectedSessionTime();
            }

            function updateSelectedSessionTime() {
                const sessionId = Number($('#attendanceSession').val());
                const session = window.attendanceSessions?.find(item => Number(item.id) === sessionId);
                currentSession = session || null;
                $('#attendanceSessionTime').text(session ? timeRange(session.start_time, session.end_time) : '—');
                $('#loadAttendance').prop('disabled', !$('#attendanceClass').val() || !session);
            }

            function loadClassSessions() {
                clearAlert();
                resetLoadedData();

                const classId = $('#attendanceClass').val();
                if (!classId) {
                    $('#attendanceSession').prop('disabled', true).html('<option value="">Select a class first</option>');
                    return;
                }

                const option = $('#attendanceClass option:selected');
                $('#summaryClassName').text(option.text().trim());
                $('#summaryLocation').text(option.data('location') || '—');
                $('#summaryTime').text(timeRange(option.data('start'), option.data('end')));
                $('#attendanceSession').prop('disabled', true).html('<option value="">Loading sessions...</option>');

                $.getJSON(urls.sessions, {
                        class_id: classId
                    })
                    .done(response => {
                        currentClass = response.class;
                        window.attendanceSessions = Array.isArray(response.sessions) ? response.sessions : [];
                        renderSessionOptions(window.attendanceSessions, response.selected_session);
                        $('#summaryClassName').text(response.class?.name || option.text().trim());
                        $('#summaryLocation').text(response.class?.location?.name || option.data('location') || '—');
                        if (currentSession) {
                            $('#summaryTime').text(timeRange(currentSession.start_time, currentSession.end_time));
                            $('#summaryDate').text(formatDate(selectedDate(currentSession)));
                        }
                        if (!window.attendanceSessions.length) {
                            alertMessage('No sessions are scheduled for this class in the selected month.', 'warning');
                        }
                    })
                    .fail(xhr => {
                        $('#attendanceSession').prop('disabled', true).html('<option value="">Unable to load sessions</option>');
                        alertMessage(xhr.responseJSON?.message || 'Unable to load class sessions.');
                    });
            }

            function renderStudents(students) {
                const body = $('#attendanceStudentsBody');
                body.empty();
                $('#attendanceEmpty').toggleClass('d-none', students.length > 0);

                if (!students.length) {
                    body.html('<tr><td colspan="5" class="text-center text-secondary py-4">No students match this search.</td></tr>');
                    return;
                }

                students.forEach(student => {
                    const initials = String(student.name || '?').trim().split(/\s+/).map(part => part[0]).slice(0, 2).join('').toUpperCase();
                    const status = student.attendance_status ?
                        `<span class="badge rounded-pill ${student.attendance_status === 'Present' ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger'}">${escapeHtml(student.attendance_status)}</span>` :
                        '<span class="badge rounded-pill bg-secondary-subtle text-secondary">Unmarked</span>';
                    const feeStatus = student.payment_status === 'Unpaid' ?
                        '<span class="badge rounded-pill payment-unpaid px-3 py-2">Unpaid</span>' :
                        '<span class="badge rounded-pill payment-paid px-3 py-2">Paid</span>';

                    body.append(`<tr data-student-id="${Number(student.id)}">
                            <td><div class="d-flex align-items-center gap-3"><span class="student-avatar">${escapeHtml(initials)}</span><span class="fw-semibold">${escapeHtml(student.name)}</span></div></td>
                            <td class="text-nowrap">${escapeHtml(student.registration_number)}</td>
                            <td>${status}</td>
                            <td>${feeStatus}</td>
                            <td><button type="button" class="btn btn-sm attendance-primary mark-attendance-btn" data-student-id="${Number(student.id)}"><i class="bi bi-check2-square me-1"></i>Mark Attendance</button></td>
                        </tr>`);
                });
            }

            function loadStudents() {
                clearAlert();
                const classId = $('#attendanceClass').val();
                const sessionId = $('#attendanceSession').val();

                if (!classId || !sessionId) {
                    alertMessage('Please select a class and session first.', 'warning');
                    return;
                }

                currentSession = window.attendanceSessions?.find(item => Number(item.id) === Number(sessionId)) || null;
                if (!currentSession) {
                    alertMessage('The selected session could not be found. Reload the class sessions.', 'warning');
                    return;
                }

                $('#loadAttendance').prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span>Loading...');
                $('#attendanceStudentsBody').html('<tr><td colspan="5" class="text-center text-secondary py-5">Loading students...</td></tr>');

                $.getJSON(urls.students, {
                        class_id: classId,
                        session_id: sessionId
                    })
                    .done(response => {
                        currentStudents = Array.isArray(response.data) ? response.data : [];
                        const summary = response.summary || {};
                        $('#totalStudents, #summaryTotal').text(summary.total_students ?? 0);
                        $('#unpaidStudents, #summaryUnpaid').text(summary.unpaid_students ?? 0);
                        $('#absentStudents').text(summary.absent_students ?? 0);
                        $('#unmarkedStudents').text(summary.unmarked_students ?? 0);
                        $('#summaryDate').text(formatDate(selectedDate(currentSession)));
                        $('#summaryTime').text(timeRange(currentSession.start_time, currentSession.end_time));
                        $('#studentListDescription').text(`${currentStudents.length} student(s) loaded for ${formatDate(selectedDate(currentSession))}.`);
                        $('#studentSearch').prop('disabled', false);
                        renderStudents(currentStudents);
                    })
                    .fail(xhr => {
                        $('#attendanceStudentsBody').html('<tr><td colspan="5" class="text-center text-danger py-5">Unable to load students.</td></tr>');
                        alertMessage(xhr.responseJSON?.message || 'Unable to load students for this session.');
                    })
                    .always(() => {
                        $('#loadAttendance').prop('disabled', false).html('<i class="bi bi-arrow-clockwise me-1"></i> Load');
                    });
            }

            function filterStudents() {
                const term = $('#studentSearch').val().trim().toLowerCase();
                const filtered = currentStudents.filter(student =>
                    String(student.name || '').toLowerCase().includes(term) ||
                    String(student.registration_number || '').toLowerCase().includes(term)
                );
                renderStudents(filtered);
            }

            function renderMonthlySessions(details) {
                const container = $('#monthlySessions').empty();
                const sessions = details.sessions || [];
                const selectedSessionId = Number(details.selected_session?.id);
                const monthDate = new Date(Number(details.year), Number(details.month) - 1, 1);
                $('#modalMonthLabel').text(monthDate.toLocaleDateString('en-US', {
                    month: 'long',
                    year: 'numeric'
                }));

                if (!sessions.length) {
                    container.html('<div class="col-12 text-secondary small py-3">No class sessions are scheduled for this month.</div>');
                    return;
                }

                sessions.forEach(session => {
                    const date = String(session.session_date).slice(0, 10);
                    const isPast = date < todayString;
                    const isToday = date === todayString;
                    const isFuture = date > todayString;
                    const cancelled = session.status === 'Cancelled';
                    const canMark = isToday && !cancelled && Number(session.id) === selectedSessionId;
                    const checked = session.attendance_status === 'Present';
                    const hasAttendance = Boolean(session.attendance_marked);
                    const locked = !canMark;
                    const label = cancelled ? 'Cancelled' : hasAttendance ?
                        escapeHtml(session.attendance_status) :
                        isToday ? 'Today' : isPast ? 'Not marked' : 'Upcoming';
                    const checkbox = cancelled ?
                        '<span class="badge bg-secondary-subtle text-secondary">No class</span>' :
                        `<input type="checkbox" class="form-check-input session-attendance-check" data-session-id="${Number(session.id)}" ${checked ? 'checked' : ''} ${locked ? 'disabled' : ''} aria-label="Mark present for ${escapeHtml(date)}">`;

                    container.append(`<div class="col">
                            <div class="session-choice h-100 d-flex flex-column align-items-center justify-content-between text-center ${canMark ? 'today' : ''} ${locked ? 'locked' : ''}">
                                <div>
                                    <div class="small text-secondary">${new Date(date + 'T00:00:00').toLocaleDateString('en-US', { weekday: 'short' })}</div>
                                    <div class="fw-semibold mb-1">${formatDate(date, { day: '2-digit', month: 'short' })}</div>
                                    <div class="small text-secondary">${formatTime(session.start_time)}</div>
                                </div>
                                <div class="my-2">${checkbox}</div>
                                <div class="small fw-semibold ${checked ? 'text-success' : canMark ? 'text-primary' : 'text-secondary'}">${label}</div>
                                ${locked ? '<i class="bi bi-lock small text-secondary mt-2"></i>' : '<i class="bi bi-unlock small text-primary mt-2"></i>'}
                            </div>
                        </div>`);
                });
            }

            function updateModalAttendanceSummary(details) {
                const sessions = details.sessions || [];
                const pastAndToday = sessions.filter(item => String(item.session_date).slice(0, 10) <= todayString && item.status !== 'Cancelled');
                const presentCount = pastAndToday.filter(item => item.attendance_status === 'Present').length;
                const absentCount = pastAndToday.filter(item => item.attendance_status === 'Absent').length;
                const markedCount = presentCount + absentCount;
                const percent = markedCount ? Math.round((presentCount / markedCount) * 100) : 0;
                $('#modalAttendancePercent').text(markedCount ? percent + '%' : '—');
                $('#modalAttendanceCounts').text(`${presentCount} Present / ${absentCount} Absent`);
            }

            function setPaymentAppearance(isPaid) {
                $('#feePaidLabel').text(isPaid ? 'Mark as Paid' : 'Mark as Unpaid');
                $('#feePanel').toggleClass('unpaid', !isPaid);
            }

            function openStudentModal(studentId) {
                modalStudent = currentStudents.find(item => Number(item.id) === Number(studentId));
                if (!modalStudent || !currentClass || !currentSession) return;

                $('#modalAttendanceError').addClass('d-none').text('');
                $('#modalStudentName').text(modalStudent.name || '—');
                $('#modalStudentReg').text(modalStudent.registration_number || '—');
                $('#modalStudentClass').text(currentClass.name || '—');
                $('#modalStudentLocation').text(currentClass.location?.name || '—');
                $('#modalStudentInitials').text(String(modalStudent.name || '?').trim().split(/\s+/).map(part => part[0]).slice(0, 2).join('').toUpperCase());
                $('#monthlySessions').html('<div class="col-12 text-secondary small py-3">Loading monthly attendance...</div>');
                $('#modalFeeBadge').removeClass('fee-status-badge payment-paid payment-unpaid').text('Loading...');
                $('#feePaidSwitch').prop('disabled', true).prop('checked', false);
                $('#saveAttendanceButton').prop('disabled', true);
                bootstrap.Modal.getOrCreateInstance(document.getElementById('attendanceStudentModal')).show();

                $.getJSON(urls.details, {
                    student_id: modalStudent.id,
                    class_id: currentClass.id,
                    session_id: currentSession.id
                }).done(details => {
                    modalDetails = details;
                    renderMonthlySessions(details);
                    updateModalAttendanceSummary(details);

                    const paid = details.payment?.payment_status === 'Paid';
                    $('#feePaidSwitch').prop('checked', paid).prop('disabled', false);
                    setPaymentAppearance(paid);
                    $('#modalFeeBadge')
                        .removeClass('payment-paid payment-unpaid')
                        .addClass('fee-status-badge rounded-pill px-3 py-2 ' + (paid ? 'payment-paid' : 'payment-unpaid'))
                        .html(`<i class="bi ${paid ? 'bi-check-circle-fill' : 'bi-exclamation-circle-fill'}"></i>${paid ? 'Paid' : 'Unpaid'}`);
                    $('#modalFeeDate').text(paid && details.payment?.payment_date ?
                        'Paid on ' + formatDate(details.payment.payment_date) :
                        'Payment not recorded for this month');
                    $('#saveAttendanceButton').prop('disabled', !details.sessions?.some(item =>
                        String(item.session_date).slice(0, 10) === todayString &&
                        Number(item.id) === Number(details.selected_session?.id) &&
                        item.status !== 'Cancelled'
                    ));
                }).fail(xhr => {
                    const message = xhr.responseJSON?.message || 'Unable to load this student’s monthly details.';
                    $('#modalAttendanceError').removeClass('d-none').text(message);
                    $('#monthlySessions').empty();
                });
            }

            $('#attendanceClass').on('change', loadClassSessions);
            $('#attendanceSession').on('change', function() {
                updateSelectedSessionTime();
                if (currentSession) {
                    $('#summaryDate').text(formatDate(selectedDate(currentSession)));
                    $('#summaryTime').text(timeRange(currentSession.start_time, currentSession.end_time));
                }
            });
            $('#loadAttendance').on('click', loadStudents);
            $('#studentSearch').on('input', filterStudents);
            $('#attendanceStudentsBody').on('click', '.mark-attendance-btn', function() {
                openStudentModal($(this).data('student-id'));
            });

            $('#feePaidSwitch').on('change', function() {
                setPaymentAppearance($(this).is(':checked'));
            });

            $('#attendanceStudentForm').on('submit', function(event) {
                event.preventDefault();

                if (!modalStudent || !currentClass || !currentSession || !modalDetails) return;

                const selectedTodaySession = (modalDetails.sessions || []).find(item =>
                    String(item.session_date).slice(0, 10) === todayString &&
                    Number(item.id) === Number(modalDetails.selected_session?.id)
                );

                if (!selectedTodaySession || selectedTodaySession.status === 'Cancelled') {
                    $('#modalAttendanceError').removeClass('d-none')
                        .text('Only an active session scheduled for today can be marked.');
                    return;
                }

                const checked = $(`.session-attendance-check[data-session-id="${selectedTodaySession.id}"]`).is(':checked');
                const button = $('#saveAttendanceButton');
                button.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span>Saving...');

                $.ajax({
                    url: urls.save,
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    data: {
                        student_id: modalStudent.id,
                        class_id: currentClass.id,
                        session_id: selectedTodaySession.id,
                        attendance_status: checked ? 'Present' : 'Absent',
                        fee_paid: $('#feePaidSwitch').is(':checked') ? 1 : 0
                    }
                }).done(response => {
                    bootstrap.Modal.getOrCreateInstance(document.getElementById('attendanceStudentModal')).hide();
                    alertMessage(response.message || 'Attendance saved successfully.', 'success');
                    loadStudents();
                }).fail(xhr => {
                    const errors = xhr.responseJSON?.errors;
                    const message = errors ? Object.values(errors).flat().join(' ') :
                        (xhr.responseJSON?.message || 'Unable to save attendance.');
                    $('#modalAttendanceError').removeClass('d-none').text(message);
                }).always(() => {
                    button.prop('disabled', false).html('<i class="bi bi-check2-circle me-1"></i> Save Attendance');
                });
            });

            resetLoadedData();
        });
    </script>
    @endpush
</x-app-layout>