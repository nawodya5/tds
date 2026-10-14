
<x-app-layout>
    @section('title', 'Calendar | TDS Attendance')

    @push('styles')
        <style>
            .calendar-card {
                border: 1px solid #eef0f6;
                border-radius: 16px;
                box-shadow: 0 4px 20px rgba(30, 41, 59, .04);
            }

            .calendar-stat-icon {
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
            .stat-blue   { background: #dbeafe; color: #1d4ed8; }
            .stat-orange { background: #ffedd5; color: #c2410c; }

            .calendar-primary-btn {
                background: #6750d8;
                border-color: #6750d8;
                color: white;
                border-radius: 10px;
                padding: 10px 16px;
                font-weight: 600;
            }

            .calendar-primary-btn:hover {
                background: #5540c4;
                border-color: #5540c4;
                color: white;
            }

            .calendar-nav-btn {
                width: 38px;
                height: 38px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                border: 1px solid #e9eaf0;
                background: #fff;
                color: #626a7e;
                border-radius: 10px;
            }

            .calendar-nav-btn:hover {
                background: #f0efff;
                color: #6941c6;
            }

            .calendar-grid {
                display: grid;
                grid-template-columns: repeat(7, minmax(0, 1fr));
            }

            .calendar-weekday {
                padding: 13px 4px;
                text-align: center;
                font-size: 11px;
                font-weight: 700;
                color: #737b90;
                text-transform: uppercase;
                letter-spacing: .5px;
                background: #f8f9fc;
                border-bottom: 1px solid #e9eaf0;
            }

            .calendar-day {
                position: relative;
                min-height: 112px;
                padding: 10px 8px;
                border-right: 1px solid #f0f1f6;
                border-bottom: 1px solid #f0f1f6;
                cursor: pointer;
                background: white;
                transition: background .15s ease;
            }

            .calendar-day:hover {
                background: #faf9ff;
            }

            .calendar-day:nth-child(7n) {
                border-right: 0;
            }

            .calendar-day.other-month {
                background: #fafbfc;
                color: #c3c7d2;
            }

            .calendar-day.selected {
                background: #f3f0ff;
                box-shadow: inset 0 0 0 2px #8b7cf6;
            }

            .calendar-day.today .calendar-day-number {
                background: #6750d8;
                color: white;
            }

            .calendar-day-number {
                width: 29px;
                height: 29px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                border-radius: 9px;
                font-size: 13px;
                font-weight: 600;
                color: #34394b;
            }

            .calendar-events {
                display: flex;
                flex-direction: column;
                gap: 4px;
                margin-top: 8px;
            }

            .calendar-event {
                width: 100%;
                overflow: hidden;
                text-overflow: ellipsis;
                white-space: nowrap;
                border: 0;
                text-align: left;
                padding: 4px 6px;
                border-radius: 5px;
                font-size: 10px;
                font-weight: 600;
                cursor: pointer;
            }

            .event-class {
                background: #eee8ff;
                color: #6941c6;
            }

            .event-workshop {
                background: #dbeafe;
                color: #1d4ed8;
            }

            .event-holiday {
                background: #ffedd5;
                color: #c2410c;
            }

            .event-more {
                color: #737b90;
                font-size: 10px;
                padding-left: 4px;
            }

            .calendar-legend-dot {
                width: 9px;
                height: 9px;
                display: inline-block;
                border-radius: 50%;
                margin-right: 6px;
            }

            .legend-class { background: #8b5cf6; }
            .legend-workshop { background: #3b82f6; }
            .legend-holiday { background: #f97316; }

            .calendar-agenda-item {
                border: 1px solid #eef0f6;
                border-radius: 12px;
                padding: 13px;
                display: flex;
                gap: 12px;
                align-items: flex-start;
            }

            .agenda-date {
                min-width: 48px;
                text-align: center;
                border-radius: 10px;
                padding: 8px 4px;
                background: #f0efff;
                color: #6941c6;
            }

            .agenda-date strong {
                display: block;
                font-size: 19px;
                line-height: 1.2;
            }

            .agenda-date small {
                font-size: 10px;
                font-weight: 700;
                text-transform: uppercase;
            }

            @media (max-width: 767.98px) {
                .calendar-page-title { font-size: 23px; }

                .calendar-day {
                    min-height: 76px;
                    padding: 5px 3px;
                }

                .calendar-day-number {
                    width: 25px;
                    height: 25px;
                    font-size: 11px;
                }

                .calendar-events {
                    gap: 3px;
                    margin-top: 4px;
                }

                .calendar-event {
                    height: 6px;
                    padding: 0;
                    font-size: 0;
                    border-radius: 5px;
                }

                .event-more { display: none; }

                .calendar-weekday {
                    padding: 10px 1px;
                    font-size: 9px;
                    letter-spacing: 0;
                }
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
                    Calendar
                </div>

                <h2 class="calendar-page-title fw-bold mb-1">
                    Calendar
                </h2>

                <p class="text-secondary mb-0">
                    View your dance classes, workshops, and important events.
                </p>
            </div>

            <button type="button"
                    class="btn calendar-primary-btn"
                    id="todayButton">
                <i class="bi bi-calendar-check me-2"></i>
                Today
            </button>
        </div>

        {{-- Summary cards --}}
        <div class="row g-3 mb-4">

            <div class="col-6 col-xl-3">
                <div class="card calendar-card h-100">
                    <div class="card-body p-3 p-md-4">
                        <div class="d-flex justify-content-between
                                    align-items-start gap-2">
                            <div>
                                <div class="text-secondary small mb-2">
                                    Class Sessions
                                </div>
                                <h3 class="fw-bold mb-2" id="classCount">0</h3>
                                <span class="small text-secondary">
                                    This month
                                </span>
                            </div>
                            <div class="calendar-stat-icon stat-purple">
                                <i class="bi bi-calendar3"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-xl-3">
                <div class="card calendar-card h-100">
                    <div class="card-body p-3 p-md-4">
                        <div class="d-flex justify-content-between
                                    align-items-start gap-2">
                            <div>
                                <div class="text-secondary small mb-2">
                                    Workshops
                                </div>
                                <h3 class="fw-bold mb-2 text-primary"
                                    id="workshopCount">0</h3>
                                <span class="small text-secondary">
                                    This month
                                </span>
                            </div>
                            <div class="calendar-stat-icon stat-blue">
                                <i class="bi bi-music-note-list"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-xl-3">
                <div class="card calendar-card h-100">
                    <div class="card-body p-3 p-md-4">
                        <div class="d-flex justify-content-between
                                    align-items-start gap-2">
                            <div>
                                <div class="text-secondary small mb-2">
                                    Special Events
                                </div>
                                <h3 class="fw-bold mb-2 text-success"
                                    id="eventCount">0</h3>
                                <span class="small text-secondary">
                                    This month
                                </span>
                            </div>
                            <div class="calendar-stat-icon stat-green">
                                <i class="bi bi-stars"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-xl-3">
                <div class="card calendar-card h-100">
                    <div class="card-body p-3 p-md-4">
                        <div class="d-flex justify-content-between
                                    align-items-start gap-2">
                            <div>
                                <div class="text-secondary small mb-2">
                                    Holidays
                                </div>
                                <h3 class="fw-bold mb-2 text-warning"
                                    id="holidayCount">0</h3>
                                <span class="small text-secondary">
                                    This month
                                </span>
                            </div>
                            <div class="calendar-stat-icon stat-orange">
                                <i class="bi bi-sun"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="row g-4">

            {{-- Monthly calendar --}}
            <div class="col-12 col-xxl-9">
                <div class="card calendar-card h-100">
                    <div class="card-body p-3 p-md-4">

                        <div class="d-flex flex-wrap
                                    justify-content-between
                                    align-items-center gap-3 mb-4">
                            <div>
                                <h5 class="fw-bold mb-1" id="monthTitle">
                                    October 2026
                                </h5>
                                <p class="text-secondary small mb-0">
                                    Select a date to view its events.
                                </p>
                            </div>

                            <div class="d-flex align-items-center gap-2">
                                <button type="button"
                                        class="calendar-nav-btn"
                                        id="previousMonth"
                                        aria-label="Previous month">
                                    <i class="bi bi-chevron-left"></i>
                                </button>

                                <button type="button"
                                        class="btn btn-outline-secondary rounded-3"
                                        id="currentMonthButton">
                                    This month
                                </button>

                                <button type="button"
                                        class="calendar-nav-btn"
                                        id="nextMonth"
                                        aria-label="Next month">
                                    <i class="bi bi-chevron-right"></i>
                                </button>
                            </div>
                        </div>

                        <div class="d-flex flex-wrap gap-3 mb-3 small">
                            <span>
                                <span class="calendar-legend-dot legend-class"></span>
                                Class
                            </span>
                            <span>
                                <span class="calendar-legend-dot legend-workshop"></span>
                                Workshop
                            </span>
                            <span>
                                <span class="calendar-legend-dot legend-holiday"></span>
                                Holiday
                            </span>
                        </div>

                        <div class="calendar-grid" id="calendarWeekdays">
                            <div class="calendar-weekday">Sun</div>
                            <div class="calendar-weekday">Mon</div>
                            <div class="calendar-weekday">Tue</div>
                            <div class="calendar-weekday">Wed</div>
                            <div class="calendar-weekday">Thu</div>
                            <div class="calendar-weekday">Fri</div>
                            <div class="calendar-weekday">Sat</div>
                        </div>

                        <div class="calendar-grid" id="calendarDays"></div>

                    </div>
                </div>
            </div>

            {{-- Selected date agenda --}}
            <div class="col-12 col-xxl-3">
                <div class="card calendar-card h-100">
                    <div class="card-body p-3 p-md-4">

                        <div class="mb-4">
                            <h5 class="fw-bold mb-1">Selected Date</h5>
                            <p class="text-secondary small mb-0"
                               id="selectedDateLabel">
                                Select a date
                            </p>
                        </div>

                        <div id="selectedDateEvents">
                            <div class="text-center py-5">
                                <i class="bi bi-calendar2-event fs-1
                                          text-secondary"></i>
                                <p class="text-secondary small mt-3 mb-0">
                                    Select a date on the calendar to view
                                    its schedule.
                                </p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- Event details modal --}}
    <div class="modal fade" id="calendarEventModal" tabindex="-1"
         aria-labelledby="calendarEventModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 rounded-4 shadow">
                <div class="modal-header border-0 px-4 pt-4">
                    <div>
                        <h5 class="modal-title fw-bold"
                            id="calendarEventModalLabel">Event Details</h5>
                        <p class="small text-secondary mb-0">
                            Calendar event information
                        </p>
                    </div>
                    <button type="button" class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close"></button>
                </div>

                <div class="modal-body px-4 pb-4" id="calendarEventDetails">
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(function () {
                /*
                 * Dummy calendar data for UI demonstration only.
                 * Dates use YYYY-MM-DD.
                 */
                const calendarEvents = [
                    {
                        date: '2026-10-03',
                        title: 'Junior Dance',
                        type: 'class',
                        time: '09:00 AM – 10:30 AM',
                        location: 'Main Studio',
                        description: 'Regular junior dance class.'
                    },
                    {
                        date: '2026-10-04',
                        title: 'Ballet Class',
                        type: 'class',
                        time: '02:00 PM – 03:30 PM',
                        location: 'Main Studio',
                        description: 'Regular ballet class.'
                    },
                    {
                        date: '2026-10-09',
                        title: 'Dance Workshop',
                        type: 'workshop',
                        time: '03:00 PM – 05:00 PM',
                        location: 'Main Studio',
                        description: 'Special dance technique workshop.'
                    },
                    {
                        date: '2026-10-10',
                        title: 'Junior Dance',
                        type: 'class',
                        time: '09:00 AM – 10:30 AM',
                        location: 'Main Studio',
                        description: 'Regular junior dance class.'
                    },
                    {
                        date: '2026-10-12',
                        title: 'Special Event',
                        type: 'event',
                        time: '10:00 AM – 12:00 PM',
                        location: 'Main Studio',
                        description: 'A special event for students.'
                    },
                    {
                        date: '2026-10-16',
                        title: 'Dance Workshop',
                        type: 'workshop',
                        time: '04:00 PM – 05:30 PM',
                        location: 'Main Studio',
                        description: 'Dance practice and choreography.'
                    },
                    {
                        date: '2026-10-17',
                        title: 'Junior Dance',
                        type: 'class',
                        time: '09:00 AM – 10:30 AM',
                        location: 'Main Studio',
                        description: 'Regular junior dance class.'
                    },
                    {
                        date: '2026-10-18',
                        title: 'Ballet Class',
                        type: 'class',
                        time: '02:00 PM – 03:30 PM',
                        location: 'Main Studio',
                        description: 'Regular ballet class.'
                    },
                    {
                        date: '2026-10-23',
                        title: 'Studio Holiday',
                        type: 'holiday',
                        time: 'All day',
                        location: 'All locations',
                        description: 'Classes are not scheduled for this day.'
                    },
                    {
                        date: '2026-10-24',
                        title: 'Junior Dance',
                        type: 'class',
                        time: '09:00 AM – 10:30 AM',
                        location: 'Main Studio',
                        description: 'Regular junior dance class.'
                    },
                    {
                        date: '2026-10-25',
                        title: 'Ballet Class',
                        type: 'class',
                        time: '02:00 PM – 03:30 PM',
                        location: 'Main Studio',
                        description: 'Regular ballet class.'
                    },
                    {
                        date: '2026-10-31',
                        title: 'Dance Showcase',
                        type: 'event',
                        time: '04:00 PM – 06:00 PM',
                        location: 'Main Studio',
                        description: 'Student dance showcase.'
                    }
                ];

                const typeLabels = {
                    class: 'Class',
                    workshop: 'Workshop',
                    event: 'Special Event',
                    holiday: 'Holiday'
                };

                const typeClasses = {
                    class: 'event-class',
                    workshop: 'event-workshop',
                    event: 'event-workshop',
                    holiday: 'event-holiday'
                };

                const today = new Date();
                let displayedYear = today.getFullYear();
                let displayedMonth = today.getMonth();
                let selectedDate = formatDateKey(today);

                function formatDateKey(date) {
                    const year = date.getFullYear();
                    const month = String(date.getMonth() + 1).padStart(2, '0');
                    const day = String(date.getDate()).padStart(2, '0');

                    return `${year}-${month}-${day}`;
                }

                function formatLongDate(dateKey) {
                    const date = new Date(dateKey + 'T00:00:00');

                    return date.toLocaleDateString('en-GB', {
                        weekday: 'long',
                        day: 'numeric',
                        month: 'long',
                        year: 'numeric'
                    });
                }

                function getEventsForDate(dateKey) {
                    return calendarEvents.filter(event => event.date === dateKey);
                }

                function updateSummary() {
                    const prefix =
                        `${displayedYear}-${String(displayedMonth + 1).padStart(2, '0')}`;

                    const events = calendarEvents.filter(event =>
                        event.date.startsWith(prefix)
                    );

                    $('#classCount').text(
                        events.filter(event => event.type === 'class').length
                    );

                    $('#workshopCount').text(
                        events.filter(event => event.type === 'workshop').length
                    );

                    $('#eventCount').text(
                        events.filter(event => event.type === 'event').length
                    );

                    $('#holidayCount').text(
                        events.filter(event => event.type === 'holiday').length
                    );
                }

                function renderCalendar() {
                    const firstDay = new Date(
                        displayedYear, displayedMonth, 1
                    );

                    const lastDay = new Date(
                        displayedYear, displayedMonth + 1, 0
                    );

                    const startOffset = firstDay.getDay();
                    const daysInMonth = lastDay.getDate();

                    $('#monthTitle').text(
                        firstDay.toLocaleDateString('en-US', {
                            month: 'long',
                            year: 'numeric'
                        })
                    );

                    const totalCells = Math.ceil(
                        (startOffset + daysInMonth) / 7
                    ) * 7;

                    let html = '';

                    for (let cell = 0; cell < totalCells; cell++) {
                        const dayNumber = cell - startOffset + 1;

                        const date = new Date(
                            displayedYear,
                            displayedMonth,
                            dayNumber
                        );

                        const dateKey = formatDateKey(date);
                        const inCurrentMonth =
                            date.getMonth() === displayedMonth;

                        const events = getEventsForDate(dateKey);

                        const classes = ['calendar-day'];

                        if (!inCurrentMonth) classes.push('other-month');
                        if (dateKey === formatDateKey(today)) classes.push('today');
                        if (dateKey === selectedDate) classes.push('selected');

                        html += `
                            <div class="${classes.join(' ')}"
                                 data-date="${dateKey}"
                                 role="button"
                                 tabindex="0"
                                 aria-label="${formatLongDate(dateKey)}">
                                <span class="calendar-day-number">
                                    ${date.getDate()}
                                </span>

                                <div class="calendar-events">
                                    ${events.slice(0, 3).map(event => `
                                        <button type="button"
                                                class="calendar-event ${typeClasses[event.type]}"
                                                data-event-date="${event.date}"
                                                data-event-title="${event.title.replace(/"/g, '&quot;')}"
                                                title="${event.title}">
                                            ${event.title}
                                        </button>
                                    `).join('')}

                                    ${events.length > 3 ? `
                                        <span class="event-more">
                                            +${events.length - 3} more
                                        </span>
                                    ` : ''}
                                </div>
                            </div>
                        `;
                    }

                    $('#calendarDays').html(html);

                    updateSummary();
                    renderSelectedDate();
                }

                function renderSelectedDate() {
                    $('#selectedDateLabel').text(
                        formatLongDate(selectedDate)
                    );

                    const events = getEventsForDate(selectedDate);

                    if (!events.length) {
                        $('#selectedDateEvents').html(`
                            <div class="text-center py-5">
                                <i class="bi bi-calendar2-x fs-1 text-secondary"></i>
                                <h6 class="fw-bold mt-3 mb-1">
                                    No events scheduled
                                </h6>
                                <p class="text-secondary small mb-0">
                                    Nothing is scheduled for this date.
                                </p>
                            </div>
                        `);

                        return;
                    }

                    const html = events.map(event => {
                        const date = new Date(event.date + 'T00:00:00');

                        return `
                            <div class="calendar-agenda-item mb-3">
                                <div class="agenda-date">
                                    <strong>${date.getDate()}</strong>
                                    <small>${date.toLocaleDateString('en-US', {
                                        month: 'short'
                                    })}</small>
                                </div>

                                <div class="flex-grow-1 min-w-0">
                                    <div class="fw-semibold mb-1">
                                        ${event.title}
                                    </div>

                                    <div class="small text-secondary mb-1">
                                        <i class="bi bi-clock me-1"></i>
                                        ${event.time}
                                    </div>

                                    <div class="small text-secondary mb-2">
                                        <i class="bi bi-geo-alt me-1"></i>
                                        ${event.location}
                                    </div>

                                    <span class="badge rounded-pill
                                        ${typeClasses[event.type]}
                                        px-3 py-2">
                                        ${typeLabels[event.type] || 'Event'}
                                    </span>

                                    <button type="button"
                                            class="btn btn-sm btn-link p-0 ms-2"
                                            data-open-event="${event.date}"
                                            data-open-title="${event.title.replace(/"/g, '&quot;')}">
                                        Details
                                    </button>
                                </div>
                            </div>
                        `;
                    }).join('');

                    $('#selectedDateEvents').html(html);
                }

                function openEventDetails(dateKey, title) {
                    const event = calendarEvents.find(item =>
                        item.date === dateKey && item.title === title
                    );

                    if (!event) return;

                    $('#calendarEventModalLabel').text(event.title);

                    $('#calendarEventDetails').html(`
                        <div class="mb-3">
                            <span class="badge rounded-pill
                                ${typeClasses[event.type]} px-3 py-2">
                                ${typeLabels[event.type] || 'Event'}
                            </span>
                        </div>

                        <div class="list-group list-group-flush">
                            <div class="list-group-item d-flex
                                        justify-content-between gap-3 px-0">
                                <span class="text-secondary">Date</span>
                                <strong class="text-end">
                                    ${formatLongDate(event.date)}
                                </strong>
                            </div>

                            <div class="list-group-item d-flex
                                        justify-content-between gap-3 px-0">
                                <span class="text-secondary">Time</span>
                                <strong class="text-end">${event.time}</strong>
                            </div>

                            <div class="list-group-item d-flex
                                        justify-content-between gap-3 px-0">
                                <span class="text-secondary">Location</span>
                                <strong class="text-end">${event.location}</strong>
                            </div>

                            <div class="list-group-item px-0">
                                <div class="text-secondary small mb-1">
                                    Description
                                </div>
                                <div>${event.description}</div>
                            </div>
                        </div>
                    `);

                    bootstrap.Modal.getOrCreateInstance(
                        document.getElementById('calendarEventModal')
                    ).show();
                }

                $('#previousMonth').on('click', function () {
                    displayedMonth--;

                    if (displayedMonth < 0) {
                        displayedMonth = 11;
                        displayedYear--;
                    }

                    selectedDate = formatDateKey(
                        new Date(displayedYear, displayedMonth, 1)
                    );

                    renderCalendar();
                });

                $('#nextMonth').on('click', function () {
                    displayedMonth++;

                    if (displayedMonth > 11) {
                        displayedMonth = 0;
                        displayedYear++;
                    }

                    selectedDate = formatDateKey(
                        new Date(displayedYear, displayedMonth, 1)
                    );

                    renderCalendar();
                });

                function goToToday() {
                    displayedYear = today.getFullYear();
                    displayedMonth = today.getMonth();
                    selectedDate = formatDateKey(today);
                    renderCalendar();
                }

                $('#todayButton, #currentMonthButton').on('click', goToToday);

                $('#calendarDays').on('click', '.calendar-day', function (event) {
                    if ($(event.target).closest('.calendar-event').length) {
                        return;
                    }

                    selectedDate = $(this).data('date');

                    const date = new Date(selectedDate + 'T00:00:00');
                    displayedYear = date.getFullYear();
                    displayedMonth = date.getMonth();

                    renderCalendar();
                });

                $('#calendarDays').on('keydown', '.calendar-day', function (event) {
                    if (event.key === 'Enter' || event.key === ' ') {
                        event.preventDefault();
                        $(this).trigger('click');
                    }
                });

                $('#calendarDays').on('click', '.calendar-event', function (event) {
                    event.stopPropagation();

                    openEventDetails(
                        $(this).data('event-date'),
                        $(this).data('event-title')
                    );
                });

                $('#selectedDateEvents').on('click', '[data-open-event]', function () {
                    openEventDetails(
                        $(this).data('open-event'),
                        $(this).data('open-title')
                    );
                });

                renderCalendar();
            });
        </script>
    @endpush
</x-app-layout>
