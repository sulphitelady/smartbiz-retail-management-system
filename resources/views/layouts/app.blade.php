<!DOCTYPE html>
<html>
<head>
    <title>SmartBiz</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">

<div class="flex">

    @include('layouts.sidebar')

    <div class="flex-1">

        @include('layouts.topbar')

        <div class="p-6">
            @yield('content')
        </div>

    </div>

</div>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

@stack('scripts')

</body>
</html>