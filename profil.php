<?php
include('db.php');
include('header.php');

if (!isset($_GET['id'])) {
    echo "Profil introuvable.";
    exit;
}

$id_profil = intval($_GET['id']);

// Fetch user info
$sql = "SELECT p.*, d.nom_departement 
        FROM profil p
        JOIN departement d ON p.id_departement = d.id_departement
        WHERE p.id_profil = $id_profil";

$result = $conn->query($sql);
$user = $result->fetch_assoc();

if (!$user) {
    echo "Profil introuvable.";
    exit;
}
?>
<div class="max-w-4xl mx-auto p-6 pt-24">
<div class="max-w-4xl mx-auto p-6 bg-white shadow-md rounded-lg pt-24">
    <div class="flex items-center space-x-6 mb-6">
        <img src="<?php echo $user['photo_profil'] ?: 'default-avatar.png'; ?>" class="w-24 h-24 rounded-full">
        <div>
            <h2 class="text-2xl font-bold"><?php echo $user['prenom'] . " " . $user['nom']; ?></h2>
            <p class="text-gray-600"><?php echo $user['email']; ?></p>
            <p class="text-gray-600"><?php echo $user['nom_departement']; ?></p>
            <p class="text-gray-600">Date de naissance: <?php echo $user['date_naissance']; ?></p>
            <p class="text-gray-400 text-sm">Inscrit depuis: <?php echo $user['date_inscription']; ?></p>
        </div>
    </div>

    </div> <!-- end of user info div -->



    <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $id_profil): ?>
        <a href="edit_profile.php"
        class="inline-block mt-4 px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
            Modifier le profil
        </a>
    <?php endif; ?>

    <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $id_profil): ?>
            <hr class="my-6">
            <h3 class="text-xl font-semibold mb-4">Nouvelle publication</h3>

            <form action="add_publication.php" method="POST">
                <input type="text" name="titre" placeholder="Titre"
                    class="w-full p-2 border rounded mb-3" required>

                <textarea name="contenu" rows="4"
                        class="w-full p-2 border rounded mb-3"
                        placeholder="Quoi de neuf ?" required></textarea>

                <button type="submit"
                        class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                    Publier
                </button>
            </form>
    <?php endif; ?>



    </br>
    <h3 class="text-xl font-semibold mb-4">Les publications</h3>

    <?php
    $pub_sql = "SELECT * FROM publication WHERE id_profil = $id_profil ORDER BY date_publication DESC";
    $pub_result = $conn->query($pub_sql);

    while ($pub = $pub_result->fetch_assoc()) {
        echo "<div class='mb-4 p-4 bg-gray-100 rounded-lg'>";
        echo "<h4 class='font-semibold'>" . $pub['titre'] . "</h4>";
        echo "<p>" . $pub['contenu'] . "</p>";
        echo "<span class='text-sm text-gray-500'>" . $pub['date_publication'] . "</span>";
        echo "</div>";
    }
    ?>
</div>
