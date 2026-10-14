
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

            .stat-purple { background: #eee8ff; color: #6941c6; }
            .stat-green  { background: #dcfce7; color: #15803d; }
            .stat-orange { background: #ffedd5; color: #c2410c; }
            .stat-blue   { background: #dbeafe; color: #1d4ed8; }

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

            @media (max-width: 575.98px) {
                .session-page-title { font-size: 23px; }
                .session-toolbar { align-items: stretch !important; }
                .session-toolbar .btn { width: 100%; }
            }
        </style>
    @endpush

    <div class="container-fluid px-0">

        {{-- Page heading --}}
        <div class="d-flex flex-wrap justify-content-between
                    align-items-center gap-3 mb-4">
            <div>
                <div class="text-secondary small mb-2">
                    <i class="bi bi-house-door me-1"></i>
                    Home <i class="bi bi-chevron-right mx-1"></i>
                    Class Sessions
                </div>

                <h2 class="session-page-title fw-bold mb-1">
                    Class Sessions
                </h2>

                <p class="text-secondary mb-0">
                    View and manage generated sessions for each class.
                </p>
            </div>
        </div>

        {{-- Summary cards --}}
        <div class="row g-3 mb-4">

            <div class="col-6 col-xl-3">
                <div class="card session-card h-100">
                    <div class="card-body p-3 p-md-4">
                        <div class="d-flex justify-content-between
                                    align-items-start gap-2">
                            <div>
                                <div class="text-secondary small mb-2">
                                    Total Sessions
                                </div>
                                <h3 class="fw-bold mb-2" id="totalSessions">—</h3>
                                <span class="small text-secondary">
                                    For selected class
                                </span>
                            </div>
                            <div class="session-stat-icon stat-purple">
                                <i class="bi bi-calendar3"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-xl-3">
                <div class="card session-card h-100">
                    <div class="card-body p-3 p-md-4">
                        <div class="d-flex justify-content-between
                                    align-items-start gap-2">
                            <div>
                                <div class="text-secondary small mb-2">
                                    Completed
                                </div>
                                <h3 class="fw-bold mb-2 text-success"
                                    id="completedSessions">—</h3>
                                <span class="small text-secondary">
                                    Finished sessions
                                </span>
                            </div>
                            <div class="session-stat-icon stat-green">
                                <i class="bi bi-calendar-check"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-xl-3">
                <div class="card session-card h-100">
                    <div class="card-body p-3 p-md-4">
                        <div class="d-flex justify-content-between
                                    align-items-start gap-2">
                            <div>
                                <div class="text-secondary small mb-2">
                                    Upcoming
                                </div>
                                <h3 class="fw-bold mb-2 text-primary"
                                    id="upcomingSessions">—</h3>
                                <span class="small text-secondary">
                                    Scheduled sessions
                                </span>
                            </div>
                            <div class="session-stat-icon stat-blue">
                                <i class="bi bi-calendar-event"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-xl-3">
                <div class="card session-card h-100">
                    <div class="card-body p-3 p-md-4">
                        <div class="d-flex justify-content-between
                                    align-items-start gap-2">
                            <div>
                                <div class="text-secondary small mb-2">
                                    Cancelled
                                </div>
                                <h3 class="fw-bold mb-2 text-warning"
                                    id="cancelledSessions">—</h3>
                                <span class="small text-secondary">
                                    Cancelled sessions
                                </span>
                            </div>
                            <div class="session-stat-icon stat-orange">
                                <i class="bi bi-calendar-x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        {{-- Class selection --}}
        <div class="card session-card mb-4">
            <div class="card-body p-3 p-md-4">
                <form id="sessionFilterForm">
                    <div class="row g-3 align-items-end">

                        <div class="col-12 col-lg-8">
                            <label for="classFilter"
                                   class="form-label small fw-semibold">
                                Select Class
                            </label>

                            <select id="classFilter"
                                    class="form-select session-filter-select w-100"
                                    required>
                                <option value="">Choose a class</option>
                                <option value="1">Junior Dance</option>
                                <option value="2">Ballet</option>
                                <option value="3">Hip Hop</option>
                                <option value="4">Traditional Dance</option>
                            </select>
                        </div>

                        <div class="col-12 col-lg-4">
                            <button type="submit"
                                    class="btn session-primary-btn w-100">
                                <i class="bi bi-search me-2"></i>
                                Load Sessions
                            </button>
                        </div>

                    </div>
                </form>
            </div>
        </div>

        {{-- Sessions table --}}
        <div class="card session-card">
            <div class="card-body p-3 p-md-4">

                <div class="d-flex flex-wrap justify-content-between
                            align-items-center gap-3 mb-4 session-toolbar">
                    <div>
                        <h5 class="fw-bold mb-1">Generated Sessions</h5>
                        <p class="text-secondary small mb-0"
                           id="sessionDescription">
                            Select a class and click Load Sessions.
                        </p>
                    </div>

                    <button type="button"
                            class="btn btn-outline-secondary rounded-3"
                            id="exportSessions"
                            disabled>
                        <i class="bi bi-download me-2"></i>
                        Export CSV
                    </button>
                </div>

                <div class="session-table-wrap">
                    <table id="classSessionsTable"
                           class="table table-hover align-middle w-100">
                        <thead>
                            <tr>
                                <th>Session Date</th>
                                <th>Day</th>
                                <th>Time</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Rows are loaded when a class is selected --}}
                        </tbody>
                    </table>
                </div>

                <div id="sessionEmptyState"
                     class="text-center py-5">
                    <i class="bi bi-calendar-week fs-1 text-secondary"></i>
                    <h6 class="fw-bold mt-3 mb-1">No sessions loaded</h6>
                    <p class="text-secondary small mb-0">
                        Select a class above to view its generated sessions.
                    </p>
                </div>

            </div>
        </div>

    </div>

    @push('scripts')
        <script>
            $(function () {
                /*
                 * Dummy data only.
                 * Dates and session details are examples for the UI.
                 */
                const dummySessions = {
                    1: [
                        { date: '2026-10-03', start: '09:00', end: '10:30', status: 'Completed' },
                        { date: '2026-10-10', start: '09:00', end: '10:30', status: 'Completed' },
                        { date: '2026-10-17', start: '09:00', end: '10:30', status: 'Upcoming' },
                        { date: '2026-10-24', start: '09:00', end: '10:30', status: 'Upcoming' },
                        { date: '2026-10-31', start: '09:00', end: '10:30', status: 'Upcoming' }
                    ],
                    2: [
                        { date: '2026-10-04', start: '14:00', end: '15:30', status: 'Completed' },
                        { date: '2026-10-11', start: '14:00', end: '15:30', status: 'Completed' },
                        { date: '2026-10-18', start: '14:00', end: '15:30', status: 'Upcoming' },
                        { date: '2026-10-25', start: '14:00', end: '15:30', status: 'Upcoming' }
                    ],
                    3: [
                        { date: '2026-10-02', start: '16:00', end: '17:30', status: 'Completed' },
                        { date: '2026-10-09', start: '16:00', end: '17:30', status: 'Cancelled' },
                        { date: '2026-10-16', start: '16:00', end: '17:30', status: 'Upcoming' },
                        { date: '2026-10-23', start: '16:00', end: '17:30', status: 'Upcoming' }
                    ],
                    4: [
                        { date: '2026-10-02', start: '17:00', end: '18:30', status: 'Completed' },
                        { date: '2026-10-09', start: '17:00', end: '18:30', status: 'Cancelled' },
                        { date: '2026-10-16', start: '17:00', end: '18:30', status: 'Upcoming' }
                    ]
                };

                let sessionsTable = null;

                function formatDate(dateString) {
                    const date = new Date(dateString + 'T00:00:00');

                    return date.toLocaleDateString('en-GB', {
                        day: '2-digit',
                        month: 'short',
                        year: 'numeric'
                    });
                }

                function formatTime(timeString) {
                    const [hours, minutes] = timeString.split(':');
                    const date = new Date();

                    date.setHours(Number(hours), Number(minutes), 0, 0);

                    return date.toLocaleTimeString('en-US', {
                        hour: '2-digit',
                        minute: '2-digit',
                        hour12: true
                    });
                }

                function statusBadge(status) {
                    const styles = {
                        Completed: 'text-bg-success bg-opacity-10 text-success',
                        Upcoming: 'text-bg-primary bg-opacity-10 text-primary',
                        Cancelled: 'text-bg-warning bg-opacity-10 text-warning-emphasis'
                    };

                    const icons = {
                        Completed: 'bi-check-circle-fill',
                        Upcoming: 'bi-clock-fill',
                        Cancelled: 'bi-x-circle-fill'
                    };

                    const style = styles[status] ||
                        'text-bg-light border text-secondary';

                    const icon = icons[status] || 'bi-calendar';

                    return `<span class="badge rounded-pill ${style} px-3 py-2">
                                <i class="bi ${icon} me-1"></i>${status}
                            </span>`;
                }

                function updateSummary(sessions) {
                    $('#totalSessions').text(sessions.length);
                    $('#completedSessions').text(
                        sessions.filter(s => s.status === 'Completed').length
                    );
                    $('#upcomingSessions').text(
                        sessions.filter(s => s.status === 'Upcoming').length
                    );
                    $('#cancelledSessions').text(
                        sessions.filter(s => s.status === 'Cancelled').length
                    );
                }

                function resetSummary() {
                    $('#totalSessions, #completedSessions, #upcomingSessions, #cancelledSessions')
                        .text('—');
                }

                $('#sessionFilterForm').on('submit', function (event) {
                    event.preventDefault();

                    const classId = $('#classFilter').val();
                    const className = $('#classFilter option:selected').text();

                    if (!classId) {
                        alert('Please select a class first.');
                        return;
                    }

                    const sessions = dummySessions[classId] || [];

                    if (sessionsTable) {
                        sessionsTable.destroy();
                        sessionsTable = null;
                    }

                    $('#classSessionsTable tbody').empty();
                    $('#sessionEmptyState').addClass('d-none');

                    if (sessions.length === 0) {
                        resetSummary();
                        $('#sessionDescription').text(
                            `No generated sessions found for ${className}.`
                        );
                        $('#sessionEmptyState')
                            .removeClass('d-none')
                            .find('h6').text('No sessions found');

                        $('#sessionEmptyState p').text(
                            'There are no generated sessions for this class.'
                        );

                        $('#exportSessions').prop('disabled', true);
                        return;
                    }

                    sessions.forEach(function (session) {
                        const date = new Date(session.date + 'T00:00:00');

                        $('#classSessionsTable tbody').append(`
                            <tr>
                                <td data-order="${session.date}">
                                    <span class="fw-semibold">
                                        ${formatDate(session.date)}
                                    </span>
                                </td>
                                <td class="text-secondary">
                                    ${date.toLocaleDateString('en-US', {
                                        weekday: 'long'
                                    })}
                                </td>
                                <td class="text-nowrap">
                                    <i class="bi bi-clock me-1 text-secondary"></i>
                                    ${formatTime(session.start)} –
                                    ${formatTime(session.end)}
                                </td>
                                <td>${statusBadge(session.status)}</td>
                            </tr>
                        `);
                    });

                    sessionsTable = $('#classSessionsTable').DataTable({
                        pageLength: 5,
                        lengthMenu: [5, 10, 25],
                        order: [[0, 'asc']],
                        autoWidth: false,
                        scrollX: false,
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

                    updateSummary(sessions);

                    $('#sessionDescription').text(
                        `${className} · ${sessions.length} generated session(s)`
                    );

                    $('#exportSessions').prop('disabled', false);
                });

                $('#exportSessions').on('click', function () {
                    if (!sessionsTable) return;

                    const rows = sessionsTable
                        .rows({ search: 'applied' })
                        .data()
                        .toArray();

                    const csvRows = [
                        ['Session Date', 'Day', 'Time', 'Status'],
                        ...rows.map(row =>
                            row.slice(0, 4).map(cell =>
                                $('<div>').html(cell).text().trim()
                            )
                        )
                    ];

                    const csvContent = csvRows.map(row =>
                        row.map(value =>
                            '"' + String(value).replace(/"/g, '""') + '"'
                        ).join(',')
                    ).join('\r\n');

                    const blob = new Blob(
                        ['\uFEFF' + csvContent],
                        { type: 'text/csv;charset=utf-8;' }
                    );

                    const url = URL.createObjectURL(blob);
                    const link = document.createElement('a');

                    link.href = url;
                    link.download = 'class-sessions.csv';
                    link.click();

                    URL.revokeObjectURL(url);
                });
            });
        </script>
    @endpush
</x-app-layout>
