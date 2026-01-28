<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <script src="//unpkg.com/alpinejs" defer></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.3.2/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #89f7fe, #66a6ff);
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
        }

        .card {
            background: white;
            border-radius: 1.5rem;
            padding: 3rem;
            margin-left: 500px;
            margin-top: 40px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 15px 40px rgba(0,0,0,0.2);
        }

        .form-group {
            margin-bottom: 1.5rem;
            display: flex;
            flex-direction: column;
        }

        .form-group label {
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: #374151;
        }

        .form-group input {
            padding: 0.85rem 1rem;
            border-radius: 0.75rem;
            border: 1px solid #ddd;
            transition: all 0.3s;
        }

        .form-group input:focus {
            outline: none;
            border-color: #6366f1;
            box-shadow: 0 0 0 2px rgba(99,102,241,0.3);
        }

        .toggle-btn {
            position: absolute;
            top: 50%;
            right: 1rem;
            transform: translateY(-50%);
            background: none;
            border: none;
            font-weight: 600;
            cursor: pointer;
        }

        button.primary-btn {
            width: 100%;
            background: linear-gradient(90deg, #8b5cf6, #6366f1);
            color: white;
            font-weight: 600;
            padding: 0.85rem;
            border-radius: 0.75rem;
            transition: all 0.3s;
        }

        button.primary-btn:hover {
            opacity: 0.9;
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        }

        .footer-text a {
            color: #8b5cf6;
            font-weight: 600;
            text-decoration: underline;
        }

        .relative-input {
            position: relative;
        }
    </style>
</head>
<body class="flex items-center justify-center">

<!-- Centered Card -->
<div class="card" x-data="{ showPassword: false }">
    <h2 class="text-3xl font-bold text-gray-800 mb-8 text-center">Login</h2>

    @if(session('success'))
        <p class="text-green-600 mb-4 font-medium">{{ session('success') }}</p>
    @endif

    <form method="POST" action="{{ route('login.post') }}">
        @csrf

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" placeholder="Enter your email">
            @error('email') <p class="text-red-500 mt-1 text-sm">{{ $message }}</p> @enderror
        </div>

        <div class="form-group relative relative-input">
            <label for="password">Password</label>
            <input :type="showPassword ? 'text' : 'password'" name="password" id="password" placeholder="Enter password">
            <button type="button" class="toggle-btn" @click="showPassword = !showPassword">
                <span x-text="showPassword ? 'Hide' : 'Show'"></span>
            </button>
            @error('password') <p class="text-red-500 mt-1 text-sm">{{ $message }}</p> @enderror
        </div>

        <button type="submit" class="primary-btn mt-2">Login</button>
    </form>

    <p class="mt-6 text-center text-gray-600 footer-text">
        Don't have an account? <a href="{{ route('register') }}">Register</a>
    </p>
</div>

</body>
</html>
