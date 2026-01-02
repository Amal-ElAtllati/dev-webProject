<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord - Administrateur</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f5f5;
            min-height: 100vh;
        }
        
        .header {
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
            color: white;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .header-content {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .header h1 {
            font-size: 24px;
        }
        
        .user-menu {
            display: flex;
            gap: 15px;
            align-items: center;
        }
        
        .user-menu span {
            font-size: 14px;
        }
        
        .btn-logout {
            background: rgba(255,255,255,0.2);
            color: white;
            border: 1px solid rgba(255,255,255,0.3);
            padding: 8px 15px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 14px;
            cursor: pointer;
            transition: background 0.3s;
            position: relative;
            z-index: 10;
        }
        
        .btn-logout:hover {
            background: rgba(255,255,255,0.3);
        }
        
        .container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 0 20px;
        }
        
        .alert {
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
            animation: slideIn 0.3s ease-out;
            position: relative;
            z-index: 1;
        }
        
        .alert-close {
            position: absolute;
            top: 10px;
            right: 15px;
            background: none;
            border: none;
            font-size: 20px;
            cursor: pointer;
            color: inherit;
            opacity: 0.7;
            line-height: 1;
            padding: 0;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .alert-close:hover {
            opacity: 1;
        }
        
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .dashboard-card {
            background: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .dashboard-card h2 {
            color: #333;
            margin-bottom: 15px;
            font-size: 22px;
        }
        
        .dashboard-card p {
            color: #666;
            line-height: 1.6;
        }
        
        .info-box {
            background: #fff3cd;
            padding: 15px;
            border-radius: 8px;
            margin-top: 20px;
            border-left: 4px solid #ffc107;
        }
        
        .info-box strong {
            color: #856404;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="header-content">
            <h1>👑 Tableau de Bord - Administrateur</h1>
            <div class="user-menu">
                <span>👤 {{ Auth::user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn-logout">Déconnexion</button>
                </form>
            </div>
        </div>
    </div>
    
    <div class="container">
        @if(session('success'))
            <div class="alert alert-success" id="successAlert">
                ✅ {{ session('success') }}
                <button type="button" class="alert-close" onclick="document.getElementById('successAlert').style.display='none'">×</button>
            </div>
        @endif
        
        <div class="dashboard-card">
            <h2>Bienvenue, {{ Auth::user()->name }}!</h2>
            <p>Vous êtes connecté en tant qu'<strong>administrateur</strong>.</p>
            
            <div class="info-box">
                <strong>Rôle:</strong> Administrateur<br>
                <strong>Email:</strong> {{ Auth::user()->email }}<br>
                <strong>Statut:</strong> Actif
            </div>
            
            <p style="margin-top: 20px;">
                Depuis ce tableau de bord, vous avez un accès complet à la gestion du système.
            </p>
        </div>
    </div>
</body>
</html>
