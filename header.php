<?php
session_start(); 


$is_logged_in = isset($_SESSION['user_id']);
///$profile_photo = 'default-avatar.png';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flux social de l’université</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">

    <header class="bg-white shadow-md py-4 fixed w-full top-0 left-0 z-50">
        <div class="max-w-7xl mx-auto px-6 flex justify-between items-center">

            <!-- Logo Section (left-aligned) -->
            <div class="flex items-center space-x-2">
       
                <span class="text-2xl font-bold text-blue-700">N7LINK</span>
            </div>

            
        <nav class="flex items-center space-x-4">
            <?php if ($is_logged_in): 
                $id = $_SESSION['user_id'];
                $res = $conn->query("SELECT photo_profil FROM profil WHERE id_profil = $id");
                if ($res && $row = $res->fetch_assoc()) {
                    $profile_photo = $row['photo_profil'] ?: $profile_photo;
                }
                ?>
                <!-- Profil -->
                <a href="profil.php?id=<?php echo $_SESSION['user_id']; ?>" class="flex items-center space-x-2">
                    <img src="<?php echo  $profile_photo ?: 'default-avatar.png'; ?>"
                        class="w-10 h-10 rounded-full border-2 border-indigo-600 hover:scale-105 transition">
                    <span class="text-indigo-600 font-medium hover:text-indigo-800"></span>
                </a>

                <!-- Déconnexion -->
                <a href="home.php" class="text-indigo-600 hover:text-indigo-800 font-medium">Accueil</a>

                <!-- Déconnexion -->
                <a href="login/login.php" class="text-indigo-600 hover:text-indigo-800 font-medium">Déconnexion</a>
            <?php else: ?>
                <a href="login/login.php" class="text-indigo-600 hover:text-indigo-800 font-medium">Connexion</a>
                <a href="login/register.php" class="text-indigo-600 hover:text-indigo-800 font-medium">S'inscrire</a>
            <?php endif; ?>
        </nav>

        </div>
    </header>

    
    <div class="max-w-7xl mx-auto px-6 mt-6">
    
    </div>

</body>
</html>
