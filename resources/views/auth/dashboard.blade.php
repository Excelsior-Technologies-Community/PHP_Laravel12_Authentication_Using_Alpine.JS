<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>

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
            background: white;
            width: 420px;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.25);
            text-align: center;
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

        /* AVATAR */
        .avatar {
            width: 70px;
            height: 70px;
            margin: auto;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea, #764ba2);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 26px;
            font-weight: bold;
        }

        /* TEXT */
        h2 {
            margin: 10px 0 5px;
        }

        p {
            color: #555;
            font-size: 14px;
        }

        /* BUTTONS */
        .btn {
            display: block;
            padding: 12px;
            margin: 10px 0;
            border-radius: 12px;
            text-decoration: none;
            color: white;
            font-weight: bold;
            transition: 0.3s;
        }

        .btn:hover {
            transform: scale(1.03);
        }

        .blue {
            background: #4f46e5;
        }

        .green {
            background: #16a34a;
        }

        .red {
            background: #dc2626;
        }

        /* GRID BOXES */
        .grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 10px;
            margin: 20px 0;
        }

        .box {
            padding: 12px;
            border-radius: 12px;
            font-size: 13px;
            font-weight: bold;
            color: white;
        }

        .purple {
            background: #8b5cf6;
        }

        .teal {
            background: #14b8a6;
        }

        .orange {
            background: #f59e0b;
        }
    </style>
</head>

<body>

    <div class="card">

        <!-- AVATAR -->
        <div class="avatar">
            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
        </div>

        <h2>Welcome, {{ auth()->user()->name }}</h2>
        <p>You are successfully logged in 🚀</p>

        <!-- INFO BOXES -->
        <div class="grid">
            <div class="box purple">Profile Management</div>
            <div class="box teal">Secure Login System</div>
            <div class="box orange">Laravel Authentication</div>
        </div>

        <!-- ACTIONS -->
        <a href="{{ route('profile') }}" class="btn blue">Edit Profile</a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="btn red" style="width:100%; border:none; cursor:pointer;">
                Logout
            </button>
        </form>

    </div>

</body>

</html>