<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Profile</title>

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

        /* MAIN CARD */
        .card {
            width: 420px;
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.25);
            padding: 30px;
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* HEADER */
        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .avatar {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 50%;
            margin: auto;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            font-size: 28px;
            font-weight: bold;
        }

        h2 {
            margin: 10px 0 5px;
        }

        .subtitle {
            font-size: 13px;
            color: gray;
        }

        /* INPUTS */
        .form-group {
            margin-bottom: 12px;
        }

        label {
            font-size: 13px;
            font-weight: bold;
            color: #444;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
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
        button {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 12px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
            margin-top: 10px;
        }

        button:hover {
            transform: scale(1.03);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        /* BACK LINK */
        .back {
            display: block;
            text-align: center;
            margin-top: 15px;
            font-size: 13px;
            color: #667eea;
            text-decoration: none;
        }

        /* PASSWORD SECTION */
        .section-title {
            font-size: 12px;
            margin: 15px 0 8px;
            color: #666;
            font-weight: bold;
            text-transform: uppercase;
        }
    </style>
</head>

<body>

    <div class="card" x-data="{ show: false }">

        <!-- HEADER -->
        <div class="header">
            <div class="avatar">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <h2>{{ auth()->user()->name }}</h2>
            <div class="subtitle">Manage your account details</div>
        </div>

        <!-- SUCCESS -->
        @if(session('success'))
        <p style="color:green; text-align:center;">{{ session('success') }}</p>
        @endif

        <!-- FORM -->
        <form method="POST" action="{{ route('profile.update') }}">
            @csrf

            <!-- NAME -->
            <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" value="{{ auth()->user()->name }}">
            </div>

            <!-- EMAIL -->
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" value="{{ auth()->user()->email }}">
            </div>

            <!-- PASSWORD SECTION -->
            <div class="section-title">Change Password</div>

            <div class="form-group">
                <label>Current Password</label>
                <input type="password" name="current_password">
            </div>

            <div class="form-group">
                <label>New Password</label>
                <input :type="show ? 'text' : 'password'" name="new_password">
            </div>

            <div class="form-group">
                <label>Confirm Password</label>
                <input :type="show ? 'text' : 'password'" name="new_password_confirmation">
            </div>

            <button type="button" @click="show = !show">
                <span x-text="show ? 'Hide Password' : 'Show Password'"></span>
            </button>

            <button type="submit">Update Profile</button>
        </form>

        <!-- BACK -->
        <a class="back" href="{{ route('dashboard') }}">
            ← Back to Dashboard
        </a>

    </div>

</body>

</html>