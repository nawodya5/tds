<x-app-layout>
    @section('title', 'Calendar | TDS Attendance')

    @push('styles')
    <style>
        .calendar-card {
            border: 1px solid #eef0f6;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(30, 41, 59, .04);
            height: 100%;
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

        .stat-purple {
            background: #eee8ff;
            color: #6941c6;
        }

        .stat-green {
            background: #dcfce7;
            color: #15803d;
        }

        .stat-blue {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .stat-orange {
            background: #ffedd5;
            color: #c2410c;
        }

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

        .event-special {
            background: #dcfce7;
            color: #15803d;
        }

        .event-more {
            color: #737b90;
            font-size: 10px;
            padding-left: 4px;
        }

        .calendar-event-dot {
            display: inline-block;
            width: 8px;
            height: 8px;
            min-width: 8px;
            padding: 0;
            border: 0;
            border-radius: 50%;
            vertical-align: middle;
            cursor: pointer;
        }

        .event-class.calendar-event-dot {
            background: #8b5cf6;
        }

        .event-workshop.calendar-event-dot {
            background: #3b82f6;
        }

        .event-special.calendar-event-dot {
            background: #16a34a;
        }

        .event-holiday.calendar-event-dot {
            background: #f97316;
        }

        .calendar-event-dot.event-cancelled {
            background: #9ca3af;
        }

        .calendar-day .calendar-events {
            flex-direction: row;
            flex-wrap: wrap;
            gap: 5px;
        }

        .calendar-event-dot:focus-visible {
            outline: 2px solid #6750d8;
            outline-offset: 2px;
        }

        .calendar-latest-item {
            border: 1px solid #eef0f6;
            border-radius: 12px;
            padding: 12px;
        }


        .calendar-legend-dot {
            width: 9px;
            height: 9px;
            display: inline-block;
            border-radius: 50%;
            margin-right: 6px;
        }

        .legend-class {
            background: #8b5cf6;
        }

        .legend-workshop {
            background: #3b82f6;
        }

        .legend-holiday {
            background: #f97316;
        }

        .legend-event {
            background: #16a34a;
        }

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
            .calendar-page-title {
                font-size: 23px;
            }

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

            .event-more {
                display: none;
            }

            .calendar-weekday {
                padding: 10px 1px;
                font-size: 9px;
                letter-spacing: 0;
            }


        }



        /* Right-side calendar panels */
        .calendar-sidebar {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            min-width: 0;
        }

        .calendar-sidebar .calendar-card {
            min-width: 0;
            overflow: hidden;
        }

        .calendar-sidebar .card-body {
            padding: 1rem !important;
        }

        /* Scroll the agenda inside its own card */
        .selected-date-card {
            min-height: 250px;
        }

        .selected-date-events {
            max-height: 360px;
            overflow-y: auto;
            overflow-x: hidden;
            padding-right: 4px;
        }

        /* Allow event names and descriptions to wrap */
        #latestCalendarEvent,
        #selectedDateEvents {
            overflow-wrap: anywhere;
            word-break: normal;
        }

        #latestCalendarEvent .small,
        #selectedDateEvents .small {
            line-height: 1.5;
        }

        /* On smaller screens, use the full available width */
        @media (max-width: 1199.98px) {
            .calendar-sidebar {
                display: grid;
                grid-template-columns: repeat(2, minmax(0, 1fr));
                align-items: start;
            }

            .selected-date-events {
                max-height: 320px;
            }
        }

        @media (max-width: 575.98px) {
            .calendar-sidebar {
                grid-template-columns: minmax(0, 1fr);
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

            <div class="d-flex flex-wrap gap-2">
                <button type="button" class="btn calendar-primary-btn" id="addCalendarEventButton">
                    <i class="bi bi-plus-lg me-2"></i>Add Event
                </button>
                <button type="button" class="btn calendar-primary-btn" id="todayButton">
                    <i class="bi bi-calendar-check me-2"></i>Today
                </button>
            </div>
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


        {{-- Calendar and right sidebar --}}
        <div class="row g-3 align-items-stretch">

            {{-- Monthly calendar --}}
            <div class="col-12 col-xl-9">
                <div class="card calendar-card h-100">
                    <div class="card-body p-3 p-md-4">

                        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
                            <div>
                                <h5 class="fw-bold mb-1" id="monthTitle">October 2026</h5>
                                <p class="text-secondary small mb-0">
                                    Select a date to view its events.
                                </p>
                            </div>

                            <div class="d-flex align-items-center gap-2">
                                <button type="button" class="calendar-nav-btn"
                                    id="previousMonth" aria-label="Previous month">
                                    <i class="bi bi-chevron-left"></i>
                                </button>

                                <button type="button"
                                    class="btn btn-outline-secondary rounded-3 btn-sm"
                                    id="currentMonthButton">
                                    This month
                                </button>

                                <button type="button" class="calendar-nav-btn"
                                    id="nextMonth" aria-label="Next month">
                                    <i class="bi bi-chevron-right"></i>
                                </button>
                            </div>
                        </div>

                        {{-- Calendar legend --}}
                        <div class="d-flex flex-wrap gap-3 mb-3 small">
                            <span><span class="calendar-legend-dot legend-class"></span> Class</span>
                            <span><span class="calendar-legend-dot legend-workshop"></span> Workshop</span>
                            <span><span class="calendar-legend-dot legend-event"></span> Special Event</span>
                            <span><span class="calendar-legend-dot legend-holiday"></span> Holiday</span>
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

            {{-- Right sidebar --}}
            <div class="col-12 col-xl-3">
                <div class="calendar-sidebar">

                    {{-- Latest event --}}
                    <div class="card calendar-card">
                        <div class="card-body p-3">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <h6 class="fw-bold mb-0">Latest Event</h6>
                                <i class="bi bi-clock-history text-secondary"></i>
                            </div>

                            <div id="latestCalendarEvent">
                                <p class="text-secondary small mb-0">
                                    Loading latest event...
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Selected date agenda --}}
                    <div class="card calendar-card selected-date-card">
                        <div class="card-body p-3">
                            <div class="mb-3">
                                <h6 class="fw-bold mb-1">Selected Date</h6>
                                <p class="text-secondary small mb-0" id="selectedDateLabel">
                                    Select a date
                                </p>
                            </div>

                            <div id="selectedDateEvents" class="selected-date-events">
                                <div class="text-center py-4">
                                    <i class="bi bi-calendar2-event fs-2 text-secondary"></i>
                                    <p class="text-secondary small mt-2 mb-0">
                                        Select a date to view its schedule.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>

    </div>

    {{-- Create calendar event modal --}}
    <div class="modal fade" id="createCalendarEventModal" tabindex="-1" aria-labelledby="createCalendarEventModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form class="modal-content border-0 rounded-4 shadow" id="createCalendarEventForm">
                @csrf
                <div class="modal-header border-0 px-4 pt-4">
                    <div>
                        <h5 class="modal-title fw-bold" id="createCalendarEventModalLabel">Add Calendar Event</h5>
                        <p class="small text-secondary mb-0">Add a workshop, event, or holiday to your calendar.</p>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body px-4">
                    <div id="calendarEventFormError" class="alert alert-danger d-none" role="alert"></div>
                    <div class="mb-3"><label for="calendarEventTitle" class="form-label fw-semibold">Title</label><input type="text" class="form-control" id="calendarEventTitle" name="title" maxlength="255" required></div>
                    <div class="mb-3"><label for="calendarEventType" class="form-label fw-semibold">Event type</label><select class="form-select" id="calendarEventType" name="event_type" required>
                            <option value="Event">Special Event</option>
                            <option value="Workshop">Workshop</option>
                            <option value="Holiday">Holiday</option>
                        </select></div>
                    <div class="mb-3"><label for="calendarEventDate" class="form-label fw-semibold">Date</label><input type="date" class="form-control" id="calendarEventDate" name="event_date" required></div>
                    <div class="row g-3" id="calendarEventTimeFields">
                        <div class="col-6"><label for="calendarEventStartTime" class="form-label fw-semibold">From time</label><input type="time" class="form-control" id="calendarEventStartTime" name="start_time" required></div>
                        <div class="col-6"><label for="calendarEventEndTime" class="form-label fw-semibold">To time</label><input type="time" class="form-control" id="calendarEventEndTime" name="end_time" required></div>
                    </div>
                    <div class="mt-3"><label for="calendarEventDescription" class="form-label fw-semibold">Description <span class="text-secondary fw-normal">(optional)</span></label><textarea class="form-control" id="calendarEventDescription" name="description" rows="3"></textarea></div>
                </div>
                <div class="modal-footer border-0 px-4 pb-4"><button type="button" class="btn btn-light" data-bs-dismiss="modal">Exit</button><button type="submit" class="btn calendar-primary-btn" id="saveCalendarEventButton"><i class="bi bi-check-lg me-1"></i>Save Event</button></div>
            </form>
        </div>
    </div>

    {{-- Class session conflict confirmation modal --}}
    <div class="modal fade" id="calendarConflictModal" tabindex="-1" aria-labelledby="calendarConflictModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 rounded-4 shadow">
                <div class="modal-header border-0 px-4 pt-4">
                    <div>
                        <h5 class="modal-title fw-bold" id="calendarConflictModalLabel">Class Session Conflict</h5>
                        <p class="small text-secondary mb-0" id="calendarConflictMessage">The event overlaps with scheduled class sessions.</p>
                    </div><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body px-4">
                    <div id="calendarConflictList" class="list-group mb-3"></div>
                    <div class="alert alert-warning small mb-0" id="calendarConflictNote">Sessions with attendance records cannot be cancelled.</div>
                </div>
                <div class="modal-footer border-0 px-4 pb-4 flex-wrap"><button type="button" class="btn btn-light me-auto" id="exitCalendarConflictButton">Exit</button><button type="button" class="btn btn-outline-secondary" id="addEventWithoutCancelButton">Add event without cancelling</button><button type="button" class="btn calendar-primary-btn" id="cancelSessionsAndSaveButton">Cancel sessions and save</button></div>
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
        $(function() {
            const calendarDataUrl = @json(route('calendar.data'));
            const calendarStoreUrl = @json(route('calendar.store'));
            const csrfToken = $('meta[name="csrf-token"]').attr('content');
            const today = new Date();
            let displayedYear = today.getFullYear();
            let displayedMonth = today.getMonth();
            let selectedDate = formatDateKey(today);
            let calendarEvents = [];
            let pendingEventPayload = null;
            let pendingConflictIsHoliday = false;

            const typeLabels = {
                class: 'Class',
                workshop: 'Workshop',
                event: 'Special Event',
                holiday: 'Holiday'
            };
            const typeClasses = {
                class: 'event-class',
                workshop: 'event-workshop',
                event: 'event-special',
                holiday: 'event-holiday'
            };

            function formatDateKey(date) {
                return `${date.getFullYear()}-${String(date.getMonth() + 1).padStart(2, '0')}-${String(date.getDate()).padStart(2, '0')}`;
            }

            function formatLongDate(dateKey) {
                return new Date(dateKey + 'T00:00:00').toLocaleDateString('en-GB', {
                    weekday: 'long',
                    day: 'numeric',
                    month: 'long',
                    year: 'numeric'
                });
            }

            function formatTime(value) {
                if (!value) return 'All day';
                const [hours, minutes] = value.slice(0, 5).split(':').map(Number);
                const date = new Date();
                date.setHours(hours, minutes, 0, 0);
                return date.toLocaleTimeString('en-US', {
                    hour: 'numeric',
                    minute: '2-digit'
                });
            }

            function formatTimeRange(item) {
                return item.start_time && item.end_time ? `${formatTime(item.start_time)} – ${formatTime(item.end_time)}` : 'All day';
            }

            function escapeHtml(value) {
                return String(value ?? '').replace(/[&<>"']/g, char => ({
                    '&': '&amp;',
                    '<': '&lt;',
                    '>': '&gt;',
                    '"': '&quot;',
                    "'": '&#039;'
                } [char]));
            }

            function getEventsForDate(dateKey) {
                return calendarEvents.filter(item => item.date === dateKey);
            }

            function getEventByDateAndTitle(dateKey, title) {
                return calendarEvents.find(item => item.date === dateKey && item.title === title);
            }

            function updateSummary() {
                const prefix = `${displayedYear}-${String(displayedMonth + 1).padStart(2, '0')}`;
                const items = calendarEvents.filter(item => item.date.startsWith(prefix));
                $('#classCount').text(items.filter(item => item.type === 'class' && item.status !== 'Cancelled').length);
                $('#workshopCount').text(items.filter(item => item.type === 'workshop').length);
                $('#eventCount').text(items.filter(item => item.type === 'event').length);
                $('#holidayCount').text(items.filter(item => item.type === 'holiday').length);
            }

            function renderCalendar() {
                const firstDay = new Date(displayedYear, displayedMonth, 1);
                const lastDay = new Date(displayedYear, displayedMonth + 1, 0);
                const startOffset = firstDay.getDay();
                const totalCells = Math.ceil((startOffset + lastDay.getDate()) / 7) * 7;
                $('#monthTitle').text(firstDay.toLocaleDateString('en-US', {
                    month: 'long',
                    year: 'numeric'
                }));
                let html = '';
                for (let cell = 0; cell < totalCells; cell++) {
                    const date = new Date(displayedYear, displayedMonth, cell - startOffset + 1);
                    const dateKey = formatDateKey(date);
                    const classes = ['calendar-day'];
                    if (date.getMonth() !== displayedMonth) classes.push('other-month');
                    if (dateKey === formatDateKey(today)) classes.push('today');
                    if (dateKey === selectedDate) classes.push('selected');
                    const items = getEventsForDate(dateKey);
                    html += `<div class="${classes.join(' ')}" data-date="${dateKey}" role="button" tabindex="0" aria-label="${formatLongDate(dateKey)}"><span class="calendar-day-number">${date.getDate()}</span><div class="calendar-events">${items.slice(0, 10).map(item => {
                            const dotClass = typeClasses[item.type] || 'event-workshop';
                            const cancelled = item.status === 'Cancelled' ? ' event-cancelled' : '';
                            const safeTitle = escapeHtml(item.title);
                            return `<button type="button" class="calendar-event calendar-event-dot ${dotClass}${cancelled}" data-event-date="${item.date}" data-event-title="${safeTitle}" title="${safeTitle} · ${formatTimeRange(item)}" aria-label="${safeTitle}"></button>`;
                        }).join('')}</div></div>`;
                }
                $('#calendarDays').html(html);
                updateSummary();
                renderSelectedDate();
                renderLatestEvent();
            }

            function renderSelectedDate() {
                $('#selectedDateLabel').text(formatLongDate(selectedDate));
                const items = getEventsForDate(selectedDate).sort((a, b) => (a.start_time || '').localeCompare(b.start_time || ''));
                if (!items.length) {
                    $('#selectedDateEvents').html('<div class="text-center py-4"><i class="bi bi-calendar2-x fs-1 text-secondary"></i><p class="text-secondary small mt-3 mb-0">Nothing is scheduled for this date.</p></div>');
                    return;
                }
                $('#selectedDateEvents').html(items.map(item => `<div class="calendar-agenda-item mb-3"><div class="agenda-date"><strong>${new Date(item.date + 'T00:00:00').getDate()}</strong><small>${new Date(item.date + 'T00:00:00').toLocaleDateString('en-US', { month: 'short' })}</small></div><div class="flex-grow-1 min-w-0"><div class="fw-semibold mb-1">${escapeHtml(item.title)}</div><div class="small text-secondary mb-1"><i class="bi bi-clock me-1"></i>${formatTimeRange(item)}</div>${item.location ? `<div class="small text-secondary mb-2"><i class="bi bi-geo-alt me-1"></i>${escapeHtml(item.location)}</div>` : ''}<span class="badge rounded-pill ${typeClasses[item.type] || 'event-workshop'} px-3 py-2">${typeLabels[item.type] || 'Event'}${item.status === 'Cancelled' ? ' · Cancelled' : ''}</span><button type="button" class="btn btn-sm btn-link p-0 ms-2" data-open-event="${item.date}" data-open-title="${escapeHtml(item.title)}">Details</button></div></div>`).join(''));
            }

            function renderLatestEvent() {
                const latest = calendarEvents.filter(item => item.type !== 'class' && item.date >= formatDateKey(today)).sort((a, b) => `${a.date} ${a.start_time || ''}`.localeCompare(`${b.date} ${b.start_time || ''}`))[0];
                if (!latest) {
                    $('#latestCalendarEvent').html('<p class="text-secondary small mb-0">No upcoming events.</p>');
                    return;
                }
                const dot = latest.type === 'holiday' ? 'legend-holiday' : latest.type === 'workshop' ? 'legend-workshop' : latest.type === 'event' ? 'legend-event' : 'legend-class';
                $('#latestCalendarEvent').html(`<div class="calendar-latest-item"><div class="d-flex align-items-start gap-2"><span class="calendar-legend-dot ${dot} mt-2"></span><div class="min-w-0"><div class="fw-semibold">${escapeHtml(latest.title)}</div><div class="small text-secondary mt-1">${formatLongDate(latest.date)}</div><div class="small text-secondary mt-1"><i class="bi bi-clock me-1"></i>${formatTimeRange(latest)}</div><button type="button" class="btn btn-sm btn-link px-0 pb-0" data-open-event="${latest.date}" data-open-title="${escapeHtml(latest.title)}">View details</button></div></div></div>`);
            }

            function openEventDetails(dateKey, title) {
                const item = getEventByDateAndTitle(dateKey, title);
                if (!item) return;
                $('#calendarEventModalLabel').text(item.title);
                $('#calendarEventDetails').html(`<div class="mb-3"><span class="badge rounded-pill ${typeClasses[item.type] || 'event-workshop'} px-3 py-2">${typeLabels[item.type] || 'Event'}</span>${item.status === 'Cancelled' ? '<span class="badge bg-secondary ms-2">Cancelled</span>' : ''}</div><div class="list-group list-group-flush"><div class="list-group-item d-flex justify-content-between gap-3 px-0"><span class="text-secondary">Date</span><strong class="text-end">${formatLongDate(item.date)}</strong></div><div class="list-group-item d-flex justify-content-between gap-3 px-0"><span class="text-secondary">Time</span><strong class="text-end">${formatTimeRange(item)}</strong></div>${item.location ? `<div class="list-group-item d-flex justify-content-between gap-3 px-0"><span class="text-secondary">Location</span><strong class="text-end">${escapeHtml(item.location)}</strong></div>` : ''}<div class="list-group-item px-0"><div class="text-secondary small mb-1">Description</div><div>${escapeHtml(item.description || 'No description provided.')}</div></div></div>`);
                bootstrap.Modal.getOrCreateInstance(document.getElementById('calendarEventModal')).show();
            }

            async function loadCalendarData() {
                const month = `${displayedYear}-${String(displayedMonth + 1).padStart(2, '0')}`;
                try {
                    const response = await fetch(`${calendarDataUrl}?month=${encodeURIComponent(month)}`, {
                        headers: {
                            'Accept': 'application/json'
                        }
                    });
                    const data = await response.json();
                    if (!response.ok) throw new Error(data.message || 'Could not load calendar data.');
                    calendarEvents = data.events || [];
                    renderCalendar();
                } catch (error) {
                    console.error(error);
                    $('#calendarDays').html('<div class="p-4 text-danger small">Unable to load calendar data. Please refresh the page.</div>');
                }
            }

            function toggleHolidayFields() {
                const holiday = $('#calendarEventType').val() === 'Holiday';
                $('#calendarEventTimeFields').toggle(!holiday);
                $('#calendarEventStartTime, #calendarEventEndTime').prop('required', !holiday);
            }

            function openCreateModal() {
                document.getElementById('createCalendarEventForm').reset();
                $('#calendarEventDate').val(selectedDate || formatDateKey(today));
                $('#calendarEventFormError').addClass('d-none').empty();
                toggleHolidayFields();
                bootstrap.Modal.getOrCreateInstance(document.getElementById('createCalendarEventModal')).show();
            }

            function showFormError(message) {
                $('#calendarEventFormError').removeClass('d-none').text(message);
            }
            async function submitEvent(payload) {
                const response = await fetch(calendarStoreUrl, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify(payload)
                });
                return {
                    response,
                    data: await response.json()
                };
            }

            function showConflictModal(data, payload) {
                pendingEventPayload = payload;
                pendingConflictIsHoliday = !!data.is_holiday;
                $('#calendarConflictMessage').text(data.message || 'These class sessions overlap with the event.');
                $('#calendarConflictList').html((data.conflicts || []).map(session => `<div class="list-group-item"><div class="fw-semibold">${escapeHtml(session.class_name)}</div><div class="small text-secondary">${escapeHtml(session.location || 'Location not specified')} · ${formatLongDate(session.date)} · ${formatTime(session.start_time)} – ${formatTime(session.end_time)}</div></div>`).join(''));
                $('#addEventWithoutCancelButton').toggle(!pendingConflictIsHoliday);
                $('#cancelSessionsAndSaveButton').text(pendingConflictIsHoliday ? 'Cancel sessions and add holiday' : 'Cancel sessions and save event');
                $('#calendarConflictNote').text('If any listed session already has attendance records, it cannot be cancelled. No changes will be saved in that case.');
                bootstrap.Modal.getOrCreateInstance(document.getElementById('createCalendarEventModal')).hide();
                bootstrap.Modal.getOrCreateInstance(document.getElementById('calendarConflictModal')).show();
            }
            async function continueAfterConflict(action) {
                if (!pendingEventPayload) return;
                const payload = {
                    ...pendingEventPayload,
                    conflict_action: action
                };
                $('#cancelSessionsAndSaveButton, #addEventWithoutCancelButton').prop('disabled', true);
                try {
                    const result = await submitEvent(payload);
                    if (!result.response.ok) {
                        const message = result.data.message || 'Unable to save this event.';
                        bootstrap.Modal.getOrCreateInstance(document.getElementById('calendarConflictModal')).hide();
                        $('#calendarConflictModal').one('hidden.bs.modal', function() {
                            showFormError(message);
                            bootstrap.Modal.getOrCreateInstance(document.getElementById('createCalendarEventModal')).show();
                        });
                        return;
                    }
                    bootstrap.Modal.getOrCreateInstance(document.getElementById('calendarConflictModal')).hide();
                    pendingEventPayload = null;
                    const selected = new Date(payload.event_date + 'T00:00:00');
                    selectedDate = payload.event_date;
                    displayedYear = selected.getFullYear();
                    displayedMonth = selected.getMonth();
                    await loadCalendarData();
                    alert(result.data.message || 'Event saved successfully.');
                } catch (error) {
                    showFormError('A network error occurred. Please try again.');
                } finally {
                    $('#cancelSessionsAndSaveButton, #addEventWithoutCancelButton').prop('disabled', false);
                }
            }

            $('#previousMonth').on('click', function() {
                displayedMonth--;
                if (displayedMonth < 0) {
                    displayedMonth = 11;
                    displayedYear--;
                }
                selectedDate = formatDateKey(new Date(displayedYear, displayedMonth, 1));
                loadCalendarData();
            });
            $('#nextMonth').on('click', function() {
                displayedMonth++;
                if (displayedMonth > 11) {
                    displayedMonth = 0;
                    displayedYear++;
                }
                selectedDate = formatDateKey(new Date(displayedYear, displayedMonth, 1));
                loadCalendarData();
            });

            function goToToday() {
                displayedYear = today.getFullYear();
                displayedMonth = today.getMonth();
                selectedDate = formatDateKey(today);
                loadCalendarData();
            }
            $('#todayButton, #currentMonthButton').on('click', goToToday);
            $('#addCalendarEventButton').on('click', openCreateModal);
            $('#calendarEventType').on('change', toggleHolidayFields);
            $('#exitCalendarConflictButton').on('click', function() {
                pendingEventPayload = null;
                bootstrap.Modal.getOrCreateInstance(document.getElementById('calendarConflictModal')).hide();
            });
            $('#addEventWithoutCancelButton').on('click', () => continueAfterConflict('add_without_cancel'));
            $('#cancelSessionsAndSaveButton').on('click', () => continueAfterConflict('cancel'));

            $('#createCalendarEventForm').on('submit', async function(event) {
                event.preventDefault();
                const payload = Object.fromEntries(new FormData(this).entries());
                delete payload._token;
                if (payload.event_type === 'Holiday') {
                    payload.start_time = null;
                    payload.end_time = null;
                }
                $('#saveCalendarEventButton').prop('disabled', true);
                $('#calendarEventFormError').addClass('d-none').empty();
                try {
                    const result = await submitEvent(payload);
                    if (result.response.status === 409 && result.data.requires_confirmation) {
                        showConflictModal(result.data, payload);
                        return;
                    }
                    if (!result.response.ok) {
                        const message = result.data.errors ? Object.values(result.data.errors).flat().join(' ') : result.data.message;
                        showFormError(message || 'Unable to save this event.');
                        return;
                    }
                    bootstrap.Modal.getOrCreateInstance(document.getElementById('createCalendarEventModal')).hide();
                    selectedDate = payload.event_date;
                    const selected = new Date(selectedDate + 'T00:00:00');
                    displayedYear = selected.getFullYear();
                    displayedMonth = selected.getMonth();
                    await loadCalendarData();
                } catch (error) {
                    showFormError('A network error occurred. Please try again.');
                } finally {
                    $('#saveCalendarEventButton').prop('disabled', false);
                }
            });

            $('#calendarDays').on('click', '.calendar-day', function(event) {
                if ($(event.target).closest('.calendar-event').length) return;
                selectedDate = $(this).data('date');
                const date = new Date(selectedDate + 'T00:00:00');
                displayedYear = date.getFullYear();
                displayedMonth = date.getMonth();
                renderCalendar();
            });
            $('#calendarDays').on('keydown', '.calendar-day', function(event) {
                if (event.key === 'Enter' || event.key === ' ') {
                    event.preventDefault();
                    $(this).trigger('click');
                }
            });
            $('#calendarDays').on('click', '.calendar-event', function(event) {
                event.stopPropagation();
                openEventDetails($(this).data('event-date'), $(this).data('event-title'));
            });
            $('#selectedDateEvents, #latestCalendarEvent').on('click', '[data-open-event]', function() {
                openEventDetails($(this).data('open-event'), $(this).data('open-title'));
            });
            loadCalendarData();
        });
    </script>
    @endpush
</x-app-layout>