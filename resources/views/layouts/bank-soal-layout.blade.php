<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bank Soal</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="bg-white font-poppins">

    <div class="flex min-h-screen flex-col">
        <header>
            @include('partials.header')
        </header>

        <main>
            <div class="w-full p-4 md:p-8">
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
