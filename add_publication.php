<?php
session_start();
include('db.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$id_profil = $_SESSION['user_id'];
$titre = $conn->real_escape_string($_POST['titre']);
$contenu = $conn->real_escape_string($_POST['contenu']);

$sql = "INSERT INTO publication (id_profil, titre, contenu, date_publication)
        VALUES ($id_profil, '$titre', '$contenu', NOW())";

$conn->query($sql);

header("Location: profil.php?id=$id_profil");
