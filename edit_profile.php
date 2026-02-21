<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flux social de l’université</title>
    <!-- TailwindCSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">        
        <?php
        session_start();
        include('db.php');

        $id_profil = $_SESSION['user_id'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = $conn->real_escape_string($_POST['nom']);
            $prenom = $conn->real_escape_string($_POST['prenom']);
            $email = $conn->real_escape_string($_POST['email']);
            $date_naissance = $_POST['date_naissance'];

            $sql = "UPDATE profil SET nom='$nom', prenom='$prenom', email='$email', date_naissance='$date_naissance' 
                    WHERE id_profil=$id_profil";
            $conn->query($sql);
            header("Location: profil.php?id=$id_profil");
        }

        // Fetch current data
        $sql = "SELECT * FROM profil WHERE id_profil=$id_profil";
        $result = $conn->query($sql);
        $user = $result->fetch_assoc();
        ?>

        <div class="min-h-screen bg-gray-50 flex flex-col items-center justify-start pt-24">
            <h2 class="text-3xl font-bold mb-6 text-gray-800">Modifier le profil</h2>

            <form method="POST" class="w-full max-w-2xl bg-white p-8 rounded-lg shadow-lg space-y-4">
                <div>
                    <label class="block text-gray-700 font-medium mb-1" for="nom">Nom</label>
                    <input type="text" id="nom" name="nom" value="<?php echo $user['nom']; ?>" 
                        class="w-full p-3 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-1" for="prenom">Prénom</label>
                    <input type="text" id="prenom" name="prenom" value="<?php echo $user['prenom']; ?>" 
                        class="w-full p-3 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-1" for="email">Email</label>
                    <input type="email" id="email" name="email" value="<?php echo $user['email']; ?>" 
                        class="w-full p-3 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-1" for="date_naissance">Date de naissance</label>
                    <input type="date" id="date_naissance" name="date_naissance" value="<?php echo $user['date_naissance']; ?>" 
                        class="w-full p-3 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>

                <button type="submit" class="w-full px-4 py-3 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 transition">
                    Enregistrer
                </button>
            </form>
        </div>
</body>
</html>