<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title>

    <script src="//unpkg.com/alpinejs" defer></script>

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #667eea, #764ba2);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* CARD */
        .card {
            background: white;
            padding: 35px;
            width: 380px;
            border-radius: 20px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.25);
            animation: fadeIn 0.4s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(15px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* TITLE */
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        /* FORM */
        .form-group {
            margin-bottom: 15px;
            display: flex;
            flex-direction: column;
        }

        label {
            font-size: 13px;
            font-weight: bold;
            margin-bottom: 5px;
            color: #333;
        }

        input {
            padding: 10px;
            border-radius: 10px;
            border: 1px solid #ddd;
            outline: none;
            transition: 0.3s;
        }

        input:focus {
            border-color: #667eea;
            box-shadow: 0 0 5px rgba(102, 126, 234, 0.4);
        }

        /* BUTTON */
        button.primary-btn {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 12px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
        }

        button.primary-btn:hover {
            transform: scale(1.03);
        }

        /* PASSWORD TOGGLE */
        .toggle-btn {
            position: absolute;
            right: 12px;
            top: 35px;
            cursor: pointer;
            font-size: 12px;
            color: #667eea;
        }

        /* RELATIVE */
        .relative {
            position: relative;
        }

        /* REMEMBER */
        .remember {
            display: flex;
            align-items: center;
            font-size: 13px;
            margin-bottom: 10px;
        }

        /* LINKS */
        a {
            color: #667eea;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        /* ERROR */
        .error {
            color: red;
            font-size: 12px;
            margin-top: 5px;
        }
    </style>
</head>

<body>

    <!-- LOGIN CARD -->
    <div class="card" x-data="{ show: false }">

        <h2>Welcome Back</h2>

        @if(session('success'))
        <p style="color:green; text-align:center;">{{ session('success') }}</p>
        @endif

        <form method="POST" action="{{ route('login.post') }}">
            @csrf

            <!-- EMAIL -->
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="Enter your email">

                @error('email')
                <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <!-- PASSWORD -->
            <div class="form-group relative">
                <label>Password</label>

                <input :type="show ? 'text' : 'password'"
                    name="password"
                    placeholder="Enter password">

                <span class="toggle-btn" @click="show = !show"
                    x-text="show ? 'Hide' : 'Show'"></span>

                @error('password')
                <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <!-- REMEMBER -->
            <div class="remember">
                <input type="checkbox" name="remember" id="remember">
                <label for="remember" style="margin-left:8px;">Remember Me</label>
            </div>

            <!-- SUBMIT -->
            <button type="submit" class="primary-btn">Login</button>

        </form>

        <p style="text-align:center; margin-top:15px;">
            Don't have account? <a href="{{ route('register') }}">Register</a>
        </p>

    </div>

</body>

</html>