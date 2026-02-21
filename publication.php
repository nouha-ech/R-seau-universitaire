<?php
include('db.php');
include('header.php');
$id_publication = $_GET['id']; 
$sql = "
SELECT p.id_publication, p.titre, p.contenu, p.date_publication,
       pr.id_profil, pr.nom, pr.prenom, pr.photo_profil,
       m.type_media, m.url_media,
       (SELECT COUNT(*) FROM likes l WHERE l.id_publication = p.id_publication) AS like_count
FROM publication p
JOIN profil pr ON p.id_profil = pr.id_profil
LEFT JOIN media m ON p.id_publication = m.id_publication
WHERE p.id_publication = $id_publication
";

$result = $conn->query($sql);
$post = $result->fetch_assoc();

if ($post) {
    $full_name = $post['prenom'] . " " . $post['nom'];
    $profile_pic = $post['photo_profil'];
    $post_title = $post['titre'];
    $post_content = $post['contenu'];
    $post_media_url = $post['url_media'];
    $like_count = $post['like_count'];
    $post_date = $post['date_publication'];
} else {
    echo "Post not found.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Publication</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">

   
    <div class="max-w-4xl mx-auto p-6 pt-24">
     
        <div class="bg-white shadow-lg rounded-lg p-6 mb-6">

            
            <div class="flex items-center mb-6">
                <img src="<?php echo $profile_pic; ?>" alt="Profile Picture" class="w-14 h-14 rounded-full mr-4">
                <div>
                    <a href="profil.php?id=<?php echo $post['id_profil']; ?>" class="text-xl font-semibold text-gray-700"><?php echo $full_name; ?></a>
                    <p class="text-sm text-gray-500"><?php echo $post_date; ?></p>
                </div>
            </div>

           
            <h2 class="text-3xl font-semibold text-gray-800 mb-4"><?php echo $post_title; ?></h2>
            
           
            <p class="text-gray-700 mb-4"><?php echo $post_content; ?></p>

           
            <?php if ($post_media_url): ?>
                <div class="mb-4">
                    <img src="<?php echo $post_media_url; ?>" alt="Post Media" class="w-full h-auto rounded-lg shadow-md">
                </div>
            <?php endif; ?>

            
            <div class="flex items-center justify-between mb-6">
                <div class="text-gray-600">
                    
                </div>
                <a href="#" class="like-btn flex items-center space-x-1 font-medium" data-id="<?php echo $id_publication; ?>" data-liked="0">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-6 h-6 transition-colors duration-300" fill="none" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 21C12 21 7 16 4 12a5 5 0 019-7c2-2 5-2 7 0a5 5 0 010 7l-7 7z"/>
                    </svg>
                    <span class="like-count"><?php echo $like_count; ?></span>
                    
                </a>

            </div>

            
            <div class="comments mt-6">
                <h3 class="text-2xl font-semibold text-gray-800 mb-4">Comments</h3>

                <form action="comment.php" method="POST" class="mb-6">
                    <textarea name="comment" placeholder="Add a comment..." required class="w-full p-3 border border-gray-300 rounded-lg text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 mb-4" rows="4"></textarea>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">Post Comment</button>
                </form>

                <?php
                $comment_sql = "
                SELECT c.texte, c.date_commentaire, pr.nom, pr.prenom
                FROM commentaire c
                JOIN profil pr ON c.id_profil = pr.id_profil
                WHERE c.id_publication = $id_publication
                ORDER BY c.date_commentaire DESC
                ";
                $comments_result = $conn->query($comment_sql);

                while ($comment = $comments_result->fetch_assoc()) {
                    echo "<div class='comment mb-6 p-4 bg-gray-100 rounded-lg'>";
                    echo "<div class='flex items-center mb-2'>";
                    echo "<strong class='text-gray-800'>" . $comment['prenom'] . " " . $comment['nom'] . "</strong>";
                    echo "<span class='text-sm text-gray-500 ml-2'>" . $comment['date_commentaire'] . "</span>";
                    echo "</div>";
                    echo "<p class='text-gray-700'>" . $comment['texte'] . "</p>";
                    echo "</div>";
                }
                ?>
            </div>
        </div>

    </div>
<script>
    document.querySelectorAll('.like-btn').forEach(button => {
        const heart = button.querySelector('svg');
        const count = button.querySelector('.like-count');

        // check if already liked
        let liked = button.getAttribute('data-liked') === "1";

        button.addEventListener('click', function(e) {
            e.preventDefault();
            if (liked) return; // prevent multiple likes

            const postId = button.getAttribute('data-id');

            fetch(`like.php?id=${postId}`)
                .then(res => res.text())
                .then(data => {
                    console.log(data); // optional
                    // increment like count visually
                    count.textContent = parseInt(count.textContent) + 1;
                    // fill heart red
                    heart.setAttribute('fill', 'red');
                    heart.setAttribute('stroke', 'red');
                    liked = true;
                    button.setAttribute('data-liked', "1");
                })
                .catch(err => console.error(err));
        });
    });
</script>


</body>
</html>
