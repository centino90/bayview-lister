<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>App</title>

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body class="bg-gray-200">
    <div class="page-wrapper">
    <nav class="p-6 bg-white flex justify-between mb-10">
        <ul class="flex items-center">
            <li>
                <a href="" class="p-3">Dashboard</a>
            </li>
            <li>
                <a href="" class="p-3">Records</a>
            </li>
            <li>
                <a href="" class="p-3">Reports</a>
            </li>
        </ul>
    </nav>
    @yield('content')
    </div>
    <script src="{{ asset('js/app.js') }}"></script>
</body>

</html>