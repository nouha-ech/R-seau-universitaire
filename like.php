include('db.php');

$id_profil = 1; // hardcoded for now
$id_publication = $_GET['id'] ?? null;

if ($id_publication) {
    // check if already liked
    $check = "SELECT * FROM likes WHERE id_profil=$id_profil AND id_publication=$id_publication";
    $res = $conn->query($check);

    if ($res->num_rows == 0) {
        $sql = "INSERT INTO likes (id_profil, id_publication, date_ajout_like)
                VALUES ($id_profil, $id_publication, CURDATE())";

        if ($conn->query($sql)) {
            echo "Like added successfully!";
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        echo "Already liked!";
    }
} else {
    echo "Error: no publication ID provided.";
}
