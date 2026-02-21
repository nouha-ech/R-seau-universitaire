<?php
include('db.php');
include('header.php');

// Fetch all posts with user info
$sql = "
SELECT p.id_publication, p.titre, p.contenu, p.date_publication,
       pr.id_profil, pr.nom, pr.prenom, pr.photo_profil
FROM publication p
JOIN profil pr ON p.id_profil = pr.id_profil
ORDER BY p.date_publication DESC
";


$result = $conn->query($sql);
?>

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

   
    <div class="max-w-4xl mx-auto p-6 pt-24">
        <h2 class="text-3xl font-semibold text-center text-gray-800 mb-8">Flux social de l’université</h2>

        <?php while ($row = $result->fetch_assoc()) { ?>
           
            <div class="bg-white shadow-lg rounded-lg p-6 mb-6">
                
                            
            <div class="flex items-center mb-4">
                <a href="profil.php?id=<?php echo $row['id_profil']; ?>" class="flex items-center">
                    <img src="<?php echo $row['photo_profil'] ?: 'default-avatar.png'; ?>" 
                        alt="Profile" class="w-12 h-12 rounded-full mr-4">
                    <span class="text-gray-800 font-medium"><?php echo $row['prenom'] . " " . $row['nom']; ?></span>
                </a>
                <p class="text-sm text-gray-500 ml-4"><?php echo $row['date_publication']; ?></p>
            </div>


             
                <h3 class="text-2xl font-semibold text-gray-800 mb-3"><?php echo $row['titre']; ?></h3>

                
                <p class="text-gray-700 mb-4"><?php echo substr($row['contenu'], 0, 150); ?>...</p>

               
                <a href="publication.php?id=<?php echo $row['id_publication']; ?>" class="text-indigo-600 font-medium hover:underline">
                    Lire plus
                </a>
            </div>
        <?php } ?>

    </div>


    
    
