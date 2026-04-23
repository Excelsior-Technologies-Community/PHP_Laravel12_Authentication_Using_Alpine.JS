<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Register</title>

    <script src="//unpkg.com/alpinejs" defer></script>

    <style>
        body {
            background: linear-gradient(135deg, #667eea, #764ba2);
            font-family: Arial;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* CARD */
        .card {
            background: white;
            border-radius: 20px;
            padding: 35px;
            width: 380px;
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

        /* INPUT */
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

        /* TOGGLE PASSWORD */
        .toggle-btn {
            position: absolute;
            right: 12px;
            top: 35px;
            cursor: pointer;
            font-size: 12px;
            color: #667eea;
        }

        /* RELATIVE WRAPPER */
        .relative {
            position: relative;
        }

        /* LINK */
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
            margin-top: 4px;
        }
    </style>
</head>

<body>

    <div class="card" x-data="{ show: false }">

        <h2>Create Account</h2>

        @if(session('success'))
        <p style="color:green; text-align:center;">{{ session('success') }}</p>
        @endif

        <form method="POST" action="{{ route('register.post') }}">
            @csrf

            <!-- NAME -->
            <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" value="{{ old('name') }}" placeholder="Enter your name">
                @error('name') <div class="error">{{ $message }}</div> @enderror
            </div>

            <!-- EMAIL -->
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="Enter your email">
                @error('email') <div class="error">{{ $message }}</div> @enderror
            </div>

            <!-- PASSWORD -->
            <div class="form-group relative">
                <label>Password</label>

                <input :type="show ? 'text' : 'password'" name="password" placeholder="Enter password">

                <span class="toggle-btn" @click="show = !show"
                    x-text="show ? 'Hide' : 'Show'"></span>

                @error('password') <div class="error">{{ $message }}</div> @enderror
            </div>

            <!-- CONFIRM PASSWORD -->
            <div class="form-group">
                <label>Confirm Password</label>
                <input :type="show ? 'text' : 'password'" name="password_confirmation" placeholder="Confirm password">
            </div>

            <button type="submit" class="primary-btn">Register</button>

        </form>

        <p style="text-align:center; margin-top:15px;">
            Already have account? <a href="{{ route('login') }}">Login</a>
        </p>

    </div>

</body>

</html>