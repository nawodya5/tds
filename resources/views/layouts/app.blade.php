<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'TDS Attendance System'))</title>

    {{-- Bootstrap 5.3.8 --}}
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB"
        crossorigin="anonymous">

    {{-- Bootstrap Icons --}}
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.2/font/bootstrap-icons.min.css"
        rel="stylesheet">

    {{-- Momo Trust Display font --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Momo+Trust+Display&display=swap"
        rel="stylesheet">


    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    {{-- DataTables 3.1.4 with Bootstrap 5 integration --}}
    <link
        href="https://cdn.datatables.net/v/bs5/dt-3.1.4/datatables.min.css"
        rel="stylesheet">

    {{-- Select2 --}}
    <link
        href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css"
        rel="stylesheet">

    {{-- Toastr --}}
    <link
        href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css"
        rel="stylesheet">

    {{-- Application styles: load after library styles --}}
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    {{-- Optional page-specific styles --}}
    @stack('styles')
</head>

<body>
    <div class="app-layout">

        @include('layouts.navigation')

        <div class="app-main">

            @isset($header)
            <header class="app-page-header">
                {{ $header }}
            </header>
            @endisset

            <main class="app-page-content">
                {{ $slot }}
            </main>

        </div>
    </div>

    {{-- jQuery: required by Select2 and Toastr --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    {{-- Bootstrap bundle includes Popper; do not load Popper separately --}}
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>

    {{-- DataTables with Bootstrap 5 integration --}}
    <script src="https://cdn.datatables.net/v/bs5/dt-3.1.4/datatables.min.js"></script>

    {{-- Select2 --}}
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    {{-- FullCalendar standard bundle --}}
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@7.1.2/index.global.min.js"></script>

    {{-- Toastr --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"></script>

    {{-- SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.26.25"></script>

    {{-- Custom application and sidebar JavaScript --}}
    <script src="{{ asset('js/app.js') }}"></script>

    {{-- Optional page-specific JavaScript --}}
    @stack('scripts')
</body>

</html>