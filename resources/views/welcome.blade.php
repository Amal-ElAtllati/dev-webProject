<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Resource Management') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .welcome-card {
            background: white;
            border-radius: 20px;
            padding: 3rem;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            max-width: 500px;
            width: 100%;
            text-align: center;
        }
        .welcome-title {
            color: #667eea;
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 1rem;
        }
        .welcome-subtitle {
            color: #666;
            font-size: 1.1rem;
            margin-bottom: 2rem;
        }
        .btn-welcome {
            padding: 12px 30px;
            font-size: 1.1rem;
            border-radius: 50px;
            margin: 5px;
            transition: transform 0.2s;
        }
        .btn-welcome:hover {
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <div class="welcome-card">
        <h1 class="welcome-title">Resource Management</h1>
        <p class="welcome-subtitle">Manage your IT resources efficiently</p>
        
        @if(session('success'))
            <div style="background: #d4edda; color: #155724; padding: 15px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #c3e6cb;">
                ✅ {{ session('success') }}
            </div>
        @endif
        
        @auth
            <div class="mt-4">
                <p class="mb-3">Welcome back, {{ Auth::user()->name }}!</p>
                @if(Auth::user()->role === 'admin')
                    <a href="{{ route('dashboard.admin') }}" class="btn btn-primary btn-welcome">
                        Go to Dashboard
                    </a>
                @elseif(Auth::user()->role === 'responsable')
                    <a href="{{ route('dashboard.responsable') }}" class="btn btn-primary btn-welcome">
                        Go to Dashboard
                    </a>
                @else
                    <a href="{{ route('dashboard.user') }}" class="btn btn-primary btn-welcome">
                        Go to Dashboard
                    </a>
                @endif
            </div>
        @else
            <div class="mt-4">
                <a href="{{ route('login') }}" class="btn btn-primary btn-welcome">
                    Login
                </a>
                <a href="{{ route('register') }}" class="btn btn-outline-primary btn-welcome">
                    Register
                </a>
            </div>
        @endauth
    </div>
</body>
</html>

