<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#6d45d9">
    <title>{{ \App\Models\Setting::query()->first()?->institute_name ?: config('app.name', 'TDS Attendance') }} — Attendance, beautifully organised</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --purple: #7048df;
            --purple-dark: #4d2bb5;
            --ink: #211b35;
            --muted: #756f87;
            --line: #eeeaf7;
            --surface: #ffffff;
            --soft: #f7f5ff;
        }

        * {
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            margin: 0;
            color: var(--ink);
            background: #fff;
            font-family: 'DM Sans', sans-serif;
            -webkit-font-smoothing: antialiased;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        button,
        a {
            -webkit-tap-highlight-color: transparent;
        }

        .welcome-shell {
            min-height: 100vh;
            overflow: hidden;
            position: relative;
        }

        .top-glow {
            position: absolute;
            z-index: 0;
            pointer-events: none;
            width: 680px;
            height: 680px;
            right: -240px;
            top: -270px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(133, 100, 240, .16), rgba(133, 100, 240, 0) 68%);
        }

        .site-header {
            position: relative;
            z-index: 2;
            max-width: 1200px;
            width: calc(100% - 64px);
            margin: 0 auto;
            min-height: 88px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 24px;
            animation: rise-in .7s ease both;
        }

        .brand {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            min-width: 0;
        }

        .brand-mark {
            width: 44px;
            height: 44px;
            display: grid;
            place-items: center;
            flex: 0 0 44px;
            color: #fff;
            border-radius: 15px;
            background: linear-gradient(145deg, #8c69f4, #5c36c7);
            box-shadow: 0 9px 22px rgba(102, 65, 208, .25);
        }

        .brand-mark img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            border-radius: inherit;
            padding: 5px;
            background: #fff;
        }

        .brand-name {
            font: 800 17px/1.2 'Manrope', sans-serif;
            letter-spacing: -.45px;
            overflow-wrap: anywhere;
        }

        .brand-caption {
            display: block;
            margin-top: 4px;
            color: #89829d;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 1.6px;
            text-transform: uppercase;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .header-link {
            font-size: 13px;
            font-weight: 700;
            color: #5c5470;
            padding: 12px 15px;
            transition: color .2s ease;
        }

        .header-link:hover {
            color: var(--purple);
        }

        .button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            min-height: 48px;
            padding: 0 21px;
            border-radius: 14px;
            border: 1px solid transparent;
            font-size: 13px;
            font-weight: 700;
            transition: transform .22s ease, box-shadow .22s ease, background .22s ease;
            cursor: pointer;
        }

        .button:hover {
            transform: translateY(-2px);
        }

        .button-primary {
            color: #fff;
            background: linear-gradient(135deg, #8058eb, #6238ce);
            box-shadow: 0 10px 22px rgba(103, 65, 207, .22);
        }

        .button-primary:hover {
            box-shadow: 0 14px 28px rgba(103, 65, 207, .3);
        }

        .button-secondary {
            background: #fff;
            color: var(--ink);
            border-color: #e8e2f4;
            box-shadow: 0 4px 12px rgba(38, 24, 72, .04);
        }

        .hero {
            position: relative;
            z-index: 1;
            max-width: 1200px;
            width: calc(100% - 64px);
            margin: 0 auto;
            padding: 76px 0 82px;
            display: grid;
            grid-template-columns: minmax(0, 1.02fr) minmax(420px, .98fr);
            gap: 58px;
            align-items: center;
        }

        .hero-copy {
            animation: rise-in .75s .08s ease both;
        }

        .eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            padding: 8px 12px;
            border: 1px solid #e9e2ff;
            border-radius: 999px;
            color: #6945c9;
            background: #faf8ff;
            font-size: 11px;
            font-weight: 800;
            letter-spacing: .65px;
        }

        .eyebrow-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: #8b6af0;
            box-shadow: 0 0 0 4px #ece5ff;
        }

        h1 {
            max-width: 620px;
            margin: 24px 0 20px;
            font: 800 clamp(42px, 5vw, 66px)/1.09 'Manrope', sans-serif;
            letter-spacing: -3.2px;
        }

        h1 .highlight {
            position: relative;
            z-index: 0;
            color: var(--purple);
            white-space: nowrap;
        }

        h1 .highlight::after {
            content: '';
            position: absolute;
            z-index: -1;
            height: 12px;
            left: 2px;
            right: 1px;
            bottom: 2px;
            background: #e8dfff;
            border-radius: 10px;
            transform: rotate(-1.4deg);
        }

        .hero-description {
            max-width: 490px;
            margin: 0;
            color: var(--muted);
            font-size: 16px;
            line-height: 1.85;
        }

        .hero-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 30px;
        }

        .trust-row {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-top: 30px;
            color: #777087;
            font-size: 12px;
            font-weight: 600;
        }

        .trust-icon {
            width: 29px;
            height: 29px;
            border-radius: 10px;
            display: grid;
            place-items: center;
            color: #6842cb;
            background: #f0eaff;
        }

        .trust-row strong {
            color: #3a3151;
        }

        .visual-area {
            position: relative;
            min-width: 0;
            animation: visual-in .9s .15s ease both;
        }

        .visual-orbit {
            position: absolute;
            width: 450px;
            height: 450px;
            border: 1px solid rgba(135, 105, 221, .13);
            border-radius: 50%;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .visual-orbit::before,
        .visual-orbit::after {
            content: '';
            position: absolute;
            border: 1px solid rgba(135, 105, 221, .12);
            border-radius: 50%;
            inset: 34px;
        }

        .visual-orbit::after {
            inset: 75px;
        }

        .dashboard-card {
            position: relative;
            z-index: 1;
            max-width: 500px;
            margin: 0 auto;
            padding: 23px;
            background: rgba(255, 255, 255, .94);
            border: 1px solid #eee9f8;
            border-radius: 26px;
            box-shadow: 0 30px 80px rgba(49, 31, 95, .13), 0 4px 12px rgba(49, 31, 95, .04);
            transform: rotate(1deg);
        }

        .mock-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }

        .mock-title {
            font: 800 15px 'Manrope', sans-serif;
        }

        .mock-subtitle {
            color: #9992a8;
            font-size: 11px;
            margin-top: 5px;
        }

        .mock-date {
            border-radius: 11px;
            padding: 9px 11px;
            color: #6943cb;
            background: #f3efff;
            font-size: 11px;
            font-weight: 800;
        }

        .mock-stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
            margin: 22px 0 20px;
        }

        .mock-stat {
            padding: 14px 12px;
            border-radius: 15px;
            background: #faf9fd;
            border: 1px solid #f0edf6;
        }

        .mock-stat-label {
            color: #8d859d;
            font-size: 10px;
            font-weight: 600;
        }

        .mock-stat-value {
            margin-top: 8px;
            font: 800 24px 'Manrope', sans-serif;
            letter-spacing: -.8px;
        }

        .mock-stat-note {
            margin-top: 4px;
            color: #7b6aab;
            font-size: 9px;
            font-weight: 700;
        }

        .mock-section-head {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
            font-size: 12px;
            font-weight: 800;
        }

        .mock-section-head span:last-child {
            color: #8b65dc;
            font-size: 10px;
        }

        .student-row {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 11px 0;
            border-top: 1px solid #f2eff7;
        }

        .avatar {
            width: 34px;
            height: 34px;
            flex: 0 0 34px;
            display: grid;
            place-items: center;
            border-radius: 12px;
            font-size: 10px;
            font-weight: 800;
            color: #6340b8;
            background: #eee8ff;
        }

        .avatar.blue {
            color: #3976a8;
            background: #e7f4ff;
        }

        .avatar.gold {
            color: #9c6a21;
            background: #fff2d9;
        }

        .student-info {
            flex: 1;
            min-width: 0;
        }

        .student-name {
            font-size: 11px;
            font-weight: 800;
        }

        .student-detail {
            color: #9a93a7;
            font-size: 10px;
            margin-top: 4px;
        }

        .status-pill {
            padding: 6px 8px;
            border-radius: 999px;
            font-size: 9px;
            font-weight: 800;
            color: #2f916a;
            background: #e9f8f0;
        }

        .status-pill.late {
            color: #a87520;
            background: #fff4dc;
        }

        .floating-note {
            position: absolute;
            z-index: 2;
            display: flex;
            align-items: center;
            gap: 11px;
            padding: 13px 15px;
            background: #fff;
            border: 1px solid #eee8f7;
            border-radius: 16px;
            box-shadow: 0 16px 35px rgba(49, 31, 95, .12);
            animation: float-gently 5s ease-in-out infinite;
        }

        .floating-note.one {
            left: -25px;
            top: 17%;
        }

        .floating-note.two {
            right: -18px;
            bottom: 12%;
            animation-delay: -2.4s;
        }

        .floating-icon {
            width: 34px;
            height: 34px;
            display: grid;
            place-items: center;
            border-radius: 11px;
            background: #eaf9f1;
            color: #289a6b;
        }

        .floating-icon.purple {
            color: #744bda;
            background: #f0eaff;
        }

        .floating-label {
            color: #8d859e;
            font-size: 9px;
            font-weight: 600;
        }

        .floating-value {
            margin-top: 3px;
            font-size: 12px;
            font-weight: 800;
        }

        .features-wrap {
            background: linear-gradient(180deg, #fbfaff 0%, #fff 100%);
            border-top: 1px solid #f2eefb;
        }

        .features {
            max-width: 1200px;
            width: calc(100% - 64px);
            margin: 0 auto;
            padding: 62px 0 72px;
        }

        .section-heading {
            text-align: center;
            max-width: 550px;
            margin: 0 auto 34px;
        }

        .section-kicker {
            color: #7b57d5;
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        h2 {
            margin: 11px 0 10px;
            font: 800 clamp(25px, 3vw, 34px)/1.25 'Manrope', sans-serif;
            letter-spacing: -1.1px;
        }

        .section-heading p {
            margin: 0;
            color: var(--muted);
            font-size: 13px;
            line-height: 1.8;
        }

        .feature-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 17px;
        }

        .feature-card {
            padding: 24px;
            background: #fff;
            border: 1px solid #eeeaf7;
            border-radius: 20px;
            transition: transform .25s ease, box-shadow .25s ease, border-color .25s ease;
        }

        .feature-card:hover {
            transform: translateY(-5px);
            border-color: #ddd1ff;
            box-shadow: 0 18px 35px rgba(60, 39, 111, .07);
        }

        .feature-icon {
            width: 43px;
            height: 43px;
            display: grid;
            place-items: center;
            border-radius: 14px;
            color: #7149d7;
            background: #f1ecff;
        }

        .feature-card:nth-child(2) .feature-icon {
            color: #268c70;
            background: #e8f8f1;
        }

        .feature-card:nth-child(3) .feature-icon {
            color: #b27a28;
            background: #fff4df;
        }

        .feature-card h3 {
            margin: 19px 0 8px;
            font: 800 15px 'Manrope', sans-serif;
        }

        .feature-card p {
            margin: 0;
            color: #7e778e;
            font-size: 12px;
            line-height: 1.8;
        }

        .site-footer {
            max-width: 1200px;
            width: calc(100% - 64px);
            margin: 0 auto;
            padding: 22px 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            color: #958da5;
            font-size: 11px;
            border-top: 1px solid #f0edf7;
        }

        .footer-brand {
            color: #6d48c9;
            font-weight: 800;
        }

        @keyframes rise-in {
            from {
                opacity: 0;
                transform: translateY(18px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes visual-in {
            from {
                opacity: 0;
                transform: translateX(22px) scale(.98);
            }

            to {
                opacity: 1;
                transform: translateX(0) scale(1);
            }
        }

        @keyframes float-gently {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-8px);
            }
        }

        @media (max-width: 1000px) {
            .hero {
                grid-template-columns: minmax(0, 1fr) minmax(360px, .9fr);
                gap: 30px;
                padding-top: 55px;
            }

            h1 {
                letter-spacing: -2.4px;
            }

            .floating-note.one {
                left: -10px;
            }

            .floating-note.two {
                right: -8px;
            }
        }

        @media (max-width: 760px) {

            .site-header,
            .hero,
            .features,
            .site-footer {
                width: calc(100% - 36px);
            }

            .site-header {
                min-height: 76px;
            }

            .brand-name {
                font-size: 15px;
            }

            .header-link {
                padding: 10px 6px;
            }

            .header-right {
                gap: 4px;
            }

            .header-right .button {
                min-height: 42px;
                padding: 0 13px;
                font-size: 12px;
            }

            .hero {
                grid-template-columns: 1fr;
                gap: 48px;
                padding: 48px 0 62px;
            }

            h1 {
                max-width: 580px;
                font-size: clamp(42px, 10vw, 60px);
                letter-spacing: -2.6px;
            }

            .hero-description {
                font-size: 14px;
            }

            .visual-area {
                max-width: 520px;
                width: 100%;
                margin: 0 auto;
            }

            .dashboard-card {
                padding: 18px;
            }

            .visual-orbit {
                width: 360px;
                height: 360px;
            }

            .floating-note.one {
                left: -7px;
                top: 13%;
            }

            .floating-note.two {
                right: -4px;
                bottom: 8%;
            }

            .features {
                padding: 48px 0 55px;
            }

            .feature-grid {
                grid-template-columns: 1fr;
            }

            .feature-card {
                padding: 21px;
            }

            .site-footer {
                align-items: flex-start;
                flex-direction: column;
            }
        }

        @media (max-width: 420px) {
            .brand-mark {
                width: 38px;
                height: 38px;
                flex-basis: 38px;
                border-radius: 13px;
            }

            .brand-caption {
                font-size: 8px;
                letter-spacing: 1px;
            }

            .header-link {
                font-size: 12px;
            }

            .header-right .button {
                padding: 0 10px;
            }

            .mock-stats {
                gap: 6px;
            }

            .mock-stat {
                padding: 11px 8px;
            }

            .mock-stat-value {
                font-size: 20px;
            }

            .floating-note {
                padding: 10px;
            }

            .floating-note.one {
                left: -4px;
            }

            .floating-note.two {
                right: -3px;
            }
        }

        @media (prefers-reduced-motion: reduce) {

            *,
            *::before,
            *::after {
                scroll-behavior: auto !important;
                animation-duration: .01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: .01ms !important;
            }
        }
    </style>
</head>

<body>
    @php
    $welcomeSettings = \App\Models\Setting::query()->first();
    $welcomeBrandName = $welcomeSettings?->institute_name ?: config('app.name', 'TDS Attendance');
    @endphp
    <div class="welcome-shell">
        <div class="top-glow"></div>
        <header class="site-header">
            <a class="brand" href="{{ url('/') }}" aria-label="{{ $welcomeBrandName }} home">
                <span class="brand-mark">
                    @if ($welcomeSettings?->logo)
                    <img src="{{ asset('storage/' . $welcomeSettings->logo) }}" alt="{{ $welcomeBrandName }} logo">
                    @else
                    <svg width="25" height="25" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <rect x="4" y="5" width="16" height="16" rx="3" stroke="currentColor" stroke-width="1.8" />
                        <path d="M8 3v4M16 3v4M4 10h16M8 14h3M8 17h6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" />
                    </svg>
                    @endif
                </span>
                <span><span class="brand-name">{{ $welcomeBrandName }}</span><span class="brand-caption">Attendance management</span></span>
            </a>
            <nav class="header-right" aria-label="Main navigation">
                @auth
                <a class="header-link" href="{{ route('dashboard') }}">Dashboard</a>
                <a class="button button-primary" href="{{ route('dashboard') }}">Open dashboard
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </a>
                @else
                @if (Route::has('login'))
                <a class="header-link" href="{{ route('login') }}">Log in</a>
                @endif
                @if (Route::has('register'))
                <a class="button button-primary" href="{{ route('register') }}">Get started
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </a>
                @endif
                @endauth
            </nav>
        </header>

        <main>
            <section class="hero">
                <div class="hero-copy">
                    <div class="eyebrow"><span class="eyebrow-dot"></span> YOUR CLASSES, IN PERFECT SYNC</div>
                    <h1>More time to teach.<br><span class="highlight">Less time managing.</span></h1>
                    <p class="hero-description">
                        Keep your students, class schedules, attendance and monthly payments in one calm, organised space. Everything you need to run your classes — without the paperwork.
                    </p>
                    <div class="hero-actions">
                        @auth
                        <a class="button button-primary" href="{{ route('dashboard') }}">Go to your dashboard
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </a>
                        @else
                        @if (Route::has('login'))
                        <a class="button button-primary" href="{{ route('login') }}">Sign in to continue
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </a>
                        @endif
                        @if (Route::has('register'))
                        <a class="button button-secondary" href="{{ route('register') }}">Create an account</a>
                        @endif
                        @endauth
                    </div>
                    <div class="trust-row">
                        <span class="trust-icon">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <path d="m5 12 4 4L19 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </span>
                        <span><strong>Simple by design.</strong> Built around your teaching day.</span>
                    </div>
                </div>

                <div class="visual-area" aria-label="Illustration of the attendance dashboard">
                    <div class="visual-orbit"></div>
                    <div class="dashboard-card">
                        <div class="mock-top">
                            <div>
                                <div class="mock-title">Class overview</div>
                                <div class="mock-subtitle">A quick look at your teaching day</div>
                            </div>
                            <div class="mock-date">THIS WEEK</div>
                        </div>
                        <div class="mock-stats">
                            <div class="mock-stat">
                                <div class="mock-stat-label">Students</div>
                                <div class="mock-stat-value">48</div>
                                <div class="mock-stat-note">Registered</div>
                            </div>
                            <div class="mock-stat">
                                <div class="mock-stat-label">Attendance</div>
                                <div class="mock-stat-value">92<span style="font-size:13px">%</span></div>
                                <div class="mock-stat-note">This month</div>
                            </div>
                            <div class="mock-stat">
                                <div class="mock-stat-label">Classes</div>
                                <div class="mock-stat-value">12</div>
                                <div class="mock-stat-note">Scheduled</div>
                            </div>
                        </div>
                        <div class="mock-section-head"><span>Recent attendance</span><span>View records ↗</span></div>
                        <div class="student-row">
                            <div class="avatar">AM</div>
                            <div class="student-info">
                                <div class="student-name">Amaya M.</div>
                                <div class="student-detail">Monday class · 4:00 PM</div>
                            </div><span class="status-pill">Present</span>
                        </div>
                        <div class="student-row">
                            <div class="avatar blue">SK</div>
                            <div class="student-info">
                                <div class="student-name">Senuri K.</div>
                                <div class="student-detail">Monday class · 4:00 PM</div>
                            </div><span class="status-pill">Present</span>
                        </div>
                        <div class="student-row">
                            <div class="avatar gold">TH</div>
                            <div class="student-info">
                                <div class="student-name">Tharushi H.</div>
                                <div class="student-detail">Monday class · 4:00 PM</div>
                            </div><span class="status-pill late">Late</span>
                        </div>
                    </div>
                    <div class="floating-note one">
                        <span class="floating-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <path d="m5 12 4 4L19 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </span>
                        <span><span class="floating-label">Attendance saved</span><span class="floating-value" style="display:block">All set for today</span></span>
                    </div>
                    <div class="floating-note two">
                        <span class="floating-icon purple">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <rect x="3" y="5" width="18" height="16" rx="2" stroke="currentColor" stroke-width="1.8" />
                                <path d="M16 3v4M8 3v4M3 10h18" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" />
                            </svg>
                        </span>
                        <span><span class="floating-label">Your schedule</span><span class="floating-value" style="display:block">Clear and up to date</span></span>
                    </div>
                </div>
            </section>

            <section class="features-wrap">
                <div class="features">
                    <div class="section-heading">
                        <div class="section-kicker">Everything in one place</div>
                        <h2>Spend your energy where it matters.</h2>
                        <p>Less admin to worry about. More clarity before, during and after every class.</p>
                    </div>
                    <div class="feature-grid">
                        <article class="feature-card">
                            <div class="feature-icon">
                                <svg width="21" height="21" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                    <path d="M8 3v3M16 3v3M4 9h16M6 5h12a2 2 0 0 1 2 2v12H4V7a2 2 0 0 1 2-2Z" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="m8 14 2 2 5-5" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </div>
                            <h3>Attendance made simple</h3>
                            <p>Mark attendance quickly, review past sessions and keep a reliable record of every student's participation.</p>
                        </article>
                        <article class="feature-card">
                            <div class="feature-icon">
                                <svg width="21" height="21" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                    <path d="M16 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2M10 11a4 4 0 1 0 0-8 4 4 0 0 0 0 8ZM20 8v6M23 11h-6" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </div>
                            <h3>Student details, organised</h3>
                            <p>Keep registrations, class assignments and student information easy to find whenever you need them.</p>
                        </article>
                        <article class="feature-card">
                            <div class="feature-icon">
                                <svg width="21" height="21" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                    <rect x="3" y="5" width="18" height="14" rx="2" stroke="currentColor" stroke-width="1.7" />
                                    <path d="M3 10h18M7 15h3M16 15h1" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" />
                                </svg>
                            </div>
                            <h3>Payments with clarity</h3>
                            <p>Track monthly class fees and payment status so you can follow up confidently and stay organised.</p>
                        </article>
                    </div>
                </div>
            </section>
        </main>

        <footer class="site-footer">
            <span>© {{ date('Y') }} <span class="footer-brand">{{ $welcomeBrandName }}</span>. Made for smoother class days.</span>
            <span>Organised classes. Clear records. More peace of mind.</span>
        </footer>
    </div>
</body>

</html>