<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ngekos - {{ $title ?? '' }}</title>

    <link href="{{ asset('css/front/output.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet" />
    @stack('styles')
</head>

<body>
    <div id="Content-Container"
        class="relative flex flex-col w-full max-w-[640px] min-h-screen mx-auto bg-white overflow-x-hidden">
        @yield('section')
    </div>

    @stack('scripts')
</body>

</html>
