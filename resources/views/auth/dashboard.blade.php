<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <script src="//unpkg.com/alpinejs" defer></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.3.2/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #89f7fe, #66a6ff);
            font-family: 'Poppins', sans-serif;
        }

        .card {
            background: white;
            border-radius: 1.5rem;
            padding: 3rem 2rem;
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
            text-align: center;
            margin-left: 500px;
            margin-top: 40px;
            max-width: 450px;
            width: 100%;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 25px 50px rgba(0,0,0,0.25);
        }

        .btn-logout {
            width: 100%;
            padding: 0.85rem;
            border-radius: 0.75rem;
            font-weight: 600;
            background: linear-gradient(90deg, #f43f5e, #e11d48);
            color: white;
            transition: all 0.3s;
        }

        .btn-logout:hover {
            opacity: 0.9;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.2);
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen">

<!-- Dashboard Card -->
<div class="card">
    <h2 class="text-3xl font-extrabold text-gray-800 mb-4">Welcome, {{ auth()->user()->name }}!</h2>
    <p class="text-gray-600 mb-6">You have successfully logged in. Enjoy your dashboard experience.</p>

    <div class="mb-6">
        <!-- You can add more dashboard content here -->
        <div class="grid grid-cols-1 gap-4">
            <div class="bg-indigo-100 p-4 rounded-lg font-medium text-indigo-700">Profile Settings</div>
            <div class="bg-green-100 p-4 rounded-lg font-medium text-green-700">My Orders</div>
            <div class="bg-yellow-100 p-4 rounded-lg font-medium text-yellow-700">Notifications</div>
        </div>
    </div>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="btn-logout">Logout</button>
    </form>
</div>

</body>
</html>
