<x-app-layout>
    @section('title', 'Dashboard | TDS Attendance System')

    @push('styles')
    <style>
        .tds-dashboard {
            --tds-purple: #6d4aff;
            --tds-purple-dark: #5032ce;
            --tds-ink: #20243a;
            --tds-muted: #7d8498;
            --tds-border: #edf0f7;
            color: var(--tds-ink);
            font-family: 'Poppins', sans-serif;
        }

        .tds-dashboard .dashboard-heading {
            font-size: clamp(1.45rem, 2.2vw, 2rem);
            font-weight: 700;
            letter-spacing: -0.045em;
            margin-bottom: .35rem;
        }

        .tds-dashboard .dashboard-subtitle {
            color: var(--tds-muted);
            font-size: .9rem;
            margin-bottom: 0;
        }

        .dashboard-date-pill {
            display: inline-flex;
            align-items: center;
            gap: .55rem;
            padding: .7rem 1rem;
            border: 1px solid var(--tds-border);
            border-radius: 14px;
            background: #fff;
            color: #515873;
            font-size: .82rem;
            font-weight: 600;
            box-shadow: 0 6px 20px rgba(37, 40, 80, .035);
        }

        .dashboard-card {
            height: 100%;
            border: 1px solid var(--tds-border);
            border-radius: 20px;
            background: #fff;
            box-shadow: 0 8px 28px rgba(36, 40, 80, .035);
            transition: transform .25s ease, box-shadow .25s ease, border-color .25s ease;
            animation: dashboardRise .55s both;
        }

        .dashboard-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 14px 34px rgba(36, 40, 80, .075);
            border-color: #e4defe;
        }

        .dashboard-card .card-body {
            padding: 1.25rem;
        }

        .dashboard-stat-label {
            color: var(--tds-muted);
            font-size: .78rem;
            font-weight: 600;
            margin-bottom: .55rem;
        }

        .dashboard-stat-value {
            color: var(--tds-ink);
            font-size: clamp(1.55rem, 2.3vw, 2.1rem);
            font-weight: 700;
            line-height: 1.15;
            margin-bottom: .55rem;
            font-variant-numeric: tabular-nums;
        }

        .dashboard-stat-foot {
            color: var(--tds-muted);
            font-size: .72rem;
            line-height: 1.45;
        }

        .dashboard-stat-icon {
            width: 47px;
            height: 47px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 15px;
            font-size: 1.35rem;
            flex-shrink: 0;
        }

        .icon-purple {
            color: #6546e8;
            background: #f0ecff;
        }

        .icon-blue {
            color: #2677d8;
            background: #e9f3ff;
        }

        .icon-green {
            color: #14966a;
            background: #e5f8ef;
        }

        .icon-orange {
            color: #d97706;
            background: #fff3df;
        }

        .icon-pink {
            color: #d34f91;
            background: #ffedf5;
        }

        .icon-cyan {
            color: #0787a8;
            background: #e5f8fc;
        }

        .dashboard-animated-icon {
            animation: iconFloat 3s ease-in-out infinite;
        }

        .dashboard-stat-card:nth-child(2) .dashboard-animated-icon {
            animation-delay: .25s;
        }

        .dashboard-stat-card:nth-child(3) .dashboard-animated-icon {
            animation-delay: .5s;
        }

        .dashboard-stat-card:nth-child(4) .dashboard-animated-icon {
            animation-delay: .75s;
        }

        .dashboard-section-title {
            color: var(--tds-ink);
            font-size: 1rem;
            font-weight: 700;
            margin: 0;
        }

        .dashboard-section-subtitle {
            color: var(--tds-muted);
            font-size: .75rem;
            margin: .3rem 0 0;
        }

        .dashboard-chart-wrap {
            position: relative;
            min-height: 260px;
        }

        .dashboard-chart-wrap canvas {
            width: 100% !important;
            max-height: 285px;
        }

        .dashboard-link {
            color: var(--tds-purple);
            text-decoration: none;
            font-size: .78rem;
            font-weight: 600;
            white-space: nowrap;
        }

        .dashboard-link:hover {
            color: var(--tds-purple-dark);
        }

        .dashboard-progress {
            height: 8px;
            background: #f0eff8;
            border-radius: 99px;
            overflow: hidden;
        }

        .dashboard-progress .progress-bar {
            border-radius: 99px;
            transition: width 1s ease;
        }

        .dashboard-list-item {
            display: flex;
            align-items: flex-start;
            gap: .8rem;
            padding: .9rem 0;
            border-bottom: 1px solid #f0f1f7;
        }

        .dashboard-list-item:last-child {
            border-bottom: 0;
            padding-bottom: 0;
        }

        .dashboard-list-icon {
            width: 39px;
            height: 39px;
            border-radius: 13px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            background: #f2efff;
            color: var(--tds-purple);
            font-size: 1rem;
        }

        .dashboard-list-title {
            font-size: .82rem;
            font-weight: 650;
            color: #30344c;
            margin-bottom: .2rem;
            overflow-wrap: anywhere;
        }

        .dashboard-list-meta {
            color: var(--tds-muted);
            font-size: .72rem;
            line-height: 1.55;
        }

        .dashboard-badge {
            display: inline-flex;
            align-items: center;
            border-radius: 99px;
            padding: .3rem .55rem;
            font-size: .65rem;
            font-weight: 700;
            white-space: nowrap;
        }

        .badge-class {
            color: #5b43ce;
            background: #f0edff;
        }

        .badge-workshop {
            color: #087e8b;
            background: #e5f9fb;
        }

        .badge-event {
            color: #b45309;
            background: #fff3df;
        }

        .badge-holiday {
            color: #be326a;
            background: #ffedf4;
        }

        .dashboard-empty {
            text-align: center;
            padding: 1.5rem .75rem;
            color: var(--tds-muted);
            font-size: .78rem;
        }

        .dashboard-empty i {
            display: block;
            font-size: 1.7rem;
            margin-bottom: .55rem;
            color: #b7b4d0;
        }

        .dashboard-quick-action {
            display: flex;
            align-items: center;
            gap: .8rem;
            padding: .85rem;
            border: 1px solid var(--tds-border);
            border-radius: 15px;
            color: var(--tds-ink);
            text-decoration: none;
            transition: all .2s ease;
            min-height: 70px;
        }

        .dashboard-quick-action:hover {
            border-color: #d8ceff;
            background: #fbfaff;
            transform: translateY(-2px);
            color: var(--tds-purple-dark);
        }

        .dashboard-quick-action .action-icon {
            width: 40px;
            height: 40px;
            border-radius: 13px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            background: #f0ecff;
            color: var(--tds-purple);
            flex-shrink: 0;
        }

        .dashboard-quick-action .action-title {
            font-size: .78rem;
            font-weight: 700;
            margin-bottom: .15rem;
        }

        .dashboard-quick-action .action-desc {
            color: var(--tds-muted);
            font-size: .68rem;
        }

        .dashboard-welcome {
            position: relative;
            overflow: hidden;
            border: 0;
            border-radius: 22px;
            color: #fff;
            background: linear-gradient(115deg, #6545e8 0%, #7d5df3 55%, #9c78ff 100%);
            box-shadow: 0 14px 35px rgba(101, 69, 232, .2);
        }

        .dashboard-welcome:before,
        .dashboard-welcome:after {
            content: '';
            position: absolute;
            border-radius: 50%;
            border: 1px solid rgba(255, 255, 255, .16);
            pointer-events: none;
        }

        .dashboard-welcome:before {
            width: 230px;
            height: 230px;
            right: 8%;
            top: -145px;
        }

        .dashboard-welcome:after {
            width: 310px;
            height: 310px;
            right: -45px;
            bottom: -235px;
        }

        .dashboard-welcome .card-body {
            position: relative;
            z-index: 1;
            padding: 1.5rem 1.6rem;
        }

        .dashboard-welcome-title {
            font-size: clamp(1.25rem, 2.2vw, 1.7rem);
            font-weight: 700;
            letter-spacing: -.035em;
        }

        .dashboard-welcome-text {
            color: rgba(255, 255, 255, .8);
            font-size: .82rem;
            max-width: 540px;
        }

        .dashboard-welcome-emoji {
            font-size: 3.2rem;
            filter: drop-shadow(0 8px 10px rgba(34, 15, 100, .2));
            animation: welcomeDance 3s ease-in-out infinite;
        }

        .dashboard-primary-btn {
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            border-radius: 11px;
            padding: .68rem .9rem;
            background: #fff;
            color: #5f42d7;
            font-size: .78rem;
            font-weight: 700;
            text-decoration: none;
            transition: transform .2s ease, box-shadow .2s ease;
        }

        .dashboard-primary-btn:hover {
            color: #4a2bbd;
            transform: translateY(-2px);
            box-shadow: 0 8px 18px rgba(30, 15, 90, .16);
        }

        .dashboard-stagger>* {
            animation: dashboardRise .55s both;
        }

        .dashboard-stagger>*:nth-child(2) {
            animation-delay: .06s;
        }

        .dashboard-stagger>*:nth-child(3) {
            animation-delay: .12s;
        }

        .dashboard-stagger>*:nth-child(4) {
            animation-delay: .18s;
        }

        @keyframes dashboardRise {
            from {
                opacity: 0;
                transform: translateY(12px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes iconFloat {

            0%,
            100% {
                transform: translateY(0) rotate(0);
            }

            50% {
                transform: translateY(-4px) rotate(-3deg);
            }
        }

        @keyframes welcomeDance {

            0%,
            100% {
                transform: translateY(0) rotate(0deg);
            }

            35% {
                transform: translateY(-5px) rotate(4deg);
            }

            70% {
                transform: translateY(-2px) rotate(-3deg);
            }
        }

        @media (max-width: 767.98px) {
            .tds-dashboard .dashboard-card .card-body {
                padding: 1rem;
            }

            .dashboard-welcome .card-body {
                padding: 1.25rem;
            }

            .dashboard-date-pill {
                width: 100%;
                justify-content: center;
            }

            .dashboard-chart-wrap {
                min-height: 225px;
            }

            .dashboard-welcome-emoji {
                font-size: 2.5rem;
            }
        }

        @media (prefers-reduced-motion: reduce) {

            .tds-dashboard *,
            .tds-dashboard *:before,
            .tds-dashboard *:after {
                animation-duration: .01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: .01ms !important;
                scroll-behavior: auto !important;
            }
        }
    </style>
    @endpush

    <div class="tds-dashboard container-fluid px-3 px-lg-4 py-4">
        {{-- Page heading --}}
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-4">
            <div>
                <div class="text-uppercase small fw-bold mb-2" style="letter-spacing:.12em;color:#8065e8;">TEACHER OVERVIEW</div>
                <h1 class="dashboard-heading">Your dance class at a glance ✨</h1>
                <p class="dashboard-subtitle">A quick look at your students, classes, attendance and payments.</p>
            </div>
            <div class="dashboard-date-pill">
                <i class="bi bi-calendar3" style="color:#7253e8;"></i>
                <span>{{ $today->format('l, d F Y') }}</span>
            </div>
        </div>

        {{-- Welcome banner --}}
        <div class="card dashboard-welcome mb-4">
            <div class="card-body">
                <div class="row align-items-center g-3">
                    <div class="col">
                        <div class="small fw-semibold mb-2" style="color:rgba(255,255,255,.78);">YOUR CLASSROOM, ORGANIZED</div>
                        <h2 class="dashboard-welcome-title mb-2">A little progress every class adds up.</h2>
                        <p class="dashboard-welcome-text mb-3">Keep your class schedule, student attendance and monthly fees in one happy place.</p>
                        <div class="d-flex flex-wrap gap-2">
                            <a href="{{ route('attendance.index') }}" class="dashboard-primary-btn">
                                <i class="bi bi-check2-circle"></i> Take attendance
                            </a>
                            <a href="{{ route('calendar') }}" class="dashboard-primary-btn" style="background:rgba(255,255,255,.16);color:#fff;border:1px solid rgba(255,255,255,.25);">
                                <i class="bi bi-calendar-week"></i> Open calendar
                            </a>
                        </div>
                    </div>
                    <div class="col-auto d-none d-sm-block pe-md-4">
                        <div class="dashboard-welcome-emoji" aria-hidden="true">💃</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Summary cards --}}
        <div class="row g-3 dashboard-stagger mb-4">
            <div class="col-6 col-xl-3 dashboard-stat-card">
                <div class="card dashboard-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start gap-2 mb-3">
                            <div class="dashboard-stat-label">Active students</div>
                            <div class="dashboard-stat-icon icon-purple dashboard-animated-icon"><i class="bi bi-people-fill"></i></div>
                        </div>
                        <div class="dashboard-stat-value" data-count="{{ $totalStudents }}">{{ number_format($totalStudents) }}</div>
                        <div class="dashboard-stat-foot">Students currently marked active</div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-xl-3 dashboard-stat-card">
                <div class="card dashboard-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start gap-2 mb-3">
                            <div class="dashboard-stat-label">Active classes</div>
                            <div class="dashboard-stat-icon icon-blue dashboard-animated-icon"><i class="bi bi-music-note-beamed"></i></div>
                        </div>
                        <div class="dashboard-stat-value" data-count="{{ $totalClasses }}">{{ number_format($totalClasses) }}</div>
                        <div class="dashboard-stat-foot">Classes currently available</div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-xl-3 dashboard-stat-card">
                <div class="card dashboard-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start gap-2 mb-3">
                            <div class="dashboard-stat-label">Today's classes</div>
                            <div class="dashboard-stat-icon icon-orange dashboard-animated-icon"><i class="bi bi-calendar2-check-fill"></i></div>
                        </div>
                        <div class="dashboard-stat-value" data-count="{{ $todaySessions->count() }}">{{ number_format($todaySessions->count()) }}</div>
                        <div class="dashboard-stat-foot">Scheduled sessions today</div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-xl-3 dashboard-stat-card">
                <div class="card dashboard-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start gap-2 mb-3">
                            <div class="dashboard-stat-label">Attendance rate</div>
                            <div class="dashboard-stat-icon icon-green dashboard-animated-icon"><i class="bi bi-graph-up-arrow"></i></div>
                        </div>
                        <div class="dashboard-stat-value"><span data-count="{{ $attendanceRate }}">{{ $attendanceRate }}</span><span style="font-size:1.1rem;">%</span></div>
                        <div class="dashboard-stat-foot">Of attendance records marked today</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Charts --}}
        <div class="row g-3 mb-4">
            <div class="col-12 col-xl-7">
                <div class="card dashboard-card">
                    <div class="card-body">
                        <div class="d-flex flex-wrap align-items-start justify-content-between gap-2 mb-3">
                            <div>
                                <h3 class="dashboard-section-title">Attendance overview</h3>
                                <p class="dashboard-section-subtitle">Present, absent and late records over the last six months</p>
                            </div>
                            <span class="dashboard-stat-icon icon-purple" style="width:38px;height:38px;font-size:1rem;"><i class="bi bi-bar-chart-line-fill"></i></span>
                        </div>
                        <div class="dashboard-chart-wrap"><canvas id="attendanceChart" aria-label="Monthly attendance chart"></canvas></div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-xl-5">
                <div class="card dashboard-card">
                    <div class="card-body">
                        <div class="d-flex flex-wrap align-items-start justify-content-between gap-2 mb-3">
                            <div>
                                <h3 class="dashboard-section-title">Fee collection</h3>
                                <p class="dashboard-section-subtitle">Paid amounts recorded this year</p>
                            </div>
                            <span class="dashboard-stat-icon icon-green" style="width:38px;height:38px;font-size:1rem;"><i class="bi bi-wallet2"></i></span>
                        </div>
                        <div class="mb-3">
                            <div class="dashboard-stat-label mb-1">Collected this month</div>
                            <div class="dashboard-stat-value" style="font-size:1.65rem;">LKR {{ number_format((float) $monthlyCollection, 2) }}</div>
                        </div>
                        <div class="dashboard-chart-wrap" style="min-height:205px;"><canvas id="paymentChart" aria-label="Monthly fee collection chart"></canvas></div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Today's attendance and fee status --}}
        <div class="row g-3 mb-4">
            <div class="col-12 col-lg-5">
                <div class="card dashboard-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start gap-2 mb-4">
                            <div>
                                <h3 class="dashboard-section-title">Today's attendance</h3>
                                <p class="dashboard-section-subtitle">Summary of records marked for today's sessions</p>
                            </div>
                            <span class="dashboard-stat-icon icon-blue" style="width:38px;height:38px;font-size:1rem;"><i class="bi bi-person-check-fill"></i></span>
                        </div>

                        <div class="d-flex align-items-end justify-content-between mb-2">
                            <span class="dashboard-stat-label mb-0">Marked attendance</span>
                            <strong style="font-size:.85rem;">{{ number_format($markedCount) }} records</strong>
                        </div>
                        <div class="dashboard-progress mb-4">
                            <div class="progress-bar" role="progressbar" style="width:{{ $attendanceRate }}%;background:linear-gradient(90deg,#6d4aff,#9b83ff);" aria-valuenow="{{ $attendanceRate }}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>

                        <div class="row g-2">
                            <div class="col-4">
                                <div class="rounded-4 p-3" style="background:#e9f8f0;">
                                    <div class="small mb-1" style="color:#21845d;font-size:.7rem;"><i class="bi bi-check-circle-fill me-1"></i>Present</div>
                                    <div class="fw-bold fs-4" style="color:#16734e;">{{ number_format($presentCount) }}</div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="rounded-4 p-3" style="background:#fff0f0;">
                                    <div class="small mb-1" style="color:#bd4747;font-size:.7rem;"><i class="bi bi-x-circle-fill me-1"></i>Absent</div>
                                    <div class="fw-bold fs-4" style="color:#b93434;">{{ number_format($absentCount) }}</div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="rounded-4 p-3" style="background:#fff5e5;">
                                    <div class="small mb-1" style="color:#b97617;font-size:.7rem;"><i class="bi bi-clock-fill me-1"></i>Late</div>
                                    <div class="fw-bold fs-4" style="color:#a7650b;">{{ number_format($lateCount) }}</div>
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('attendance.index') }}" class="dashboard-link d-inline-flex align-items-center gap-2 mt-4">Open attendance <i class="bi bi-arrow-up-right"></i></a>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-7">
                <div class="card dashboard-card">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between gap-2 mb-2">
                            <div>
                                <h3 class="dashboard-section-title">Monthly fee reminder</h3>
                                <p class="dashboard-section-subtitle">Active student-class registrations without a paid record for {{ $today->format('F') }}</p>
                            </div>
                            <span class="dashboard-stat-icon icon-orange" style="width:38px;height:38px;font-size:1rem;"><i class="bi bi-bell-fill"></i></span>
                        </div>
                        <div class="d-flex flex-wrap align-items-end justify-content-between gap-3 py-3">
                            <div>
                                <div class="dashboard-stat-value mb-1" style="font-size:2.2rem;">{{ number_format($unpaidRegistrations) }}</div>
                                <div class="dashboard-stat-foot">Registration(s) needing payment follow-up</div>
                            </div>
                            <div class="text-end">
                                <div class="dashboard-stat-label mb-1">Paid this month</div>
                                <div class="fw-bold" style="font-size:1.05rem;color:#159267;">LKR {{ number_format((float) $monthlyCollection, 2) }}</div>
                            </div>
                        </div>
                        <div class="rounded-4 p-3 d-flex align-items-start gap-3" style="background:#fff8e9;">
                            <i class="bi bi-lightbulb-fill mt-1" style="color:#d99222;font-size:1.1rem;"></i>
                            <div class="small" style="color:#80612b;line-height:1.6;">A registration is counted here if it has no <strong>Paid</strong> payment record for this month. Confirm payment status before following up.</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Schedule and events --}}
        <div class="row g-3 mb-4">
            <div class="col-12 col-xl-7">
                <div class="card dashboard-card">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between gap-2 mb-2">
                            <div>
                                <h3 class="dashboard-section-title">Today's schedule</h3>
                                <p class="dashboard-section-subtitle">Your class sessions for {{ $today->format('d M') }}</p>
                            </div>
                            <a href="{{ route('class-sessions.index') }}" class="dashboard-link">All sessions <i class="bi bi-arrow-up-right ms-1"></i></a>
                        </div>

                        @forelse ($todaySessions as $session)
                        <div class="dashboard-list-item">
                            <div class="dashboard-list-icon"><i class="bi bi-music-note-list"></i></div>
                            <div class="flex-grow-1 min-w-0">
                                <div class="d-flex flex-wrap justify-content-between align-items-start gap-2">
                                    <div class="dashboard-list-title">{{ $session->classroom?->name ?? 'Class session' }}</div>
                                    <span class="dashboard-badge badge-class">{{ $session->status }}</span>
                                </div>
                                <div class="dashboard-list-meta">
                                    <span><i class="bi bi-clock me-1"></i>{{ $session->start_time ? \Carbon\Carbon::parse($session->start_time)->format('g:i A') : 'Time not set' }}@if($session->end_time) – {{ \Carbon\Carbon::parse($session->end_time)->format('g:i A') }}@endif</span>
                                    @if($session->classroom?->location)
                                    <span class="d-block mt-1"><i class="bi bi-geo-alt me-1"></i>{{ $session->classroom->location->name }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="dashboard-empty"><i class="bi bi-calendar2-check"></i>No class sessions scheduled for today.</div>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="col-12 col-xl-5">
                <div class="card dashboard-card">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between gap-2 mb-2">
                            <div>
                                <h3 class="dashboard-section-title">Coming up</h3>
                                <p class="dashboard-section-subtitle">Upcoming classes, workshops and events</p>
                            </div>
                            <a href="{{ route('calendar') }}" class="dashboard-link">Calendar <i class="bi bi-arrow-up-right ms-1"></i></a>
                        </div>

                        @php
                        $upcomingItems = collect();
                        foreach ($upcomingSessions as $upcomingSession) {
                        $upcomingItems->push([
                        'date' => $upcomingSession->session_date,
                        'time' => $upcomingSession->start_time,
                        'title' => $upcomingSession->classroom?->name ?? 'Class session',
                        'type' => 'Class',
                        'location' => $upcomingSession->classroom?->location?->name,
                        ]);
                        }
                        foreach ($upcomingEvents as $upcomingEvent) {
                        $upcomingItems->push([
                        'date' => $upcomingEvent->event_date,
                        'time' => $upcomingEvent->start_time,
                        'title' => $upcomingEvent->title,
                        'type' => $upcomingEvent->event_type,
                        'location' => null,
                        ]);
                        }
                        $upcomingItems = $upcomingItems->sortBy(fn ($item) => (string) $item['date'] . ' ' . (string) $item['time'])->take(6);
                        @endphp

                        @forelse ($upcomingItems as $item)
                        @php
                        $eventType = strtolower($item['type']);
                        $badgeClass = match ($eventType) {
                        'class' => 'badge-class',
                        'workshop' => 'badge-workshop',
                        'holiday' => 'badge-holiday',
                        default => 'badge-event',
                        };
                        $eventIcon = match ($eventType) {
                        'class' => 'bi-music-note-beamed',
                        'workshop' => 'bi-stars',
                        'holiday' => 'bi-sun-fill',
                        default => 'bi-calendar-event',
                        };
                        @endphp
                        <div class="dashboard-list-item">
                            <div class="dashboard-list-icon"><i class="bi {{ $eventIcon }}"></i></div>
                            <div class="flex-grow-1 min-w-0">
                                <div class="d-flex flex-wrap justify-content-between align-items-start gap-2">
                                    <div class="dashboard-list-title">{{ $item['title'] }}</div>
                                    <span class="dashboard-badge {{ $badgeClass }}">{{ $item['type'] }}</span>
                                </div>
                                <div class="dashboard-list-meta">
                                    <i class="bi bi-calendar3 me-1"></i>{{ \Carbon\Carbon::parse($item['date'])->format('D, d M Y') }}
                                    @if($item['time'])
                                    <span class="ms-2"><i class="bi bi-clock me-1"></i>{{ \Carbon\Carbon::parse($item['time'])->format('g:i A') }}</span>
                                    @endif
                                    @if($item['location'])
                                    <span class="d-block mt-1"><i class="bi bi-geo-alt me-1"></i>{{ $item['location'] }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="dashboard-empty"><i class="bi bi-stars"></i>Nothing upcoming yet. Your schedule is clear!</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        {{-- Quick actions --}}
        <div class="card dashboard-card">
            <div class="card-body">
                <div class="mb-3">
                    <h3 class="dashboard-section-title">Quick actions</h3>
                    <p class="dashboard-section-subtitle">Jump straight to the things you do most often.</p>
                </div>
                <div class="row g-2">
                    <div class="col-12 col-sm-6 col-xl-3">
                        <a href="{{ route('students.index') }}" class="dashboard-quick-action">
                            <span class="action-icon"><i class="bi bi-person-plus-fill"></i></span>
                            <span><span class="action-title d-block">Manage students</span><span class="action-desc">View student records</span></span>
                        </a>
                    </div>
                    <div class="col-12 col-sm-6 col-xl-3">
                        <a href="{{ route('attendance.index') }}" class="dashboard-quick-action">
                            <span class="action-icon" style="background:#e5f8ef;color:#14966a;"><i class="bi bi-clipboard2-check-fill"></i></span>
                            <span><span class="action-title d-block">Take attendance</span><span class="action-desc">Mark a class session</span></span>
                        </a>
                    </div>
                    <div class="col-12 col-sm-6 col-xl-3">
                        <a href="{{ route('classes.index') }}" class="dashboard-quick-action">
                            <span class="action-icon" style="background:#e9f3ff;color:#2677d8;"><i class="bi bi-music-note-list"></i></span>
                            <span><span class="action-title d-block">Manage classes</span><span class="action-desc">Review class schedules</span></span>
                        </a>
                    </div>
                    <div class="col-12 col-sm-6 col-xl-3">
                        <a href="{{ route('calendar') }}" class="dashboard-quick-action">
                            <span class="action-icon" style="background:#fff3df;color:#d97706;"><i class="bi bi-calendar2-event-fill"></i></span>
                            <span><span class="action-title d-block">Open calendar</span><span class="action-desc">Plan events and holidays</span></span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center pt-4 pb-1" style="color:#a0a5b6;font-size:.7rem;">
            Made for your dance classroom <span aria-hidden="true">💜</span>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof Chart === 'undefined') return;

            const chartText = '#7d8498';
            const chartGrid = 'rgba(125, 132, 152, 0.12)';
            const attendanceData = @json($attendanceChart);
            const paymentData = @json($paymentChart);

            Chart.defaults.font.family = "Poppins, sans-serif";
            Chart.defaults.font.size = 11;
            Chart.defaults.color = chartText;
            Chart.defaults.animation.duration = 1000;
            Chart.defaults.animation.easing = 'easeOutQuart';

            const attendanceCanvas = document.getElementById('attendanceChart');
            if (attendanceCanvas) {
                new Chart(attendanceCanvas, {
                    type: 'bar',
                    data: {
                        labels: attendanceData.map(item => item.label),
                        datasets: [{
                                label: 'Present',
                                data: attendanceData.map(item => item.present),
                                backgroundColor: '#7b61ff',
                                borderRadius: 6,
                                borderSkipped: false,
                                maxBarThickness: 22
                            },
                            {
                                label: 'Absent',
                                data: attendanceData.map(item => item.absent),
                                backgroundColor: '#ff8a98',
                                borderRadius: 6,
                                borderSkipped: false,
                                maxBarThickness: 22
                            },
                            {
                                label: 'Late',
                                data: attendanceData.map(item => item.late),
                                backgroundColor: '#ffca70',
                                borderRadius: 6,
                                borderSkipped: false,
                                maxBarThickness: 22
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        interaction: {
                            mode: 'index',
                            intersect: false
                        },
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    usePointStyle: true,
                                    pointStyle: 'circle',
                                    boxWidth: 7,
                                    boxHeight: 7,
                                    padding: 18
                                }
                            },
                            tooltip: {
                                backgroundColor: '#292541',
                                padding: 11,
                                cornerRadius: 9
                            }
                        },
                        scales: {
                            x: {
                                grid: {
                                    display: false
                                },
                                border: {
                                    display: false
                                }
                            },
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    precision: 0
                                },
                                grid: {
                                    color: chartGrid,
                                    drawBorder: false
                                },
                                border: {
                                    display: false
                                }
                            }
                        }
                    }
                });
            }

            const paymentCanvas = document.getElementById('paymentChart');
            if (paymentCanvas) {
                const paymentValues = paymentData.map(item => Number(item.amount || 0));
                const gradient = paymentCanvas.getContext('2d').createLinearGradient(0, 0, 0, 260);
                gradient.addColorStop(0, 'rgba(32, 183, 132, 0.28)');
                gradient.addColorStop(1, 'rgba(32, 183, 132, 0.015)');

                new Chart(paymentCanvas, {
                    type: 'line',
                    data: {
                        labels: paymentData.map(item => item.label),
                        datasets: [{
                            label: 'Collected (LKR)',
                            data: paymentValues,
                            borderColor: '#20b784',
                            backgroundColor: gradient,
                            fill: true,
                            tension: .38,
                            borderWidth: 2.5,
                            pointRadius: 3,
                            pointHoverRadius: 5,
                            pointBackgroundColor: '#fff',
                            pointBorderColor: '#20b784',
                            pointBorderWidth: 2
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                backgroundColor: '#292541',
                                padding: 11,
                                cornerRadius: 9,
                                callbacks: {
                                    label: context => ' LKR ' + Number(context.raw || 0).toLocaleString(undefined, {
                                        minimumFractionDigits: 2,
                                        maximumFractionDigits: 2
                                    })
                                }
                            }
                        },
                        scales: {
                            x: {
                                grid: {
                                    display: false
                                },
                                border: {
                                    display: false
                                }
                            },
                            y: {
                                beginAtZero: true,
                                grid: {
                                    color: chartGrid,
                                    drawBorder: false
                                },
                                border: {
                                    display: false
                                },
                                ticks: {
                                    callback: value => 'LKR ' + Number(value).toLocaleString()
                                }
                            }
                        }
                    }
                });
            }
        });
    </script>
    @endpush
</x-app-layout>