<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Ujian Online</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
</head>

<body class="bg-white font-poppins">

    <div class="flex min-h-screen flex-col">
        <header>
            @include('partials.header')
        </header>

        <main class="flex flex-grow items-center justify-center">
            <div class="w-full  p-4 md:p-8">
                @include('components.flash')
                @yield('content')
            </div>
        </main>

        <footer>
            @include('partials.footer')
        </footer>
    </div>

</body>

</html>
