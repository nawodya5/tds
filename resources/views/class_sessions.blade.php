<x-app-layout>
    @section('title', 'Class Sessions | TDS Attendance')

    @push('styles')
    <style>
        .session-stat-icon {
            width: 46px;
            height: 46px;
            border-radius: 13px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            flex-shrink: 0;
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

        .session-card {
            border: 1px solid #eef0f6;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(30, 41, 59, .04);
        }

        .session-primary-btn {
            background: #6750d8;
            border-color: #6750d8;
            color: white;
            border-radius: 10px;
            padding: 10px 16px;
            font-weight: 600;
        }

        .session-primary-btn:hover {
            background: #5540c4;
            border-color: #5540c4;
            color: white;
        }

        .session-filter-select {
            min-width: 150px;
            border-radius: 9px;
            border-color: #e1e4ed;
            padding: 10px 12px;
        }

        #classSessionsTable thead th {
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

        #classSessionsTable tbody td {
            padding: 14px;
            border-color: #f0f1f6;
        }

        #classSessionsTable_wrapper .dt-search input,
        #classSessionsTable_wrapper .dt-length select {
            border: 1px solid #e1e4ed;
            border-radius: 8px;
            padding: 7px 10px;
        }

        #classSessionsTable_wrapper .dt-search input:focus {
            border-color: #8b7cf6;
            outline: 3px solid #eeeaff;
        }

        .session-table-wrap {
            overflow-x: auto;
        }

        .session-reason {
            display: inline-block;
            max-width: 220px;
            white-space: normal;
            overflow-wrap: anywhere;
        }

        @media (max-width: 575.98px) {
            .session-page-title {
                font-size: 23px;
            }

            .session-toolbar {
                align-items: stretch !important;
            }

            .session-toolbar .btn {
                width: 100%;
            }
        }
    </style>
    @endpush

    <div class="container-fluid px-0">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
            <div>
                <div class="text-secondary small mb-2">
                    <i class="bi bi-house-door me-1"></i>
                    Home <i class="bi bi-chevron-right mx-1"></i>
                    Class Sessions
                </div>

                <h2 class="session-page-title fw-bold mb-1">Class Sessions</h2>
                <p class="text-secondary mb-0">View and manage generated sessions for each class.</p>
            </div>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-6 col-xl-3">
                <div class="card session-card h-100">
                    <div class="card-body p-3 p-md-4">
                        <div class="d-flex justify-content-between align-items-start gap-2">
                            <div>
                                <div class="text-secondary small mb-2">Total Sessions</div>
                                <h3 class="fw-bold mb-2" id="totalSessions">—</h3>
                                <span class="small text-secondary">For selected class</span>
                            </div>
                            <div class="session-stat-icon stat-purple"><i class="bi bi-calendar3"></i></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-xl-3">
                <div class="card session-card h-100">
                    <div class="card-body p-3 p-md-4">
                        <div class="d-flex justify-content-between align-items-start gap-2">
                            <div>
                                <div class="text-secondary small mb-2">Completed</div>
                                <h3 class="fw-bold mb-2 text-success" id="completedSessions">—</h3>
                                <span class="small text-secondary">Finished sessions</span>
                            </div>
                            <div class="session-stat-icon stat-green"><i class="bi bi-calendar-check"></i></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-xl-3">
                <div class="card session-card h-100">
                    <div class="card-body p-3 p-md-4">
                        <div class="d-flex justify-content-between align-items-start gap-2">
                            <div>
                                <div class="text-secondary small mb-2">Upcoming</div>
                                <h3 class="fw-bold mb-2 text-primary" id="upcomingSessions">—</h3>
                                <span class="small text-secondary">Scheduled sessions</span>
                            </div>
                            <div class="session-stat-icon stat-blue"><i class="bi bi-calendar-event"></i></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-xl-3">
                <div class="card session-card h-100">
                    <div class="card-body p-3 p-md-4">
                        <div class="d-flex justify-content-between align-items-start gap-2">
                            <div>
                                <div class="text-secondary small mb-2">Cancelled</div>
                                <h3 class="fw-bold mb-2 text-warning" id="cancelledSessions">—</h3>
                                <span class="small text-secondary">Cancelled sessions</span>
                            </div>
                            <div class="session-stat-icon stat-orange"><i class="bi bi-calendar-x"></i></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card session-card mb-4">
            <div class="card-body p-3 p-md-4">
                <form id="sessionFilterForm">
                    <div class="row g-3 align-items-end">
                        <div class="col-12 col-lg-5">
                            <label for="classFilter" class="form-label small fw-semibold">Select Class</label>
                            <select id="classFilter" name="class_id" class="form-select session-filter-select w-100">
                                <option value="">All classes</option>
                                @foreach ($classes as $class)
                                <option value="{{ $class->id }}">
                                    {{ $class->name }}{{ $class->location ? ' — '.$class->location->name : '' }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-12 col-sm-6 col-lg-2">
                            <label for="dateFrom" class="form-label small fw-semibold">From date</label>
                            <input type="date" id="dateFrom" class="form-control session-filter-select">
                        </div>

                        <div class="col-12 col-sm-6 col-lg-2">
                            <label for="dateTo" class="form-label small fw-semibold">To date</label>
                            <input type="date" id="dateTo" class="form-control session-filter-select">
                        </div>

                        <div class="col-12 col-sm-6 col-lg-3">
                            <label for="statusFilter" class="form-label small fw-semibold">Status</label>
                            <select id="statusFilter" class="form-select session-filter-select w-100">
                                <option value="">All statuses</option>
                                <option value="Upcoming">Upcoming</option>
                                <option value="Completed">Completed</option>
                                <option value="Cancelled">Cancelled</option>
                            </select>
                        </div>

                        <div class="col-12 d-flex flex-wrap gap-2">
                            <button type="submit" class="btn session-primary-btn">
                                <i class="bi bi-search me-2"></i>Load Sessions
                            </button>
                            <button type="button" class="btn btn-outline-secondary rounded-3" id="resetSessionFilters">
                                <i class="bi bi-arrow-counterclockwise me-2"></i>Reset
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card session-card">
            <div class="card-body p-3 p-md-4">
                <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4 session-toolbar">
                    <div>
                        <h5 class="fw-bold mb-1">Generated Sessions</h5>
                        <p class="text-secondary small mb-0" id="sessionDescription">
                            Select filters and click Load Sessions.
                        </p>
                    </div>

                    <button type="button" class="btn btn-outline-secondary rounded-3" id="exportSessions" disabled>
                        <i class="bi bi-download me-2"></i>Export CSV
                    </button>
                </div>

                <div id="sessionAlert" class="alert d-none" role="alert"></div>

                <div class="session-table-wrap">
                    <table id="classSessionsTable" class="table table-hover align-middle w-100">
                        <thead>
                            <tr>
                                <th>Class</th>
                                <th>Location</th>
                                <th>Session Date</th>
                                <th>Time</th>
                                <th>Attendance</th>
                                <th>Status</th>
                                <th>Cancellation Reason</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>

                <div id="sessionEmptyState" class="text-center py-5">
                    <i class="bi bi-calendar-week fs-1 text-secondary"></i>
                    <h6 class="fw-bold mt-3 mb-1">No sessions loaded</h6>
                    <p class="text-secondary small mb-0">Choose your filters above to view generated sessions.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="cancelSessionModal" tabindex="-1" aria-labelledby="cancelSessionModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form id="cancelSessionForm" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="cancelSessionModalLabel">Cancel Class Session</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="text-secondary small">Please provide a reason for cancelling this session.</p>
                    <label for="cancellationReason" class="form-label fw-semibold">Cancellation reason</label>
                    <textarea id="cancellationReason" name="cancellation_reason" class="form-control" rows="3" maxlength="2000" required></textarea>
                    <div id="cancelSessionError" class="text-danger small mt-2 d-none"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Keep Session</button>
                    <button type="submit" class="btn btn-danger" id="confirmCancelSession">
                        <i class="bi bi-x-circle me-1"></i>Cancel Session
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        $(function() {
            const dataUrl = @json(route('class-sessions.data'));
            const cancelUrlTemplate = @json(route('class-sessions.cancel', ['classSession' => '__SESSION_ID__']));
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || @json(csrf_token());

            let sessionsTable = null;
            let currentSessions = [];
            let selectedSessionId = null;

            function escapeHtml(value) {
                return String(value ?? '').replace(/[&<>"']/g, function(character) {
                    return {
                        '&': '&amp;',
                        '<': '&lt;',
                        '>': '&gt;',
                        '"': '&quot;',
                        "'": '&#039;'
                    } [character];
                });
            }

            function formatDate(dateString) {
                if (!dateString) return '—';
                const date = new Date(dateString + 'T00:00:00');
                return Number.isNaN(date.getTime()) ? escapeHtml(dateString) : date.toLocaleDateString('en-GB', {
                    day: '2-digit',
                    month: 'short',
                    year: 'numeric'
                });
            }

            function formatDay(dateString) {
                if (!dateString) return '—';
                const date = new Date(dateString + 'T00:00:00');
                return Number.isNaN(date.getTime()) ? '—' : date.toLocaleDateString('en-US', {
                    weekday: 'long'
                });
            }

            function formatTime(timeString) {
                if (!timeString) return '—';
                const parts = timeString.split(':');
                const date = new Date();
                date.setHours(Number(parts[0]), Number(parts[1]), 0, 0);
                return date.toLocaleTimeString('en-US', {
                    hour: '2-digit',
                    minute: '2-digit',
                    hour12: true
                });
            }

            function statusBadge(status) {
                const settings = {
                    Completed: {
                        classes: 'bg-success-subtle text-success',
                        icon: 'bi-check-circle-fill'
                    },
                    Upcoming: {
                        classes: 'bg-primary-subtle text-primary',
                        icon: 'bi-clock-fill'
                    },
                    Cancelled: {
                        classes: 'bg-danger-subtle text-danger',
                        icon: 'bi-x-circle-fill'
                    }
                };
                const item = settings[status] || {
                    classes: 'bg-light text-secondary border',
                    icon: 'bi-calendar'
                };
                return `<span class="badge rounded-pill ${item.classes} px-3 py-2">
                                <i class="bi ${item.icon} me-1"></i>${escapeHtml(status || 'Unknown')}
                            </span>`;
            }

            function updateSummary(sessions) {
                $('#totalSessions').text(sessions.length);
                $('#completedSessions').text(sessions.filter(session => session.status === 'Completed').length);
                $('#upcomingSessions').text(sessions.filter(session => session.status === 'Upcoming').length);
                $('#cancelledSessions').text(sessions.filter(session => session.status === 'Cancelled').length);
            }

            function resetSummary() {
                $('#totalSessions, #completedSessions, #upcomingSessions, #cancelledSessions').text('—');
            }

            function showAlert(message, type = 'danger') {
                $('#sessionAlert')
                    .removeClass('d-none alert-danger alert-success alert-warning')
                    .addClass('alert-' + type)
                    .text(message);
            }

            function hideAlert() {
                $('#sessionAlert').addClass('d-none').text('');
            }

            function destroyTable() {
                if (sessionsTable) {
                    sessionsTable.destroy();
                    sessionsTable = null;
                }
                $('#classSessionsTable tbody').empty();
            }

            function getSessionDate(session) {
                return String(session.session_date || '').slice(0, 10);
            }

            function renderSessions(sessions) {
                destroyTable();
                currentSessions = sessions;
                $('#sessionEmptyState').toggleClass('d-none', sessions.length > 0);

                if (sessions.length === 0) {
                    $('#sessionEmptyState h6').text('No sessions found');
                    $('#sessionEmptyState p').text('There are no generated sessions matching the selected filters.');
                    $('#exportSessions').prop('disabled', true);
                    return;
                }

                sessions.forEach(function(session) {
                    const date = getSessionDate(session);
                    const className = session.classroom?.name || '—';
                    const locationName = session.classroom?.location?.name || '—';
                    const attendanceCount = Number(session.attendances_count || 0);
                    const reason = session.cancellation_reason || '';
                    const canCancel = session.status === 'Upcoming' && attendanceCount === 0;
                    const action = canCancel ?
                        `<button type="button" class="btn btn-sm btn-outline-danger rounded-3 cancel-session-btn"
                                       data-id="${Number(session.id)}" data-date="${escapeHtml(date)}">
                                   <i class="bi bi-x-circle me-1"></i>Cancel
                               </button>` :
                        '<span class="text-secondary small">—</span>';

                    $('#classSessionsTable tbody').append(`
                            <tr>
                                <td class="fw-semibold">${escapeHtml(className)}</td>
                                <td>${escapeHtml(locationName)}</td>
                                <td data-order="${escapeHtml(date)}">
                                    <div class="fw-semibold">${formatDate(date)}</div>
                                    <div class="small text-secondary">${escapeHtml(formatDay(date))}</div>
                                </td>
                                <td class="text-nowrap">
                                    <i class="bi bi-clock me-1 text-secondary"></i>
                                    ${formatTime(session.start_time)} – ${formatTime(session.end_time)}
                                </td>
                                <td>${attendanceCount}</td>
                                <td>${statusBadge(session.status)}</td>
                                <td><span class="session-reason text-secondary">${escapeHtml(reason || '—')}</span></td>
                                <td class="text-nowrap">${action}</td>
                            </tr>
                        `);
                });

                sessionsTable = $('#classSessionsTable').DataTable({
                    pageLength: 10,
                    lengthMenu: [5, 10, 25, 50],
                    order: [
                        [2, 'asc']
                    ],
                    autoWidth: false,
                    scrollX: true,
                    language: {
                        search: '',
                        searchPlaceholder: 'Search sessions...',
                        lengthMenu: 'Show _MENU_ sessions',
                        info: 'Showing _START_ to _END_ of _TOTAL_ sessions',
                        infoEmpty: 'No sessions found',
                        zeroRecords: 'No matching sessions found',
                        paginate: {
                            previous: '<i class="bi bi-chevron-left"></i>',
                            next: '<i class="bi bi-chevron-right"></i>'
                        }
                    }
                });

                $('#exportSessions').prop('disabled', false);
                $('#sessionEmptyState').addClass('d-none');
            }

            function loadSessions() {
                hideAlert();

                const params = new URLSearchParams();
                const classId = $('#classFilter').val();
                const dateFrom = $('#dateFrom').val();
                const dateTo = $('#dateTo').val();
                const status = $('#statusFilter').val();

                if (classId) params.set('class_id', classId);
                if (dateFrom) params.set('date_from', dateFrom);
                if (dateTo) params.set('date_to', dateTo);
                if (status) params.set('status', status);
                params.set('per_page', '100');

                if (dateFrom && dateTo && dateFrom > dateTo) {
                    showAlert('The from date must be on or before the to date.', 'warning');
                    return;
                }

                $('#sessionDescription').text('Loading sessions...');
                $('#exportSessions').prop('disabled', true);

                $.ajax({
                    url: dataUrl + '?' + params.toString(),
                    method: 'GET',
                    dataType: 'json'
                }).done(function(response) {
                    const sessions = Array.isArray(response.data) ? response.data : [];
                    renderSessions(sessions);
                    updateSummary(sessions);

                    const selectedClass = $('#classFilter option:selected').text();
                    const classLabel = classId ? selectedClass : 'All classes';
                    $('#sessionDescription').text(`${classLabel} · ${sessions.length} session(s) returned`);
                }).fail(function(xhr) {
                    destroyTable();
                    resetSummary();
                    $('#sessionDescription').text('Unable to load sessions.');
                    $('#sessionEmptyState').removeClass('d-none');
                    $('#sessionEmptyState h6').text('Could not load sessions');
                    $('#sessionEmptyState p').text('Please try again. If the problem continues, check the server response.');
                    $('#exportSessions').prop('disabled', true);

                    const message = xhr.responseJSON?.message || 'An error occurred while loading class sessions.';
                    showAlert(message);
                });
            }

            $('#sessionFilterForm').on('submit', function(event) {
                event.preventDefault();
                loadSessions();
            });

            $('#resetSessionFilters').on('click', function() {
                $('#classFilter, #statusFilter').val('');
                $('#dateFrom, #dateTo').val('');
                loadSessions();
            });

            $('#classSessionsTable').on('click', '.cancel-session-btn', function() {
                selectedSessionId = Number($(this).data('id'));
                $('#cancellationReason').val('');
                $('#cancelSessionError').addClass('d-none').text('');
                bootstrap.Modal.getOrCreateInstance(document.getElementById('cancelSessionModal')).show();
            });

            $('#cancelSessionForm').on('submit', function(event) {
                event.preventDefault();

                const reason = $('#cancellationReason').val().trim();
                if (!reason) {
                    $('#cancelSessionError').removeClass('d-none').text('Please enter a cancellation reason.');
                    return;
                }

                const button = $('#confirmCancelSession');
                button.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span>Cancelling...');

                $.ajax({
                    url: cancelUrlTemplate.replace('__SESSION_ID__', selectedSessionId),
                    method: 'PATCH',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    data: {
                        cancellation_reason: reason
                    }
                }).done(function(response) {
                    bootstrap.Modal.getOrCreateInstance(document.getElementById('cancelSessionModal')).hide();
                    showAlert(response.message || 'Class session cancelled successfully.', 'success');
                    loadSessions();
                }).fail(function(xhr) {
                    const errors = xhr.responseJSON?.errors;
                    const message = errors ?
                        Object.values(errors).flat().join(' ') :
                        (xhr.responseJSON?.message || 'Unable to cancel this session.');
                    $('#cancelSessionError').removeClass('d-none').text(message);
                }).always(function() {
                    button.prop('disabled', false).html('<i class="bi bi-x-circle me-1"></i>Cancel Session');
                });
            });

            $('#exportSessions').on('click', function() {
                if (!currentSessions.length) return;

                const rows = [
                    ['Class', 'Location', 'Session Date', 'Day', 'Start Time', 'End Time', 'Attendance', 'Status', 'Cancellation Reason'],
                    ...currentSessions.map(session => [
                        session.classroom?.name || '',
                        session.classroom?.location?.name || '',
                        getSessionDate(session),
                        formatDay(getSessionDate(session)),
                        session.start_time || '',
                        session.end_time || '',
                        Number(session.attendances_count || 0),
                        session.status || '',
                        session.cancellation_reason || ''
                    ])
                ];

                const csvContent = rows.map(row =>
                    row.map(value => '"' + String(value ?? '').replace(/"/g, '""') + '"').join(',')
                ).join('\r\n');

                const blob = new Blob(['\uFEFF' + csvContent], {
                    type: 'text/csv;charset=utf-8;'
                });
                const url = URL.createObjectURL(blob);
                const link = document.createElement('a');
                link.href = url;
                link.download = 'class-sessions.csv';
                document.body.appendChild(link);
                link.click();
                link.remove();
                URL.revokeObjectURL(url);
            });

            $('#sessionEmptyState').removeClass('d-none');
        });
    </script>
    @endpush
</x-app-layout>