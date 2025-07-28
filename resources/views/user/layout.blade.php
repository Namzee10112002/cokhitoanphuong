<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'CÔNG TY TNHH TM DỊCH VỤ KỸ THUẬT TOÀN PHƯƠNG')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="icon" href="data:,">
    <style>
        .nav-item.dropdown:hover .dropdown-menu {
            display: block;
        }
    </style>
    @stack('styles')
</head>

<body>
    {{-- Header --}}
    @include('user.partials.header')

    {{-- Content --}}
    <main>
        @yield('content')
        @include('user.pages.chatbot')
    </main>

    {{-- Footer --}}
    @include('user.partials.footer')

    @stack('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>