# PHP_Laravel12_Authentication_Using_Alpine.JS

## Project Description:

This project is a simple user authentication system built using Laravel 12, Alpine.js, and Tailwind CSS. It demonstrates how to implement user registration, login, protected dashboard, and logout functionality in a clean and modern way.

## Purpose:

This project is designed for beginners and intermediate Laravel developers to understand how authentication works in Laravel 12 without using Laravel Breeze, Jetstream, or other scaffolding tools. It emphasizes manual authentication setup, Blade templates, route protection, and front-end interactivity using Alpine.js.

## Prerequisites:
- PHP >= 8.1
- Composer
- MySQL
- Node.js & npm (optional, for Tailwind build)



## Features:
- User Registration with validation
- User Login with validation
- Protected Dashboard for authenticated users
- Logout functionality
- Password visibility toggle using Alpine.js
- Modern UI with Tailwind CSS



---



# Project Setup 

---

## STEP 1: Create New Laravel 12 Project

### Run Command :

```
composer create-project laravel/laravel PHP_Laravel12_Authentication_Using_Alpine.JS "12.*"

```

### Go inside project:

```
cd PHP_Laravel12_Authentication_Using_Alpine.JS

```

Make sure Laravel 12 is installed successfully.



## STEP 2: Database Configuration

### Open .env file and update database credentials:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=auth_alpine
DB_USERNAME=root
DB_PASSWORD=


```

### Create database:

```
auth_alpine

```


## Step 3: Create User Model and Migration

## Run:

```
php artisan make:model User -m

```


### Open the migration file in database/migrations/xxxx_create_users_table.php and update:

```

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up(): void
{
    Schema::create('users', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('email')->unique();
        $table->string('password');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
   public function down(): void
{
    Schema::dropIfExists('users');
}

};

```


### app/Model/User.php

```

<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}

```


### Run the migration:

```
php artisan migrate

```

Database table users created.




## Step 4: Create AuthController

### Run:

```
php artisan make:controller AuthController

```

### Open app/Http/Controllers/AuthController.php and add:

```

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Show registration form
    public function showRegister()
    {
        return view('auth.register');
    }

    // Handle registration
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('login')->with('success', 'Registration successful! Please login.');
    }

    // Show login form
    public function showLogin()
    {
        return view('auth.login');
    }

    // Handle login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if(Auth::attempt($request->only('email', 'password'))) {
            return redirect()->route('dashboard');
        }

        return back()->withErrors(['email' => 'Invalid credentials'])->withInput();
    }

    // Dashboard (protected)
    public function dashboard()
    {
        return view('auth.dashboard');
    }

    // Logout
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}


```


## Step 5: Setup Routes

### Open routes/web.php and add:

```

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function() { return redirect()->route('login'); });

// Registration
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

// Login
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

// Dashboard (protected)
Route::get('/dashboard', [AuthController::class, 'dashboard'])->middleware('auth')->name('dashboard');

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

```


## STEP 6:Create folder

```
 resources/views/auth

```

### resources/views/auth/register.blade.php:

```

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <script src="//unpkg.com/alpinejs" defer></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.3.2/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #89f7fe, #66a6ff);
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
        }

        .card {
            background: #ffffff;
            border-radius: 1.5rem;
            margin-left: 500px;
            margin-top: 40px;
            padding: 3rem;
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
            background: linear-gradient(90deg, #6366f1, #8b5cf6);
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
            color: #6366f1;
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
    <h2 class="text-3xl font-bold text-gray-800 mb-8 text-center">Create Account</h2>

    @if(session('success'))
        <p class="text-green-600 mb-4 font-medium">{{ session('success') }}</p>
    @endif

    <form method="POST" action="{{ route('register.post') }}">
        @csrf

        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" placeholder="Enter your name">
            @error('name') <p class="text-red-500 mt-1 text-sm">{{ $message }}</p> @enderror
        </div>

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

        <div class="form-group">
            <label for="password_confirmation">Confirm Password</label>
            <input :type="showPassword ? 'text' : 'password'" name="password_confirmation" id="password_confirmation" placeholder="Confirm password">
        </div>

        <button type="submit" class="primary-btn mt-2">Register</button>
    </form>

    <p class="mt-6 text-center text-gray-600 footer-text">
        Already have an account? <a href="{{ route('login') }}">Login</a>
    </p>
</div>

</body>
</html>


```


### resources/views/auth/login.blade.php:

```

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

```

### resources/views/auth/dashboard.blade.php


```

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

```


## Step 7: Run the Application

### Start the server:

```
php artisan serve

```

### Open browser:

```
http://127.0.0.1:8000

```


## So you can see this type Output:


### Register Page:


<img width="1896" height="971" alt="Screenshot 2026-01-28 132052" src="https://github.com/user-attachments/assets/06e1a9b0-40ad-4ff5-bb60-aee86b04b4cf" />


### Login Page:


<img width="1892" height="966" alt="Screenshot 2026-01-28 132121" src="https://github.com/user-attachments/assets/b824defb-3076-4a83-a4e3-bf12238b950e" />


### Dashboard Page:


<img width="1919" height="873" alt="Screenshot 2026-01-28 132310" src="https://github.com/user-attachments/assets/d04c025a-8b12-4cc0-8c88-fb2fd0c1d107" />




---

# Project Folder Structure:

```
PHP_Laravel12_Authentication_Using_Alpine.JS/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   └── AuthController.php      # Handles registration, login, dashboard, logout
│   │   └── Middleware/                 # Contains default Laravel middleware like 'auth'
│   ├── Models/
│   │   └── User.php                     # User model with fillable and hidden attributes
│   └── Providers/                       # Laravel service providers (default)
│
├── bootstrap/
│   └── app.php                          # Laravel bootstrap file
│
├── config/
│   └── app.php, auth.php, etc.          # Laravel configuration files
│
├── database/
│   ├── migrations/
│   │   └── xxxx_create_users_table.php  # Migration to create 'users' table
│   └── factories/                        # Optional: for creating fake data (not used here)
│
├── public/
│   ├── index.php                        # Entry point
│   └── ...                              # Public assets (images, css, js)
│
├── resources/
│   └── views/
│       └── auth/
│           ├── register.blade.php       # User registration page
│           ├── login.blade.php          # User login page
│           └── dashboard.blade.php      # User dashboard page
│
├── routes/
│   └── web.php                           # Web routes for auth system
│
├── storage/                              # Logs, cache, sessions, etc.
├── tests/                                # Optional Laravel test files
├── vendor/                               # Composer dependencies
│
├── .env                                  # Database & environment configuration
├── artisan                               # Laravel CLI
├── composer.json                         # Project dependencies
└── README.md                              # Project description & instructions
```
