<?php
session_start();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réseau Social Universitaire</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8fafc;
            color: #1e293b;
        }

        .navbar {
            background-color: white;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar .logo {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: bold;
            font-size: 1.2rem;
            color: #2563eb;
        }

        .navbar .logo img {
            width: 40px;
            height: 40px;
        }

        .navbar nav ul {
            display: flex;
            list-style: none;
            gap: 2rem;
        }

        .navbar nav a {
            text-decoration: none;
            color: #1e293b;
            font-weight: 500;
            transition: color 0.3s;
        }

        .navbar nav a:hover {
            color: #2563eb;
        }

        .navbar .auth-buttons {
            display: flex;
            gap: 1rem;
        }

        .btn {
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 20px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.3s;
        }

        .btn-login {
            background-color: transparent;
            border: 2px solid #2563eb;
            color: #2563eb;
        }

        .btn-login:hover {
            background-color: #2563eb;
            color: white;
        }

        .btn-register {
            background-color: #2563eb;
            color: white;
        }

        .btn-register:hover {
            background-color: #1d4ed8;
        }

        .hero {
            padding: 4rem 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
        }

        .hero-text {
            max-width: 50%;
        }

        .hero-text h1 {
            font-size: 2.5rem;
            color: #1e293b;
            margin-bottom: 1rem;
        }

        .hero-text p {
            font-size: 1.1rem;
            line-height: 1.6;
            margin-bottom: 2rem;
            color: #475569;
        }

        .app-store {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
        }

        .app-store img {
            width: 150px;
            height: auto;
            cursor: pointer;
            transition: transform 0.2s;
        }

        .app-store img:hover {
            transform: scale(1.05);
        }

        .hero-image {
            max-width: 50%;
            text-align: center;
        }

        .hero-image img {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        @media (max-width: 768px) {
            .navbar {
                flex-direction: column;
                padding: 1rem;
            }

            .navbar nav ul {
                margin: 1rem 0;
                gap: 1rem;
            }

            .hero {
                flex-direction: column;
                padding: 2rem 1rem;
            }

            .hero-text {
                max-width: 100%;
                text-align: center;
                margin-bottom: 2rem;
            }

            .hero-image {
                max-width: 100%;
            }
        }
    </style>
</head>
<body>
    <header class="navbar">
        <div class="logo">
            <img src="https://via.placeholder.com/40?text=Logo" alt="Logo">
            Réseau Universitaire
        </div>
        <nav>
            <ul>
                <li><a href="#">Accueil</a></li>
                <li><a href="#">Actualités</a></li>
                <li><a href="#">Départements</a></li>
                <li><a href="#">Communautés</a></li>
                <li><a href="#">À propos</a></li>
            </ul>
        </nav>
        <div class="auth-buttons">
            <a href="login.php" class="btn btn-login">CONNEXION</a>
            <a href="register.php" class="btn btn-register">INSCRIPTION</a>
        </div>
    </header>

    <section class="hero">
        <div class="hero-text">
            <h1>Bienvenue sur le Réseau Social Universitaire</h1>
            <p>Connectez-vous avec vos camarades, partagez vos idées, et collaborez au sein de votre département.</p>
            <div class="app-store">
                <img src="https://via.placeholder.com/150x50?text=Télécharger+sur+l'App+Store" alt="Télécharger sur l'App Store">
                <img src="https://via.placeholder.com/150x50?text=Obtenir+sur+Google+Play" alt="Obtenir sur Google Play">
            </div>
        </div>
        <div class="hero-image">
            <img src="https://via.placeholder.com/500x400?text=Illustration+Réseau+Social" alt="Illustration Réseau Social">
        </div>
    </section>
</body>
</html>