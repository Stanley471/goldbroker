<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GoldBrokers Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">

    <nav class="bg-yellow-600 text-black px-6 py-4 flex justify-between">
        <span class="font-bold text-lg">GoldBrokers Admin</span>
        <div class="flex gap-4">
            <a href="{{ route('admin.dashboard') }}" class="hover:underline">Dashboard</a>
            <a href="{{ route('admin.users') }}" class="hover:underline">Users</a>
            <a href="{{ route('admin.orders') }}" class="hover:underline">Orders</a>
            <a href="{{ route('admin.logs') }}" class="hover:underline">Logs</a>
        </div>
    </nav>

    <main class="p-6">
        @yield('content')
    </main>

</body>
</html>