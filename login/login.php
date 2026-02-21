<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require_once 'includes/db_connect.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $identifier = trim($_POST['identifier']);
    $mot_de_passe = $_POST['mot_de_passe'];

    if (empty($identifier) || empty($mot_de_passe)) {
        $error = "Veuillez remplir tous les champs.";
    } else {
        try {
            $stmt = $pdo->prepare("
                SELECT id_profil, username, nom, prenom, email, mot_de_passe 
                FROM profil 
                WHERE email = :identifier OR username = :identifier
            ");
            $stmt->execute(['identifier' => $identifier]);
            $user = $stmt->fetch();

            if ($user && $mot_de_passe === $user['mot_de_passe']) {
                    $_SESSION['user_id'] = $user['id_profil'];
                    $_SESSION['photo_profil'] = $user['photo_profil']; // make sure 'photo_profil' is selected in SQL
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['nom_complet'] = $user['prenom'] . ' ' . $user['nom'];
                header("Location: http://localhost/proj/home.php");
                exit();
            } else {
                $error = "Identifiant ou mot de passe incorrect.";
            }
        } catch (Exception $e) {
            $error = "Erreur système. Veuillez réessayer.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .login-container {
            background: white;
            padding: 2.5rem;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 420px;
        }
        .login-container h2 {
            text-align: center;
            color: #2563eb;
            margin-bottom: 1.5rem;
        }
        .form-group {
            margin-bottom: 1.2rem;
        }
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: #444;
        }
        .form-group input {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.3s;
        }
        .form-group input:focus {
            outline: none;
            border-color: #2563eb;
        }
        .btn-login {
            width: 100%;
            padding: 0.8rem;
            background: #2563eb;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s;
        }
        .btn-login:hover {
            background: #1d4ed8;
        }
        .links {
            text-align: center;
            margin-top: 1.2rem;
        }
        .links a {
            color: #2563eb;
            text-decoration: none;
            font-weight: 600;
        }
        .links a:hover {
            text-decoration: underline;
        }
        .error {
            background: #fee2e2;
            color: #dc2626;
            padding: 0.75rem;
            border-radius: 8px;
            text-align: center;
            margin-bottom: 1.2rem;
            border: 1px solid #fecaca;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Connexion</h2>

        <?php if (!empty($error)): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label for="identifier">Email ou Nom d'utilisateur</label>
                <input type="text" id="identifier" name="identifier" required>
            </div>
            <div class="form-group">
                <label for="mot_de_passe">Mot de passe</label>
                <input type="password" id="mot_de_passe" name="mot_de_passe" required>
            </div>
            <button type="submit" class="btn-login">Se connecter</button>
        </form>

        <div class="links">
            <a href="register.php">Pas encore inscrit ? Inscrivez-vous</a>
        </div>
    </div>
</body>
</html>