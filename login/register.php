<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require_once 'includes/db_connect.php';

$error = '';
$success = '';

$stmt = $pdo->query("SELECT id_departement, nom_departement FROM departement ORDER BY nom_departement");
$departements = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom']);
    $prenom = trim($_POST['prenom']);
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $mot_de_passe = $_POST['mot_de_passe'];
    $confirm_mot_de_passe = $_POST['confirm_mot_de_passe'];
    $id_departement = $_POST['id_departement'];

    if (empty($nom) || empty($prenom) || empty($username) || empty($email) || empty($mot_de_passe) || empty($confirm_mot_de_passe) || empty($id_departement)) {
        $error = "Tous les champs sont obligatoires.";
    } elseif ($mot_de_passe !== $confirm_mot_de_passe) {
        $error = "Les mots de passe ne correspondent pas.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Email invalide.";
    } else {
        try {
            $check = $pdo->prepare("SELECT id_profil FROM profil WHERE username = ? OR email = ?");
            $check->execute([$username, $email]);
            if ($check->fetch()) {
                $error = "Ce nom d'utilisateur ou cet email est déjà utilisé.";
            } else {
                $insert = $pdo->prepare("
                    INSERT INTO profil 
                    (id_departement, nom, prenom, username, email, mot_de_passe, date_inscription)
                    VALUES (?, ?, ?, ?, ?, ?, CURDATE())
                ");
                $insert->execute([
                    $id_departement, $nom, $prenom, $username, $email, $mot_de_passe
                ]);
                $success = "Inscription réussie ! Vous pouvez maintenant vous connecter.";
            }
        } catch (Exception $e) {
            $error = "Erreur lors de l'inscription. Veuillez réessayer.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - Réseau Social Universitaire</title>
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
        .register-container {
            background: white;
            padding: 2.5rem;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 450px;
        }
        .register-container h2 {
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
        .form-group input,
        .form-group select {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 1rem;
        }
        .btn-submit {
            width: 100%;
            padding: 0.8rem;
            background: #2563eb;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
        }
        .btn-submit:hover {
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
        .error {
            background: #fee2e2;
            color: #dc2626;
            padding: 0.75rem;
            border-radius: 8px;
            text-align: center;
            margin-bottom: 1.2rem;
            border: 1px solid #fecaca;
        }
        .success {
            background: #dcfce7;
            color: #166534;
            padding: 0.75rem;
            border-radius: 8px;
            text-align: center;
            margin-bottom: 1.2rem;
            border: 1px solid #bbf7d0;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <h2>Créer un compte</h2>

        <?php if (!empty($error)): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <?php if (!empty($success)): ?>
            <div class="success"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label for="nom">Nom</label>
                <input type="text" id="nom" name="nom" required>
            </div>
            <div class="form-group">
                <label for="prenom">Prénom</label>
                <input type="text" id="prenom" name="prenom" required>
            </div>
            <div class="form-group">
                <label for="username">Nom d'utilisateur</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="mot_de_passe">Mot de passe</label>
                <input type="password" id="mot_de_passe" name="mot_de_passe" required>
            </div>
            <div class="form-group">
                <label for="confirm_mot_de_passe">Confirmer le mot de passe</label>
                <input type="password" id="confirm_mot_de_passe" name="confirm_mot_de_passe" required>
            </div>
            <div class="form-group">
                <label for="id_departement">Département</label>
                <select id="id_departement" name="id_departement" required>
                    <option value="">Sélectionnez un département</option>
                    <?php foreach ($departements as $dept): ?>
                        <option value="<?= $dept['id_departement'] ?>">
                            <?= htmlspecialchars($dept['nom_departement']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn-submit">S'inscrire</button>
        </form>

        <div class="links">
            <a href="login.php">Déjà inscrit ? Connectez-vous</a>
        </div>
    </div>
</body>
</html>